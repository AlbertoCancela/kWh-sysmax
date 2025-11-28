<?php
    $name = $_SESSION['data']['name'];
    $id = $_SESSION['data']['id'];
    $userName = $_SESSION['userName'];

    $inicioMes = date('Y-m-01');
    $finMes = date('Y-m-t');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/img/sysmax_logo64.png" type="image/png">
    <link rel="stylesheet" href="/public/css/styles.css">
    <!-- <link rel="stylesheet" href="/kWh-sysmax/public/css/generalModal.css"> -->
    <!-- <link rel="stylesheet" href="/kWh-sysmax/public/css/userSettings.css"> -->
    <link rel="stylesheet" href="/public/css/admonReports.css">
    <link href='/public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Tu proyecto</title>
</head>
    <body>            
        <div class="main-con">        
        <?php include_once __DIR__ . "/../components/general/header.php"?>
        <?php // include_once "../components/general/generalModal.php"?>
        <main class="sysmax-main">            
            <?php include_once __DIR__ . "/../components/admon/adminHeader.php"?>            
            <section class="admon-reports">                                
                <div class="admon-reports-mainContainer">                    
                    <section class="admon-reports-section1">                        
                        <div class="filters">
                            <div class="filterSection">
                                <div class="filter-title">Rango de fechas</div>
                                <div class="field">
                                <label>Desde</label>
                                <input id="date-start" type="date" value="<?php echo $inicioMes; ?>">
                                </div>
                                <div class="field">
                                <label>Hasta</label>
                                <input id="date-end" type="date" value="<?php echo $finMes; ?>">
                                </div>
                            </div>
                            <div class="filterSection">
                                <div class="filter-title">Ordenar por</div>
                                <div class="field">
                                <label>Consumo</label>
                                <select id="orderByConsumption">
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    <option value="DESC">Mayor consumo</option>
                                    <option value="ASC">Menor consumo</option>
                                </select>
                                </div>
                                <div class="field">
                                <label>Fecha</label>
                                <select id="orderByDate">
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    <option value="DESC">Más reciente</option>
                                    <option value="ASC">Más antigua</option>
                                </select>
                                </div>
                            </div>

                            <div class="filterSection">
                                <div class="filter-title">Búsqueda</div>
                                <!-- <div class="field">
                                    <label>Tipo</label>
                                    <select>
                                        <option>Totales/promedio</option>
                                        <option>Solo totales</option>
                                        <option>Solo promedio</option>
                                    </select>
                                </div> -->
                                <div class="field">
                                <label>Departamento</label>
                                <input id="breakerSearchInput" type="text" placeholder="código departamento...">
                                </div>
                            </div>

                            <div class="filterSection filterSection--cta">
                                <button onclick="searchData()" class="btnSearch">Buscar</button>
                            </div>
                        </div>
                        <div class="admon-reports-table">
                            <table id="table-reports" class="modal-table_records">
                                <thead>
                                    <tr>
                                    <th>ID_DISPOSITIVO</th>
                                    <th>DEPTO</th>
                                    <th>TEMPERATURA (°C)</th>
                                    <th>CONSUMO (kWh)</th>
                                    <th>USUARIO</th>
                                    <th>FECHA REGISTRO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6"> Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination"></div>
                    </section>
                    <section class="admon-reports-section2">
                        <div class="ars-title">
                            <h3> REPORTES </h3> 
                        </div>
                        <div class="pressetsAndConvertions">
                            <div class="presets">
                                <div onclick="fetchDataFromPresets(1)" class="preset" >Breakers con mayor consumo los últimos 15 días</div>
                                <div onclick="fetchDataFromPresets(2)" class="preset" >Consumo histórico total por cada dispositivo</div>
                                <div onclick="fetchDataFromPresets(3)" class="preset" >Usuarios con menor consumo total por dispositivo</div>
                                <div onclick="fetchDataFromPresets(4)" class="preset" >Consumo kWh por breaker del día anterior</div>
                            </div>
                            <div class="convertTo">
                                
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </main>
        </div>
        <script type="module" src="/public/js/DT-reportDashboard.js"></script>
        <script type="module">
            import { closeSession } from "/public/js/general.js";
            window.closeSession = closeSession;
        </script>
    </body>
</html>