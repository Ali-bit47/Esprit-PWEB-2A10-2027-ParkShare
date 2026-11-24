<?php


class ProfileController extends Controller
{
    protected string $page = 'profile';
    private AuthController $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new AuthController();
    }

    
    public function show(): void
    {
        AuthController::requireAuth();
        $this->view('profile', ['title' => 'Mon profil', 'user' => $this->me()]);
    }

    
    public function edit(): void
    {
        AuthController::requireAuth();
        $user = $this->me();
        $errors = [];
        $old = [
            'nom' => $user->getNom(), 'prenom' => $user->getPrenom(), 'username' => $user->getUsername(),
            'email' => $user->getEmail(), 'telephone' => $user->getTelephone(),
        ];

        if ($this->isPost()) {
            $this->requireCsrf();
            $old = $_POST;
            unset($old['csrf_token'], $old['password'], $old['password_confirm']);

            
            $post = $_POST;
            unset($post['password']);
            [$errors, $data] = $this->auth->validateUserInput($post, ['excludeId' => $user->getId()]);

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'UPDATE users SET nom = :nom, prenom = :prenom, username = :username, email = :email, telephone = :telephone WHERE id = :id'
                );
                $stmt->execute([
                    'nom' => $data['nom'], 'prenom' => $data['prenom'], 'username' => $data['username'],
                    'email' => $data['email'], 'telephone' => $data['telephone'], 'id' => $user->getId(),
                ]);
                AuthController::syncSession();
                flash('success', 'Votre profil a été mis à jour.');
                redirect('profile');
            }
        }

        $this->view('profile_edit', [
            'title' => 'Modifier mon profil', 'user' => $user, 'errors' => $errors, 'old' => $old,
        ]);
    }

    
    public function password(): void
    {
        AuthController::requireAuth();
        $user = $this->me();
        $errors = [];

        if ($this->isPost()) {
            $this->requireCsrf();
            $current = (string) ($_POST['current_password'] ?? '');
            $new     = (string) ($_POST['password'] ?? '');
            $confirm = (string) ($_POST['password_confirm'] ?? '');

            if ($current === '') {
                $errors['current_password'] = 'Saisissez votre mot de passe actuel.';
            } elseif (!password_verify($current, $user->getPassword())) {
                $errors['current_password'] = 'Mot de passe actuel incorrect.';
            }
            if ($error = AuthController::passwordError($new)) {
                $errors['password'] = $error;
            } elseif ($new === $current) {
                $errors['password'] = 'Le nouveau mot de passe doit être différent de l’actuel.';
            } elseif ($new !== $confirm) {
                $errors['password_confirm'] = 'Les deux mots de passe ne correspondent pas.';
            }

            if (empty($errors)) {
                $stmt = $this->db->prepare('UPDATE users SET password = :p WHERE id = :id');
                $stmt->execute(['p' => password_hash($new, PASSWORD_DEFAULT), 'id' => $user->getId()]);
                session_regenerate_id(true);
                flash('success', 'Votre mot de passe a été modifié.');
                redirect('profile');
            }
        }

        $this->view('password', [
            'title' => 'Changer mon mot de passe', 'user' => $user, 'errors' => $errors,
        ]);
    }

    
    public function delete(): void
    {
        AuthController::requireAuth();
        $this->requirePost();
        $this->requireCsrf();
        $user = $this->me();

        if (!password_verify((string) ($_POST['confirm_password'] ?? ''), $user->getPassword())) {
            flash('error', 'Mot de passe incorrect : votre compte n’a pas été supprimé.');
            redirect('profile');
        }
        if ($user->getRole() === 'admin' && $this->auth->countByRole('admin') <= 1) {
            flash('error', 'Vous êtes le dernier administrateur : votre compte ne peut pas être supprimé.');
            redirect('profile');
        }

        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $user->getId()]);
        AuthController::destroySession();
        session_start();
        flash('info', 'Votre compte a été supprimé. Merci d’avoir utilisé ParkShare.');
        redirect('home');
    }

    
    private function me(): UserModel
    {
        $user = $this->auth->findById((int) $_SESSION['user_id']);
        if (!$user) {
            AuthController::destroySession();
            session_start();
            redirect('login');
        }
        return $user;
    }

    
    private function view(string $name, array $data): void
    {
        $back = can('backoffice');
        $data['back'] = $back;
        $this->render(($back ? 'back/' : 'front/') . $name, $data, $back ? 'admin' : 'front');
    }
}
