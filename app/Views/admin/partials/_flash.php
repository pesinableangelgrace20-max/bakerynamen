<?php
$success = session()->getFlashdata('success');
$error   = session()->getFlashdata('error');
?>
<?php if ($success): ?>
    <div class="flash flash-success" role="status">
        <span><?= esc($success) ?></span>
        <button type="button" class="flash-close" aria-label="Dismiss" onclick="this.parentElement.remove()">&times;</button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="flash flash-error" role="alert">
        <span><?= esc($error) ?></span>
        <button type="button" class="flash-close" aria-label="Dismiss" onclick="this.parentElement.remove()">&times;</button>
    </div>
<?php endif; ?>
