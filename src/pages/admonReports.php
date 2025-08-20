<?php
    session_name('sysmax-tuya');
    session_start();
    if (!isset($_SESSION['userName'])) {
        header("Location: /kWh-sysmax/src/login.php");
        exit;
    }
//  echo $_SESSION['data']['id'];
    $name = $_SESSION['data']['name'];
    $id = $_SESSION['data']['id'];
    $userName = $_SESSION['userName'];

    $inicioMes = date('Y-m-01'); // Primer día del mes actual
    $finMes = date('Y-m-t');
?>
<!DOCTYPE html>
<html lang="es">
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
    <title>Tu proyecto</title>
</head>
    <body>    
        <div class="main-con">
        <?php include_once "../components/general/header.php"?>
        <?php include_once "../components/general/generalModal.php"?>
        <main class="sysmax-main">
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
                                        <td>001</td>
                                        <td>Sensor A</td>
                                        <td>23</td>
                                        <td>15.6</td>
                                        <td>Juan Pérez</td>
                                        <td>2025-08-09</td>
                                    </tr>
                                    <tr>
                                        <td>001</td>
                                        <td>Sensor A</td>
                                        <td>23</td>
                                        <td>15.6</td>
                                        <td>Juan Pérez</td>
                                        <td>2025-08-09</td>
                                    </tr>
                                    <tr>
                                        <td>001</td>
                                        <td>Sensor A</td>
                                        <td>23</td>
                                        <td>15.6</td>
                                        <td>Juan Pérez</td>
                                        <td>2025-08-09</td>
                                    </tr>
                                    <tr>
                                        <td>001</td>
                                        <td>Sensor A</td>
                                        <td>23</td>
                                        <td>15.6</td>
                                        <td>Juan Pérez</td>
                                        <td>2025-08-09</td>
                                    </tr>
                                    <tr>
                                        <td>001</td>
                                        <td>Sensor A</td>
                                        <td>23</td>
                                        <td>15.6</td>
                                        <td>Juan Pérez</td>
                                        <td>2025-08-09</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination"></div>
                    </section>
                    <section class="admon-reports-section2">
                        <div class="ars-title">
                            <h2> Presets y conversiones </h2> 
                        </div>
                        <div class="pressetsAndConvertions">
                            <div class="presets">
                                <div onclick="fetchDataFromPresets(this)" class="preset" presetQuery="safbsl15">Breakers con mayor consumo los últimos 15 días</div>
                                <div onclick="fetchDataFromPresets(this)" class="preset" presetQuery="sasbtcgb">Consumo histórico total por cada dispositivo</div>
                                <div onclick="fetchDataFromPresets(this)" class="preset" presetQuery="sabsgbd">Usuarios con menor consumo total por dispositivo</div>
                                <div onclick="fetchDataFromPresets(this)" class="preset" presetQuery="sabtcy">Consumo kWh por breaker del día anterior</div>
                            </div>
                            <div class="convertTo">
                                
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </main>
        </div>
        <script type="module" src="/kWh-sysmax/public/js/DT-reportDashboard.js"></script>
        <script type="module">
            import { closeSession } from "/kWh-sysmax/public/js/general.js";
            window.closeSession = closeSession;
        </script>
    </body>
</html>