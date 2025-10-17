<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>testZone</title>
</head>
<body>
    <button data-idBreaker="65e6a732254c5669aceikp" class=""> Prueba 1</button>
    <button data-idBreaker="6520fc0a00a365c22als9f" class=""> Prueba 2</button>
    <button onclick = "printRateByTimeAndId('65e6a732254c5669aceikp', '2025-10-02', '2025-10-06')"> prueba test </button>
    <script src="public/js/rates.js"></script>
    <script type="module">
        import { getBreakerConsumption, getRateValue } from "/kWh-sysmax/public/js/general.js";
        window.getBreakerConsumption = getBreakerConsumption;
        window.getRateValue = getRateValue;
    </script>
</body>
</html>