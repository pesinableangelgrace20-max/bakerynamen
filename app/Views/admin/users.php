<?= view('admin/dashboard_header') ?>

<div style="padding:20px;">
    <div style="background:white; padding:20px; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.1);">
        <h3>Add New User</h3>
        <form action="/admin/users/store" method="post" style="display:flex; gap:10px; margin-bottom:20px;">
            <input type="text" name="name" placeholder="Name" required style="padding:8px; flex:1;">
            <input type="email" name="email" placeholder="Email" required style="padding:8px; flex:1;">
            <input type="password" name="password" placeholder="Password" required style="padding:8px; flex:1;">
            <select name="role" style="padding:8px;">
                <option value="Staff">Staff</option>
                <option value="Admin">Admin</option>
            </select>
            <button type="submit" style="background:#27ae60; color:white; border:none; padding:8px 15px; border-radius:4px;">Add User</button>
        </form>

        <table border="1" width="100%" style="border-collapse:collapse; text-align:left;">
            <tr style="background:#eee;">
                <th style="padding:10px;">Name</th>
                <th style="padding:10px;">Email</th>
                <th style="padding:10px;">Role</th>
                <th style="padding:10px;">Action</th>
            </tr>
            <?php foreach($users as $u): ?>
            <tr>
                <td style="padding:10px;"><?= $u['name'] ?></td>
                <td style="padding:10px;"><?= $u['email'] ?></td>
                <td style="padding:10px;"><?= $u['role'] ?></td>
                <td style="padding:10px;">
                    <a href="/admin/users/delete/<?= $u['id'] ?>" onclick="return confirm('Delete?')" style="color:red;">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>