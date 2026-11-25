<?php

$errors = $errors ?? [];
$fieldErrors = array_diff_key($errors, ['_global' => true]);
?>
<?php if (!empty($errors['_global'])): ?>
    <div class="alert alert-error" role="alert"><?= e($errors['_global']) ?></div>
<?php endif; ?>
<?php if ($fieldErrors): ?>
    <div class="alert alert-error" role="alert">
        <?= count($fieldErrors) === 1 ? 'Un champ est à corriger :' : count($fieldErrors) . ' champs sont à corriger :' ?>
        <ul><?php foreach ($fieldErrors as $msg): ?><li><?= e($msg) ?></li><?php endforeach; ?></ul>
    </div>
<?php endif; ?>
<div class="alert alert-error js-summary" role="alert" hidden></div>
