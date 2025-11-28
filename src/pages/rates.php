<?php
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
    <link rel="shortcut icon" href="/public/img/sysmax_logo64.png" type="image/png">
    <link rel="stylesheet" href="/public/css/styles.css">
    <link rel="stylesheet" href="/public/css/generalModal.css">
    <!-- <link rel="stylesheet" href="/kWh-sysmax/public/css/userSettings.css"> -->
    <link rel="stylesheet" href="/public/css/admonReports.css">
    <link href='/public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tu proyecto</title>
</head>
    <body>            
        <div class="main-con">        
        <?php include_once __DIR__ . "/../components/general/header.php"?>
        <?php include_once __DIR__ . "/../components/general/generalModal.php"?>
        <main class="sysmax-main">            
            <?php include_once __DIR__ . "/../components/admon/adminHeader.php"?>            
            <section class="flex justify-center items-center w-full h-full bg-color">
                <div class="flex justify-center gap-10 w-[85%] h-[85%] border">
                    <div class="flexflex-col basis-2/3 border">
                        <div class="flex justify-center items-center w-full bg-neutral-700 h-16">
                            <h1 class="text-lime-300 font-bold">TARIFAS</h1>
                        </div>
                        <div class="w-full h-full bg-gray-50">
                            <div class="p-4">
                                <table id="table-rates" class="modal-table_records">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE DISP</th>
                                            <th>CONSUMO (kWh)</th>
                                            <th>CONSUMO (MXN)</th>
                                            <th>IMPRIMIR</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr>
                                            <td colspan="4">Cargando...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col basis-1/3 border">
                        <div class="flex justify-center items-center w-full bg-neutral-700 h-16">
                            <h1 class="bg-neutral-700 text-lime-300 font-bold">AJUSTES</h1>
                        </div>
                        <div class="flex justify-center items-center w-full h-full bg-gray-50">
                            <div class="w-[80%] h-[90%] text-neutral-700 font-bold">
                                <p>Actualmente el total de la tarifa se calcula</p>
                                <p class="text-xl text-center"><i class="text-green-500">1</i> kWh ≈ <i id="p-rateValue" class="text-green-500">-</i> MXN</p>
                                <p>Este tarifa fue establecida el día <i id="p-rateDate" class="text-red-400">06 de octubre del 2025</i>
                                <br>
                                <p>En caso de ser necesario el ajuste a la tarifa, establezca el nuevo valor de pesos * kWh  en el recuadro debajo de este texto</p>
                                <p class="mt-2" for="newRate">Nueva Tarifa</p>
                                <input class="border" id="newRate" type="text" name="newRate">
                                <button onclick="updateRate()"class="mt-4 w-36 h-10 bg-lime-300 radius-lg hover:bg-lime-500 transition ease-in-out "> Guardar cambios </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        </div>
        <script type="module" src="/public/js/DT-ratesDashboard.js"></script>
        <script type="module" src="/public/js/rates.js"></script>
        <script type="module">
            import { closeSession, getRateValue, updateRateValue} from "/public/js/general.js";
            window.closeSession = closeSession;
            window.getRateValue = getRateValue;
            window.updateRateValue = updateRateValue;

            // async function testRate() {
            //     const result = await changeRateValue(1);
            //     console.log(result);
            //     // Ejemplo de acceso directo a los datos:
            //     console.log(result.status); // "ok"
            //     console.log(result.breakers[0].RATE_VALUE); // 1.29
            //     console.log(result.breakers[0].UPDATE_AT);  // "2025-10-10 20:51:21"
            // }

            // testRate();

        </script>
    </body>
</html>