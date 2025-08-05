<?php
  session_name('sysmax-tuya');
  session_start();
  if (!isset($_SESSION['userName'])) {
      header("Location: /kWh-sysmax/src/login.php");
      exit;
  }
//   echo $_SESSION['data']['id'];
  $name = $_SESSION['data']['name'];
  $id = $_SESSION['data']['id'];
  $userName = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/kWh-sysmax/public/img/sysmax_logo64.png" type="image/png">
    <link rel="stylesheet" href="/kWh-sysmax/public/css/styles.css">
    <!-- <link rel="stylesheet" href="/kWh-sysmax/public/css/generalModal.css"> -->
    <!-- <link rel="stylesheet" href="/kWh-sysmax/public/css/userSettings.css"> -->
    <link rel="stylesheet" href="/kWh-sysmax/public/css/admonReports.css">
    <link href='/kWh-sysmax/public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Sysmax Tecnología S.A. de C.V.</title>
</head>
    <body>    
        <div class="main-con">
        <?php include_once "../components/general/header.php"?>
        <?php include_once "../components/general/generalModal.php"?>
        <main class="sysmax-main">
            <section class="admon-reports">
                <div class="admon-reports-mainContainer">
                    <section id="admon-reports-section1">
                        <div></div>
                        <div></div>
                    </section>
                    <section id="admon-reports-section2">
                        <div></div>
                        <div></div>
                    </section>
                </div>
            </section>
        </main>
        </div>
        <script type="module">
            import { closeSession } from "/kWh-sysmax/public/js/general.js";
            window.closeSession = closeSession;
        </script>
    </body>
</html>