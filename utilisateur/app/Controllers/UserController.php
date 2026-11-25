<?php


class UserController extends Controller
{
    protected string $page = 'users';
    private AuthController $auth;

    private const SORTS = [
        'recent' => 'created_at DESC',
        'ancien' => 'created_at ASC',
        'nom'    => 'nom ASC, prenom ASC',
        'email'  => 'email ASC',
        'role'   => 'role ASC, nom ASC',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->auth = new AuthController();
    }

    
    
    
    public function index(): void
    {
        AuthController::requirePermission('users.view');

        $filters = $this->readFilters($_GET);
        $total   = $this->countUsers($filters);
        $pages   = max(1, (int) ceil($total / USERS_PER_PAGE));
        $page    = min(max(1, (int) ($_GET['page'] ?? 1)), $pages);

        $this->render('back/users/index', [
            'title'   => 'Utilisateurs',
            'users'   => $this->findUsers($filters, USERS_PER_PAGE, ($page - 1) * USERS_PER_PAGE),
            'filters' => $filters,
            'total'   => $total,
            'page'    => $page,
            'pages'   => $pages,
            'stats'   => $this->stats(),
        ], 'admin');
    }

    
    
    
    public function create(): void
    {
        AuthController::requirePermission('users.create');

        $errors = [];
        $old = ['role' => 'client', 'statut' => 'actif'];

        if ($this->isPost()) {
            $this->requireCsrf();
            $old = $this->keepOld($_POST);

            [$errors, $data] = $this->auth->validateUserInput($_POST, [
                'roles'            => can('users.role') ? AuthController::ALL_ROLES : AuthController::PUBLIC_ROLES,
                'statut'           => true,
                'passwordRequired' => true,
            ]);

            if (empty($errors)) {
                $user = new UserModel();
                $this->fill($user, $data);
                $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

                if ($this->auth->insertUser($user)) {
                    flash('success', 'Le compte de ' . $data['prenom'] . ' ' . $data['nom'] . ' a été créé.');
                    redirect('users');
                }
                $errors['_global'] = 'Une erreur est survenue lors de la création.';
            }
        }

        $this->render('back/users/form', [
            'title'        => 'Ajouter un utilisateur',
            'mode'         => 'create',
            'errors'       => $errors,
            'old'          => $old,
            'user'         => null,
            
        ], 'admin');
    }

    
    
    
    public function show(): void
    {
        AuthController::requirePermission('users.view');
        $user = $this->findOr404();

        $this->render('back/users/show', [
            'title' => $user->getPrenom() . ' ' . $user->getNom(),
            'user'  => $user,
            'isMe'  => $user->getId() === (int) $_SESSION['user_id'],
        ], 'admin');
    }

    
    
    
    public function edit(): void
    {
        AuthController::requirePermission('users.edit');
        $user = $this->findOr404();
        $isMe = $user->getId() === (int) $_SESSION['user_id'];

        $errors = [];
        $old = [
            'nom' => $user->getNom(), 'prenom' => $user->getPrenom(), 'username' => $user->getUsername(),
            'email' => $user->getEmail(), 'telephone' => $user->getTelephone(),
            'role' => $user->getRole(), 'statut' => $user->getStatut(),
        ];

        if ($this->isPost()) {
            $this->requireCsrf();
            $old = $this->keepOld($_POST);

            [$errors, $data] = $this->auth->validateUserInput($_POST, [
                'roles'            => can('users.role') ? AuthController::ALL_ROLES : [$user->getRole()],
                'statut'           => true,
                'passwordRequired' => false,
                'excludeId'        => $user->getId(),
            ]);

            
            if ($isMe && ($data['role'] ?? '') !== $user->getRole()) {
                $errors['role'] = 'Vous ne pouvez pas modifier votre propre rôle.';
            }
            if ($isMe && ($data['statut'] ?? '') === 'bloque') {
                $errors['statut'] = 'Vous ne pouvez pas bloquer votre propre compte.';
            }
            if ($user->getRole() === 'admin' && ($data['role'] ?? '') !== 'admin' && $this->auth->countByRole('admin') <= 1) {
                $errors['role'] = 'Impossible : ParkShare doit garder au moins un administrateur.';
            }

            if (empty($errors)) {
                $this->fill($user, $data);
                $newPassword = $data['password'] !== '' ? password_hash($data['password'], PASSWORD_DEFAULT) : null;
                $this->updateUser($user, $newPassword);
                flash('success', 'Les informations de ' . $data['prenom'] . ' ' . $data['nom'] . ' ont été mises à jour.');
                redirect('user_show', ['id' => $user->getId()]);
            }
        }

        $this->render('back/users/form', [
            'title'        => 'Modifier un utilisateur',
            'mode'         => 'edit',
            'errors'       => $errors,
            'old'          => $old,
            'user'         => $user,
            'isMe'         => $isMe,
            
        ], 'admin');
    }

    
    
    
    public function delete(): void
    {
        AuthController::requirePermission('users.delete');
        $this->requirePost();
        $this->requireCsrf();

        $user = $this->findOr404((int) ($_POST['id'] ?? 0));

        if ($user->getId() === (int) $_SESSION['user_id']) {
            flash('error', 'Vous ne pouvez pas supprimer votre propre compte depuis la liste.');
        } elseif ($user->getRole() === 'admin' && $this->auth->countByRole('admin') <= 1) {
            flash('error', 'Impossible de supprimer le dernier administrateur.');
        } else {
            $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
            $stmt->execute(['id' => $user->getId()]);
            flash('success', 'Le compte de ' . $user->getPrenom() . ' ' . $user->getNom() . ' a été supprimé.');
        }
        redirect('users');
    }

    
    
    
    public function toggleStatus(): void
    {
        AuthController::requirePermission('users.block');
        $this->requirePost();
        $this->requireCsrf();

        $user = $this->findOr404((int) ($_POST['id'] ?? 0));

        if ($user->getId() === (int) $_SESSION['user_id']) {
            flash('error', 'Vous ne pouvez pas bloquer votre propre compte.');
        } else {
            $newStatut = $user->getStatut() === 'actif' ? 'bloque' : 'actif';
            $stmt = $this->db->prepare('UPDATE users SET statut = :s, failed_attempts = 0, locked_until = NULL WHERE id = :id');
            $stmt->execute(['s' => $newStatut, 'id' => $user->getId()]);
            flash('success', $user->getPrenom() . ' ' . $user->getNom() . ($newStatut === 'bloque' ? ' a été bloqué(e).' : ' a été débloqué(e).'));
        }

        $back = (string) ($_POST['back'] ?? 'users');
        $back === 'user_show' ? redirect('user_show', ['id' => $user->getId()]) : redirect('users');
    }

    
    
    
    public function export(): void
    {
        AuthController::requirePermission('users.export');
        $users = $this->findUsers($this->readFilters($_GET), 10000, 0);

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="parkshare-utilisateurs-' . date('Y-m-d') . '.csv"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF"); 
        fputcsv($out, ['ID', 'Nom', 'Prénom', 'Utilisateur', 'Email', 'Téléphone', 'Rôle', 'Statut', 'Inscrit le', 'Dernière connexion'], ';');
        foreach ($users as $u) {
            fputcsv($out, array_map([$this, 'csvSafe'], [
                $u->getId(), $u->getNom(), $u->getPrenom(), $u->getUsername(), $u->getEmail(), $u->getTelephone(),
                role_label($u->getRole()), statut_label($u->getStatut()),
                format_date($u->getCreatedAt(), true), format_date($u->getLastLogin(), true),
            ]), ';');
        }
        fclose($out);
        exit;
    }

    
    private function csvSafe(mixed $value): string
    {
        $value = (string) $value;
        return preg_match('/^[=+\-@]/', $value) ? "'" . $value : $value;
    }

    
    
    
    private function findOr404(?int $id = null): UserModel
    {
        $id ??= (int) ($_GET['id'] ?? 0);
        $user = $id > 0 ? $this->auth->findById($id) : null;
        if (!$user) {
            $this->abort(404, 'Cet utilisateur n’existe pas ou a été supprimé.');
        }
        return $user;
    }

    private function fill(UserModel $user, array $data): void
    {
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setTelephone($data['telephone']);
        $user->setRole($data['role']);
        $user->setStatut($data['statut']);
    }

    private function keepOld(array $post): array
    {
        unset($post['password'], $post['password_confirm'], $post['csrf_token']);
        return $post;
    }

    private function updateUser(UserModel $user, ?string $newHash): void
    {
        $sql = 'UPDATE users SET nom = :nom, prenom = :prenom, username = :username, email = :email,
                telephone = :telephone, role = :role, statut = :statut';
        $params = [
            'nom' => $user->getNom(), 'prenom' => $user->getPrenom(), 'username' => $user->getUsername(),
            'email' => $user->getEmail(), 'telephone' => $user->getTelephone(),
            'role' => $user->getRole(), 'statut' => $user->getStatut(), 'id' => $user->getId(),
        ];
        if ($newHash !== null) {
            $sql .= ', password = :password, failed_attempts = 0, locked_until = NULL';
            $params['password'] = $newHash;
        }
        if ($user->getStatut() === 'actif') {
            $sql .= ', locked_until = NULL';
        }
        $stmt = $this->db->prepare($sql . ' WHERE id = :id');
        $stmt->execute($params);
    }

    
    private function readFilters(array $get): array
    {
        $q = mb_substr(trim((string) ($get['q'] ?? '')), 0, 100);
        $role = (string) ($get['role'] ?? '');
        $statut = (string) ($get['statut'] ?? '');
        $sort = (string) ($get['sort'] ?? 'recent');

        return [
            'q'      => $q,
            'role'   => in_array($role, AuthController::ALL_ROLES, true) ? $role : '',
            'statut' => in_array($statut, AuthController::STATUTS, true) ? $statut : '',
            'sort'   => isset(self::SORTS[$sort]) ? $sort : 'recent',
        ];
    }

    
    private function whereClause(array $filters): array
    {
        $where = [];
        $params = [];
        if ($filters['q'] !== '') {
            $where[] = '(nom LIKE :q1 OR prenom LIKE :q2 OR username LIKE :q3 OR email LIKE :q4 OR telephone LIKE :q5)';
            $like = '%' . addcslashes($filters['q'], '%_\\') . '%';
            foreach (['q1', 'q2', 'q3', 'q4', 'q5'] as $key) {
                $params[$key] = $like;
            }
        }
        if ($filters['role'] !== '') {
            $where[] = 'role = :role';
            $params['role'] = $filters['role'];
        }
        if ($filters['statut'] !== '') {
            $where[] = 'statut = :statut';
            $params['statut'] = $filters['statut'];
        }
        return [$where ? ' WHERE ' . implode(' AND ', $where) : '', $params];
    }

    
    private function findUsers(array $filters, int $limit, int $offset): array
    {
        [$where, $params] = $this->whereClause($filters);
        $sql = 'SELECT * FROM users' . $where . ' ORDER BY ' . self::SORTS[$filters['sort']]
             . ' LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return array_map(fn(array $row) => UserModel::fromArray($row), $stmt->fetchAll());
    }

    private function countUsers(array $filters): int
    {
        [$where, $params] = $this->whereClause($filters);
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users' . $where);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    private function stats(): array
    {
        $row = $this->db->query(
            "SELECT COUNT(*) AS total,
                    SUM(role = 'client') AS client, SUM(role = 'proprietaire') AS proprietaire,
                    SUM(role = 'technicien') AS technicien, SUM(role = 'admin') AS admin,
                    SUM(statut = 'bloque') AS bloques
             FROM users"
        )->fetch();
        return array_map('intval', $row);
    }
}
