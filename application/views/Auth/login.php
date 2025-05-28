<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - SIMLEMDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background: url('https://images.unsplash.com/photo-1522202195463-8f46b3e5fca3') no-repeat center center / cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }
        .login-wrapper {
            width: 750px;
            height: 400px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
        .login-section, .brand-section {
            flex: 1;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-section {
            background-color: rgba(255, 255, 255, 0.9);
        }
        .brand-section {
            background: #0ca342;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .brand-section::before {
            content: '';
            position: absolute;
            background: white;
            top: 60px;
            left: 70px;
            width: 120%;
            height: 85%;
            transform: skew(-15deg);
            z-index: 0;
            border-radius: 30px 0 30px 30px;
        }
        .brand-content {
            position: relative;
            z-index: 1;
        }
        .brand-content img {
            width: 100px;
        }
        .brand-content h2 {
            margin: 8px 0 0;
            font-size: 22px;
            color: #0ca342;
        }
        .brand-content p {
            font-size: 13px;
            color: #0ca342;
        }
        form {
            max-width: 240px;
            margin: auto;
        }
        h2 {
            margin-bottom: 15px;
            text-align: center;
            font-size: 20px;
        }
        label {
            font-weight: bold;
            font-size: 13px;
        }
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 13px;
        }
        .btn {
            width: 100%;
            background-color: #0ca342;
            color: white;
            padding: 8px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #0a8d38;
        }
        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-section">
            <form method="post" action="<?php echo site_url('auth/login'); ?>">
                <h2>Login SIMLEMDA</h2>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
        <div class="brand-section">
            <div class="brand-content">
                <img src="<?php echo base_url('assets/template/img/logo_binainsani.png'); ?>" alt="Logo SIMLEMDA">
                <h2>SIMLEMDA</h2>
                <p>Sistem Lembar Kendali</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>