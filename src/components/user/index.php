<?php
    require_once '../backend/tuyaController.php'
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../public/img/sysmax_logo_transp.png" type="image/x-icon">
  <link rel="stylesheet" href="../public/css/styles.css">
  <link href='../public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
  <title>Sysmax Tecnología S.A. de C.V.</title>
</head>
  <body>    
    <div class="main-con">
      <?php include_once "components/header.php"?>
      <main class="sysmax-main">
        <div class="sysmax-con">
          <div class="sysmax-box">
            <div class="box-reading">
              <h3 class="reading-title">Consumo Actual</h3>
              <i class='bx bx-tachometer bx-lg' style='color:#3c3c3c'  ></i>
              <p class="reading-txt">
                    <?php echo number_format($kWh['value']/100,'2','.') . ' kWh' ?>
              </p>           
            </div>                                         
            <div class="box-reading">
              <h3 class="reading-title"> Estado On / Off</h3>
              <i class='bx bx-power-off bx-lg' style='color:#3c3c3c'  ></i>
              <p class="reading-txt">
                <?php echo $status['value'] == '1' ? 'Encendido' : 'Apagado' ?>
              </p>
            </div>                                 
            <div class="box-reading">
              <h3 class="reading-title">Temperatura</h3>
              <i class='bx bxs-thermometer bx-lg' style='color:#3c3c3c'></i>
              <p class="reading-txt">
                    <?php echo $tempCurrent['value'] . '°C' ?>
              </p>
            </div>                                
          </div>
        </div>
        <div class="report-con">
          <a href="#" class="btn-report">Descargar Reporte</a>          
        </div>                  
      </main>
      <?php include_once 'components/footer.php'?>  
    </div>
        <script src="public/js/startSetUp.js"></script>
  </body>
</html>