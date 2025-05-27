<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - SISLEMDA</title>
  <link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet"/>
</head>
<body>
<div class="login-container">
  <div class="login-form">
    <h2>Lupa Password</h2>
    <form action="<?= base_url('index.php/Login/Login') ?>" method="post">
      <input type="username" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <div class="checkbox-row">
        <label><input type="checkbox" name="remember"> Ingat Saya</label>
        <a href="#" class="forgot-password">Lupa Password?</a>
      </div>
      <button type="submit" class="login-btn">Login</button>
      <a href="Login" class="forgot-back">Kembali</a>
    </form>
  </div>
  <div class="login-branding">
    <img src="<?= base_url('assets/gambar/logoo.png'); ?>" alt="SIMLEMDA">
    <h1>SISLEMDA</h1>
    <p>Sistem Lembar Kendali</p>
  </div>
</div>
</body>
</html>
