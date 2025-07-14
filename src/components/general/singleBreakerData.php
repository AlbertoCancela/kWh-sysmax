<div id="singleDataDashboard" class="sysmax-con" breakerData="<?php echo $_SESSION['data']['userBreaker']; ?>">
  <div class="sysmax-box">
    <div class="box-reading">
      <h3 class="reading-title">Consumo Actual</h3>
      <i class='bx bx-tachometer bx-lg' style='color:#3c3c3c'  ></i>
      <p class="reading-txt breakerDashboard-showConsumption">
        <span class="loader">Obteniendo...</span>
      </p>           
    </div>                                         
    <div class="box-reading">
      <h3 class="reading-title"> Estado On / Off</h3>
      <i class='bx bx-power-off bx-lg' style='color:#3c3c3c'  ></i>
      <p class=" reading-txt breakerDashboard-showStatus">
        <span class="loader">Obteniendo...</span>
      </p>
    </div>                                 
    <div class="box-reading">
      <h3 class="reading-title">Temperatura</h3>
      <i class='bx bxs-thermometer bx-lg' style='color:#3c3c3c'  ></i>
      <p class="reading-txt breakerDashboard-showTemp">
        <span class="loader">Obteniendo...</span>
      </p>
    </div>                                
  </div>
</div>
<div class="report-con">
  <a href="#" class="btn-report">Descargar Reporte</a>          
</div>