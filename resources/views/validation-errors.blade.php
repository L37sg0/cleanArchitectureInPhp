<?php if ($errors): $errors = \Vnn\Keyper\Keyper::create($errors) ?>
    <?php if ($errors->get($name)): ?>
<div class="alert alert-danger">
        <?= implode('. ', $errors->get($name)[0]) ?>
</div>
<?php endif; ?>
<?php endif; ?>