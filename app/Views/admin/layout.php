<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Reah Bakery Admin') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
    <?= $this->renderSection('head_extra') ?>
</head>
<body class="admin-shell">

<?= view('admin/partials/_sidebar', ['page' => $page ?? 'dashboard']) ?>

<div class="main admin-main">
    <?= view('admin/partials/_topnav', ['title' => $title ?? 'Dashboard']) ?>

    <?= view('admin/partials/_flash') ?>

    <div class="content-body">
        <?= $this->renderSection('content') ?>
    </div>
</div>

<?= view('admin/partials/_modal_confirm') ?>

<script>
(function () {
    document.querySelectorAll('[data-confirm-delete]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            var url = el.getAttribute('href');
            var msg = el.getAttribute('data-confirm-message') || 'Delete this item?';
            window.dispatchEvent(new CustomEvent('confirm-delete', { detail: { url: url, message: msg } }));
        });
    });

    window.addEventListener('confirm-delete', function (ev) {
        var modal = document.getElementById('confirm-modal');
        var text = document.getElementById('confirm-modal-text');
        var yes = document.getElementById('confirm-modal-yes');
        if (!modal || !yes || !text) return;
        text.textContent = ev.detail.message;
        modal.style.display = 'flex';
        yes.onclick = function () {
            window.location.href = ev.detail.url;
        };
    });

    var modalClose = document.getElementById('confirm-modal-no');
    if (modalClose) {
        modalClose.addEventListener('click', function () {
            document.getElementById('confirm-modal').style.display = 'none';
        });
    }
})();
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
