<?php
  session_name('sysmax-tuya');
  session_start();
  if (!isset($_SESSION['userName'])) {
      header("Location: /src/login.php");
      exit;
  }
  // echo $_SESSION['data']['userBreaker'];
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<!DOCTYPE html>
<html lang="es-MX">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../public/img/sysmax_logo64.png" type="image/png">
  <link rel="stylesheet" href="../public/css/styles.css">
  <link rel="stylesheet" href="../public/css/dataTable.css">
  <link rel="stylesheet" href="../public/css/modal.css">
  <link href='../public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
  <title>Sysmax Tecnología S.A. de C.V.</title>
</head>
  <body>    
    <div class="main-con">
      <?php include_once "components/general/header.php"?>
      <main class="sysmax-main">
        <div class="sysmax-hero">
          <div class="hero-con">
            <div class="herobox">

            </div>
          </div>
        </div>
        <?php 
        if($_SESSION['permissions'] == '1'){
          include_once "components/admon/breakersDashboard.php";
          include_once "components/admon/modal.php";
        }else{
          include_once "components/general/singleBreakerData.php";
        }
        ?>
      </main>
      <?php include_once 'components/general/footer.php'?>  
    </div>
  </body>
  <script type="module" src="../public/js/modal.js"></script>
  <?php if (isset($_SESSION['permissions']) && $_SESSION['permissions'] == 1): ?>
    <script type="module" src="../public/js/dataTable.js"></script>
  <?php endif; ?>
  <script type="module">
    import { closeSession, getSingleBreakerData } from "../public/js/general.js";
    window.closeSession = closeSession;
    <?php if (isset($_SESSION['permissions']) && $_SESSION['permissions'] != 1): ?>
      document.addEventListener("DOMContentLoaded", async function(){
        const DATABREAKER = document.querySelector('#singleDataDashboard')
        const BREAKER_ID = DATABREAKER.getAttribute('breakerData')
        const RESPONSE = await getSingleBreakerData(BREAKER_ID)
        
        document.querySelector('.breakerDashboard-showConsumption').textContent = `${(RESPONSE.total_forward_energy)/100} kWh`;
        document.querySelector('.breakerDashboard-showStatus').textContent = RESPONSE.switch ? 'Encendido' : 'Apagado';
        document.querySelector('.breakerDashboard-showTemp').textContent = `${RESPONSE.temp_current} °C`;
      })
    <?php endif; ?>
  </script>
  <!-- <script>
    abrirModal();
  </script> -->
</html>
