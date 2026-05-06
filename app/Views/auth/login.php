<?php helper('url'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Reah Bakery</title>
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --ios-blue: #007aff;
            --glass-bg: rgba(255, 255, 255, 0.35);
        }

        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            overflow: hidden; /* Prevents scrollbars during background animation */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- UNIQUE ANIMATED BACKGROUND --- */
        .bg-viewport {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: #000;
        }

        .bg-image {
            position: absolute;
            width: 110%; height: 110%;
            top: -5%; left: -5%;
            background-image: url('<?= base_url("assets/bread.jpg") ?>');
            background-size: cover;
            background-position: center;
            /* Slow Motion Zoom Effect */
            animation: kenBurns 25s infinite alternate ease-in-out;
        }

        /* Moving Color Overlay (Makes the photo look more unique) */
        .bg-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(88, 80, 190, 0.3), rgba(0, 0, 0, 0.4));
            mix-blend-mode: overlay;
        }

        @keyframes kenBurns {
            0% { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.1) translate(-15px, -15px); }
        }

        /* --- GLASSMORPHISM LOGIN CARD --- */
        .login-card {
            background: var(--glass-bg); 
            backdrop-filter: blur(25px); 
            -webkit-backdrop-filter: blur(25px);
            padding: 50px 40px; 
            border-radius: 40px; 
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            width: 100%; 
            max-width: 380px; 
            text-align: center;
            z-index: 10;
        }

        .login-card h2 { 
            margin-bottom: 30px; 
            color: #1d1d1f; 
            font-weight: 600;
            letter-spacing: -0.8px;
            font-size: 26px;
        }

        /* Inputs with Icons */
        .input-group { 
            position: relative; 
            margin-bottom: 15px; 
            text-align: left; 
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #4b5563;
            font-size: 16px;
        }
        
        .input-group input {
            width: 100%; 
            padding: 16px 20px 16px 50px; 
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 18px; 
            font-size: 15px; 
            outline: none; 
            transition: all 0.3s ease;
            box-sizing: border-box;
            font-family: inherit;
        }

        .input-group input:focus { 
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.15);
            border-color: var(--ios-blue);
        }

        /* Modern Button */
        .btn-submit {
            width: 100%; 
            padding: 16px; 
            background: var(--ios-blue);
            color: white; 
            border: none; 
            border-radius: 20px; 
            font-size: 16px; 
            font-weight: 600;
            cursor: pointer; 
            transition: 0.3s;
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(0, 122, 255, 0.3);
        }

        .btn-submit:hover { 
            background: #0063cc;
            transform: translateY(-2px); 
            box-shadow: 0 12px 25px rgba(0, 122, 255, 0.4); 
        }

        .footer-text { margin-top: 30px; font-size: 14px; color: #1d1d1f; }
        .footer-text a { color: var(--ios-blue); text-decoration: none; font-weight: 600; }
        .footer-text a:hover { text-decoration: underline; }

        /* Alerts */
        .alert { padding: 12px; border-radius: 15px; margin-bottom: 20px; font-size: 13px; }
        .alert-error { color: #dc2626; background: rgba(254, 226, 226, 0.8); border: 1px solid rgba(220, 38, 38, 0.2); }
        .alert-success { color: #16a34a; background: rgba(220, 252, 231, 0.8); border: 1px solid rgba(16, 163, 74, 0.2); }
    </style>
</head>
<body>

    <!-- Animated Background Elements -->
    <div class="bg-viewport">
        <div class="bg-image"></div>
        <div class="bg-overlay"></div>
    </div>

    <div class="login-card">
        <h2>Welcome Back</h2>
        
        <?php if(session()->getFlashdata('error')): ?> 
            <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div> 
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('success')): ?> 
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div> 
        <?php endif; ?>

        <form action="/loginAuth" method="post">
            <?= csrf_field() ?>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
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