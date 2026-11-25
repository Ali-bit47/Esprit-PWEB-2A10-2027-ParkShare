<?php 
$currentPage = 'profile_edit';
?>
<div class="wrap page">
    <div class="page-head"><div><h1>Modifier mes informations</h1><p>Ces informations sont visibles par les propriétaires lors de vos réservations.</p></div></div>
    <div class="profile-grid">
        <?php require __DIR__ . '/_profile_menu.php'; ?>
        <div class="card"><?php require __DIR__ . '/../shared/_profile_form.php'; ?></div>
    </div>
</div>
