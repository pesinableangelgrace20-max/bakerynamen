<?php helper('url'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Reah Bakery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            /* Using your bread photo as a background */
            background: url('<?= base_url("assets/bread.jpg") ?>');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* The iOS Frosted Glass Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.45); /* Semi-transparent */
            backdrop-filter: blur(20px); /* The "Frosted" effect */
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px; /* Extra rounded like iPhone popups */
            padding: 50px 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            font-weight: 600;
            color: #1d1d1f; /* iOS Dark Text color */
            margin-bottom: 30px;
            letter-spacing: -0.5px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8e8e93;
        }

        input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 12px;
            font-size: 14px;
            box-sizing: border-box;
            transition: 0.3s;
        }

        input:focus {
            outline: none;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.15); /* iOS Blue focus */
        }

        /* Sleek Button */
        .btn-register {
            width: 100%;
            padding: 15px;
            background: #007aff; /* Apple Blue */
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: #0063cc;
            transform: translateY(-2px);
        }

        p {
            font-size: 13px;
            color: #3a3a3c;
            margin-top: 25px;
        }

        a {
            color: #007aff;
            text-decoration: none;
            font-weight: 600;
        }
        
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <h2>Create Account</h2>
        
        <form action="<?= base_url('register/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Full Name" required>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-register">Sign Up</button>
        </form>

        <p>Already have an account? <a href="<?= base_url('login') ?>">Login here</a></p>
    </div>

</body>
</html>