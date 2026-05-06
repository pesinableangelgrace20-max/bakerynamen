<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="card">
    <h3>Add New User</h3>
    <form action="<?= base_url('admin/users/store') ?>" method="post" class="form-row users-add-form">
        <?= csrf_field() ?>
        <input type="text" name="name" placeholder="Name" required value="<?= esc(old('name') ?? '') ?>">
        <input type="email" name="email" placeholder="Email" required value="<?= esc(old('email') ?? '') ?>">
        <input type="password" name="password" placeholder="Password" required>
        <select name="role">
            <option value="Staff">Staff</option>
            <option value="Admin">Admin</option>
        </select>
        <button type="submit" class="btn-primary">Add User</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th style="text-align: right;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users ?? [] as $u): ?>
            <tr>
                <td style="font-weight: 500;"><?= esc($u['name'] ?? '') ?></td>
                <td><?= esc($u['email'] ?? '') ?></td>
                <td><?= esc($u['role'] ?? '') ?></td>
                <td style="text-align: right;">
                    <a href="<?= base_url('admin/users/edit/' . ($u['id'] ?? '')) ?>" class="btn-action btn-edit"><i class="fas fa-edit"></i> Edit</a>
                    <a href="<?= base_url('admin/users/delete/' . ($u['id'] ?? '')) ?>"
                       class="btn-action btn-delete"
                       data-confirm-delete
                       data-confirm-message="Delete this user?">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
