<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>
<body>
    <button>Excell</button>
    <button>PDF</button>
    <button>another</button>
    <div>
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
    </div>
</body>
<script type="module" src="/kWh-sysmax/public/js/DT-reportDashboard.js"></script>
<script type="module" src="/kWh-sysmax/public/js/general.js"></script>
<script>
    
</script>

<!-- <script type="module">
    import { closeSession, universalHandler } from "/kWh-sysmax/public/js/general.js";
    window.closeSession = closeSession;
    const value = await universalHandler();
    console.log(value);    
</script> -->
</html>