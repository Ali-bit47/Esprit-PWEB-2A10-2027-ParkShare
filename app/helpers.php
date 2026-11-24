<?php



function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}


function url(string $action, array $params = []): string
{
    $query = http_build_query(array_merge(['action' => $action], $params));
    return 'index.php?' . $query;
}


function redirect(string $action, array $params = []): never
{
    header('Location: ' . url($action, $params));
    exit;
}


function asset(string $path): string
{
    return 'app/Views/assets/' . ltrim($path, '/');
}


function isActive(string|array $pages, string $currentPage): string
{
    return in_array($currentPage, (array) $pages, true) ? 'active' : '';
}




function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function get_flashes(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}





function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(AuthController::getCsrfToken()) . '">';
}


function old(array $old, string $key, string $default = ''): string
{
    return e($old[$key] ?? $default);
}


function field_error(array $errors, string $field): string
{
    if (empty($errors[$field])) {
        return '<small class="field-error" data-for="' . e($field) . '"></small>';
    }
    return '<small class="field-error show" data-for="' . e($field) . '">' . e($errors[$field]) . '</small>';
}


function invalid(array $errors, string $field): string
{
    return !empty($errors[$field]) ? 'is-invalid' : '';
}




function role_label(string $role): string
{
    return [
        'admin'        => 'Administrateur',
        'technicien'   => 'Technicien',
        'proprietaire' => 'Propriétaire',
        'client'       => 'Automobiliste',
    ][$role] ?? $role;
}

function statut_label(string $statut): string
{
    return $statut === 'bloque' ? 'Bloqué' : 'Actif';
}

function initials(string $prenom, string $nom): string
{
    return mb_strtoupper(mb_substr($prenom, 0, 1) . mb_substr($nom, 0, 1));
}

function format_date(?string $date, bool $withTime = false): string
{
    if (empty($date)) {
        return '—';
    }
    $ts = strtotime($date);
    return $ts ? date($withTime ? 'd/m/Y H:i' : 'd/m/Y', $ts) : '—';
}


function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    return [
        'id'       => (int) $_SESSION['user_id'],
        'username' => $_SESSION['username'] ?? '',
        'nom'      => $_SESSION['nom'] ?? '',
        'prenom'   => $_SESSION['prenom'] ?? '',
        'role'     => $_SESSION['role'] ?? '',
    ];
}

function can(string $permission): bool
{
    return AuthController::can($permission);
}
