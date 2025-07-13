<?php
  session_name('sysmax-tuya');
  session_start();
  if (!isset($_SESSION['userName'])) {
      header("Location: /src/login.php");
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
  <link href='../public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
  <title>Sysmax Tecnología S.A. de C.V.</title>
</head>
<!DOCTYPE html>
<html lang="es-MX">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../public/img/sysmax_logo64.png" type="image/png">
  <link rel="stylesheet" href="../public/css/styles.css">
  <link rel="stylesheet" href="../public/css/dataTable.css">
  <link href='../public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
  <title>Sysmax Tecnología S.A. de C.V.</title>
</head>
  <body>    
    <div class="main-con">
      <?php include_once "components/general/header.php"?>
      <main class="sysmax-main">
        <?php 
        if($_SESSION['permissions'] == '1'){
          include_once "components/admon/breakersDashboard.php";
        }else{
          include_once "components/general/singleBreakerData.php";
        }
        ?>
      </main>
      <?php include_once 'components/general/footer.php'?>  
    </div>
        <script src="public/js/startSetUp.js"></script>
  </body>
  <script src="../public/js/dataTable.js"></script>
  <script type="module">
    import { closeSession } from "../public/js/general.js";
    window.closeSession = closeSession;
  </script>
</html>
