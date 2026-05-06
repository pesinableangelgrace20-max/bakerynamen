<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="card edit-form-card">
    <h3>Edit User</h3>
    <form action="<?= base_url('admin/users/update/' . ($user['id'] ?? '')) ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-stack">
            <label>Name</label>
            <input type="text" name="name" value="<?= esc(old('name', $user['name'] ?? '')) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= esc(old('email', $user['email'] ?? '')) ?>" required>

            <label>Role</label>
            <select name="role">
                <option value="Staff" <?= (($user['role'] ?? '') === 'Staff') ? 'selected' : '' ?>>Staff</option>
                <option value="Admin" <?= (($user['role'] ?? '') === 'Admin') ? 'selected' : '' ?>>Admin</option>
            </select>

            <label>New password (leave blank to keep)</label>
            <input type="password" name="password" autocomplete="new-password">

            <button type="submit" class="btn-primary">Update User</button>
            <a href="<?= base_url('admin/users') ?>" class="btn-link-muted">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
