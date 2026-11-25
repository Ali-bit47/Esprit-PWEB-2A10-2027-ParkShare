<?php


class AuthController extends Controller
{
    
    public const PUBLIC_ROLES = ['client', 'proprietaire'];

    
    public const ALL_ROLES = ['client', 'proprietaire', 'technicien', 'admin'];

    public const STATUTS = ['actif', 'bloque'];

    private static ?array $permissions = null;

    
    
    
    public function register(): void
    {
        if (self::isAuthenticated()) {
            $this->redirectByRole();
        }

        $errors = [];
        $old = ['role' => 'client'];

        if ($this->isPost()) {
            $old = $_POST;
            unset($old['password'], $old['password_confirm'], $old['csrf_token']);

            if (!self::verifyCsrfToken($_POST['csrf_token'] ?? null)) {
                $errors['_global'] = 'Jeton de sécurité invalide. Rechargez la page et réessayez.';
            } else {
                [$errors, $data] = $this->validateUserInput($_POST, [
                    'roles'            => self::PUBLIC_ROLES, 
                    'passwordRequired' => true,
                    'terms'            => true,
                ]);

                if (empty($errors)) {
                    $user = new UserModel();
                    $user->setNom($data['nom']);
                    $user->setPrenom($data['prenom']);
                    $user->setUsername($data['username']);
                    $user->setEmail($data['email']);
                    $user->setTelephone($data['telephone']);
                    $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT)); 
                    $user->setRole($data['role']);
                    $user->setStatut('actif');

                    if ($this->insertUser($user)) {
                        redirect('login', ['registered' => 1]);
                    }
                    $errors['_global'] = 'Une erreur est survenue lors de la création du compte.';
                }
            }
        }

        $this->render('front/register', [
            'title'        => 'Créer un compte',
            'currentPage'  => 'register',
            'errors'       => $errors,
            'old'          => $old,
            
        ]);
    }

    
    
    
    public function login(): void
    {
        if (self::isAuthenticated()) {
            $this->redirectByRole();
        }

        $errors = [];
        $old = [];

        if ($this->isPost()) {
            $old = ['email' => $_POST['email'] ?? ''];
            $errors = $this->attemptLogin($_POST);

            if (empty($errors)) {
                
                $intended = $_SESSION['intended'] ?? null;
                unset($_SESSION['intended']);
                $routes = require __DIR__ . '/../routes.php';
                flash('success', 'Bienvenue ' . $_SESSION['prenom'] . ' !');
                if ($intended && isset($routes[$intended]) && !in_array($intended, ['login', 'register', 'logout'], true)) {
                    redirect($intended);
                }
                $this->redirectByRole();
            }
        }

        $this->render('front/login', [
            'title'        => 'Connexion',
            'currentPage'  => 'login',
            'errors'       => $errors,
            'old'          => $old,
            'registered'   => !empty($_GET['registered']),
            
        ]);
    }

    
    private function attemptLogin(array $post): array
    {
        if (!self::verifyCsrfToken($post['csrf_token'] ?? null)) {
            return ['_global' => 'Jeton de sécurité invalide. Rechargez la page et réessayez.'];
        }

        $email    = trim((string) ($post['email'] ?? ''));
        $password = (string) ($post['password'] ?? '');

        $errors = [];
        if ($email === '') {
            $errors['email'] = 'Veuillez saisir votre adresse email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Adresse email invalide.';
        }
        if ($password === '') {
            $errors['password'] = 'Veuillez saisir votre mot de passe.';
        }
        if ($errors) {
            return $errors;
        }

        $user = $this->findByEmail($email);

        
        if ($user && $user->getLockedUntil() && strtotime($user->getLockedUntil()) > time()) {
            $minutes = (int) ceil((strtotime($user->getLockedUntil()) - time()) / 60);
            return ['_global' => "Trop de tentatives échouées. Réessayez dans {$minutes} minute(s)."];
        }

        
        if (!$user || !password_verify($password, $user->getPassword())) {
            if ($user) {
                $this->recordFailedLogin($user);
            }
            return ['_global' => 'Email ou mot de passe incorrect.'];
        }

        if ($user->getStatut() === 'bloque') {
            return ['_global' => 'Votre compte a été bloqué. Contactez l’administrateur de ParkShare.'];
        }

        
        if (password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)) {
            $stmt = $this->db->prepare('UPDATE users SET password = :p WHERE id = :id');
            $stmt->execute(['p' => password_hash($password, PASSWORD_DEFAULT), 'id' => $user->getId()]);
        }

        $stmt = $this->db->prepare('UPDATE users SET failed_attempts = 0, locked_until = NULL, last_login = NOW() WHERE id = :id');
        $stmt->execute(['id' => $user->getId()]);

        
        session_regenerate_id(true);
        unset($_SESSION['csrf_token']); 

        $_SESSION['user_id']       = $user->getId();
        $_SESSION['username']      = $user->getUsername();
        $_SESSION['nom']           = $user->getNom();
        $_SESSION['prenom']        = $user->getPrenom();
        $_SESSION['role']          = $user->getRole();
        $_SESSION['last_activity'] = time();

        return [];
    }

    private function recordFailedLogin(UserModel $user): void
    {
        $attempts = $user->getFailedAttempts() + 1;
        if ($attempts >= MAX_LOGIN_ATTEMPTS) {
            $stmt = $this->db->prepare(
                'UPDATE users SET failed_attempts = 0, locked_until = DATE_ADD(NOW(), INTERVAL ' . (int) LOCK_MINUTES . ' MINUTE) WHERE id = :id'
            );
        } else {
            $stmt = $this->db->prepare('UPDATE users SET failed_attempts = failed_attempts + 1 WHERE id = :id');
        }
        $stmt->execute(['id' => $user->getId()]);
    }

    
    
    
    public function logout(): void
    {
        $this->requirePost();
        if (self::isAuthenticated()) {
            $this->requireCsrf();
        }
        self::destroySession();
        session_start();
        flash('info', 'Vous êtes déconnecté. À bientôt sur ParkShare.');
        redirect('login');
    }

    public static function destroySession(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    
    public function redirectByRole(): never
    {
        self::can('backoffice') ? redirect('admin') : redirect('home');
    }

    
    
    
    public static function isAuthenticated(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    
    public static function syncSession(): void
    {
        if (!self::isAuthenticated()) {
            return;
        }
        $stmt = Database::getConnexion()->prepare('SELECT username, nom, prenom, role, statut FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => (int) $_SESSION['user_id']]);
        $row = $stmt->fetch();

        if (!$row || $row['statut'] === 'bloque') {
            self::destroySession();
            session_start();
            flash('error', $row ? 'Votre compte a été bloqué par un administrateur.' : 'Votre compte n’existe plus.');
            return;
        }
        $_SESSION['username'] = $row['username'];
        $_SESSION['nom']      = $row['nom'];
        $_SESSION['prenom']   = $row['prenom'];
        $_SESSION['role']     = $row['role'];
    }

    
    public static function requireAuth(): void
    {
        if (!self::isAuthenticated()) {
            $_SESSION['intended'] = (string) ($_GET['action'] ?? 'home');
            flash('info', 'Connectez-vous pour accéder à cette page.');
            redirect('login');
        }
    }

    
    
    
    public static function hasRole(string $role): bool
    {
        return self::isAuthenticated() && ($_SESSION['role'] ?? null) === $role;
    }

    
    public static function requireRole(string ...$roles): void
    {
        self::requireAuth();
        if (!in_array($_SESSION['role'] ?? null, $roles, true)) {
            (new HomeController())->abort(403, 'Vous n’avez pas les droits nécessaires pour accéder à cette page.');
        }
    }

    
    public static function can(string $permission): bool
    {
        if (!self::isAuthenticated()) {
            return false;
        }
        self::$permissions ??= require __DIR__ . '/../../config/permissions.php';
        return in_array($permission, self::$permissions[$_SESSION['role'] ?? ''] ?? [], true);
    }

    
    public static function requirePermission(string $permission): void
    {
        self::requireAuth();
        if (!self::can($permission)) {
            (new HomeController())->abort(403, 'Vous n’avez pas les droits nécessaires pour accéder à cette page.');
        }
    }

    
    
    
    public static function getCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken(?string $token): bool
    {
        if (!$token || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    
    
    
    
    
    public function validateUserInput(array $post, array $options = []): array
    {
        $errors = [];
        $roles            = $options['roles'] ?? null;
        $withStatut       = $options['statut'] ?? false;
        $passwordRequired = $options['passwordRequired'] ?? false;
        $withTerms        = $options['terms'] ?? false;
        $excludeId        = (int) ($options['excludeId'] ?? 0);

        $data = [
            'nom'       => preg_replace('/\s+/u', ' ', trim((string) ($post['nom'] ?? ''))),
            'prenom'    => preg_replace('/\s+/u', ' ', trim((string) ($post['prenom'] ?? ''))),
            'username'  => trim((string) ($post['username'] ?? '')),
            'email'     => mb_strtolower(trim((string) ($post['email'] ?? ''))),
            'telephone' => self::normalizePhone((string) ($post['telephone'] ?? '')),
            'password'  => (string) ($post['password'] ?? ''),
            'role'      => (string) ($post['role'] ?? ''),
            'statut'    => (string) ($post['statut'] ?? 'actif'),
        ];

        
        foreach (['nom' => 'Le nom', 'prenom' => 'Le prénom'] as $field => $label) {
            if ($data[$field] === '') {
                $errors[$field] = "$label est obligatoire.";
            } elseif (!preg_match("/^[\p{L}][\p{L} '\-]{1,49}$/u", $data[$field])) {
                $errors[$field] = "$label doit contenir de 2 à 50 lettres (espaces, tirets et apostrophes acceptés).";
            }
        }

        
        if ($data['username'] === '') {
            $errors['username'] = 'Le nom d’utilisateur est obligatoire.';
        } elseif (!preg_match('/^[a-zA-Z0-9._\-]{3,50}$/', $data['username'])) {
            $errors['username'] = 'De 3 à 50 caractères : lettres, chiffres, point, _ ou - uniquement.';
        } elseif ($this->usernameTaken($data['username'], $excludeId)) {
            $errors['username'] = 'Ce nom d’utilisateur est déjà utilisé.';
        }

        
        if ($data['email'] === '') {
            $errors['email'] = 'L’adresse email est obligatoire.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($data['email']) > 150) {
            $errors['email'] = 'Adresse email invalide (exemple : nom@domaine.tn).';
        } elseif ($this->emailTaken($data['email'], $excludeId)) {
            $errors['email'] = 'Cette adresse email est déjà associée à un compte.';
        }

        
        if ($data['telephone'] === '') {
            $errors['telephone'] = 'Le numéro de téléphone est obligatoire.';
        } elseif (!preg_match('/^[234579]\d{7}$/', $data['telephone'])) {
            $errors['telephone'] = 'Numéro tunisien invalide : 8 chiffres (exemple : 22 123 456).';
        }

        
        if ($passwordRequired || $data['password'] !== '') {
            $passwordError = self::passwordError($data['password']);
            if ($passwordError) {
                $errors['password'] = $passwordError;
            } elseif ($data['password'] !== (string) ($post['password_confirm'] ?? '')) {
                $errors['password_confirm'] = 'Les deux mots de passe ne correspondent pas.';
            }
        }

        
        if ($roles !== null && !in_array($data['role'], $roles, true)) {
            $errors['role'] = 'Veuillez choisir un rôle valide.';
        }

        if ($withStatut && !in_array($data['statut'], self::STATUTS, true)) {
            $errors['statut'] = 'Statut invalide.';
        }

        if ($withTerms && empty($post['terms'])) {
            $errors['terms'] = 'Vous devez accepter les conditions d’utilisation.';
        }

        return [$errors, $data];
    }

    
    public static function passwordError(string $password): ?string
    {
        if ($password === '') {
            return 'Le mot de passe est obligatoire.';
        }
        if (strlen($password) < 8 || strlen($password) > 72) {
            return 'Le mot de passe doit contenir entre 8 et 72 caractères.';
        }
        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password)) {
            return 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.';
        }
        return null;
    }

    
    public static function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[\s.\-]/', '', trim($phone));
        return preg_replace('/^(\+216|00216)/', '', $phone);
    }

    
    
    
    public function findByEmail(string $email): ?UserModel
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => mb_strtolower($email)]);
        $row = $stmt->fetch();
        return $row ? UserModel::fromArray($row) : null;
    }

    public function findById(int $id): ?UserModel
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? UserModel::fromArray($row) : null;
    }

    public function emailTaken(string $email, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = :email AND id <> :id LIMIT 1');
        $stmt->execute(['email' => $email, 'id' => $excludeId]);
        return (bool) $stmt->fetch();
    }

    public function usernameTaken(string $username, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE username = :username AND id <> :id LIMIT 1');
        $stmt->execute(['username' => $username, 'id' => $excludeId]);
        return (bool) $stmt->fetch();
    }

    public function insertUser(UserModel $user): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (nom, prenom, username, email, telephone, password, role, statut)
             VALUES (:nom, :prenom, :username, :email, :telephone, :password, :role, :statut)'
        );
        return $stmt->execute([
            'nom'       => $user->getNom(),
            'prenom'    => $user->getPrenom(),
            'username'  => $user->getUsername(),
            'email'     => $user->getEmail(),
            'telephone' => $user->getTelephone(),
            'password'  => $user->getPassword(),
            'role'      => $user->getRole(),
            'statut'    => $user->getStatut(),
        ]);
    }

    public function countByRole(string $role): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE role = :role');
        $stmt->execute(['role' => $role]);
        return (int) $stmt->fetchColumn();
    }
}
