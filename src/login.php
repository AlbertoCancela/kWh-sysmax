<?php
session_name('sysmax-tuya');
session_start();

if (isset($_SESSION['userName'])) {
    header("Location: /src");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../public/img/sysmax_logo64.png" type="image/png">
  <link rel="stylesheet" href="../public/css/styles.css">
  <link rel="stylesheet" href="../public/css/login.css">
  <link href='../public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
  <title>Sysmax Tecnología S.A. de C.V.</title>
</head>
  <body class="centerItems">    
    <div class="login-box">
      <img src="../public/img/sysmax_logow.png" alt="">
      <form id="login-login">
        <div class="user-box">
          <input type="text" name="username" required="" value="admon">
          <label>Username</label>
        </div>
        <div class="user-box">
          <input type="password" name="password" required="" value="4321">
          <label>Password</label>
        </div>
        <span id="spanLogin" class="hidden login-spanErrorMessage"> Usuario y/o contraseña incorrectos.</span>
        <div class="user-box">
            <button class="" type="submit">Ingresar</button>
        </div>
      </form>
    </div>
  </body>
  <script src="../public/js/login.js"></script>
</html>
