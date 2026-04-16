<?= view('admin/dashboard_header') ?>

<div style="max-width:500px; margin:20px auto; background:white; padding:30px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
    <h2>Edit User</h2>
    <form action="/admin/users/update/<?= $user['id'] ?>" method="post">
        <label>Name</label><br>
        <input type="text" name="name" value="<?= $user['name'] ?>" required style="width:100%; padding:10px; margin:10px 0;"><br>
        
        <label>Email</label><br>
        <input type="email" name="email" value="<?= $user['email'] ?>" required style="width:100%; padding:10px; margin:10px 0;"><br>
        
        <label>Role</label><br>
        <select name="role" style="width:100%; padding:10px; margin:10px 0;">
            <option value="Staff" <?= $user['role'] == 'Staff' ? 'selected' : '' ?>>Staff</option>
            <option value="Admin" <?= $user['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
        </select><br>

        <label>New Password (leave blank to keep current)</label><br>
        <input type="password" name="password" style="width:100%; padding:10px; margin:10px 0;"><br>

        <button type="submit" style="background:#3498db; color:white; border:none; padding:12px; width:100%; border-radius:5px; cursor:pointer;">Update User</button>
        <a href="/admin/users" style="display:block; text-align:center; margin-top:10px; color:#666; text-decoration:none;">Cancel</a>
    </form>
</div>