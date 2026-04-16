<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0; padding: 0; font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95); padding: 40px; 
            border-radius: 15px; box-shadow: 0 15px 25px rgba(0,0,0,0.2);
            width: 100%; max-width: 400px; text-align: center;
        }
        .login-card h2 { margin-bottom: 20px; color: #333; }
        .input-group { margin-bottom: 20px; text-align: left; }
        .input-group input {
            width: 100%; padding: 12px 15px; border: 1px solid #ccc;
            border-radius: 8px; font-size: 14px; outline: none; transition: 0.3s;
            box-sizing: border-box;
        }
        .input-group input:focus { border-color: #667eea; box-shadow: 0 0 8px rgba(102, 126, 234, 0.3); }
        .btn-submit {
            width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600;
            cursor: pointer; transition: 0.3s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(118, 75, 162, 0.4); }
        .footer-text { margin-top: 20px; font-size: 14px; color: #666; }
        .footer-text a { color: #667eea; text-decoration: none; font-weight: 600; }
        .alert-error { color: #d9534f; background: #fdf7f7; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;}
        .alert-success { color: #5cb85c; background: #f4fdf4; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;}
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Welcome Back</h2>
        
        <?php if(session()->getFlashdata('error')): ?> 
            <div class="alert-error"><?= session()->getFlashdata('error') ?></div> 
        <?php endif; ?>
        <?php if(session()->getFlashdata('success')): ?> 
            <div class="alert-success"><?= session()->getFlashdata('success') ?></div> 
        <?php endif; ?>

        <form action="/loginAuth" method="post">
            <?= csrf_field() ?>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-submit">Login</button>
        </form>
        
        <div class="footer-text">
            Don't have an account? <a href="/register">Create one here</a>
        </div>
    </div>
</body>
</html>