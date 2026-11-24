<?php  ?>

<script src="<?= asset('js/validation.js') ?>"></script>
<script src="<?= asset('js/forms.js') ?>"></script>
<script src="<?= asset('js/app.js') ?>"></script>
<?php foreach ($extraScripts ?? [] as $script): ?>
<script src="<?= asset($script) ?>"></script>
<?php endforeach; ?>
