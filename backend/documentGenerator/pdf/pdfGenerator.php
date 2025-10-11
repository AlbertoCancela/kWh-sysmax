<?php
require '../../../vendor/autoload.php';
require 'pdf_helper.php'; // contiene la función generarPDF()

// Leer el JSON enviado por fetch
$data = json_decode(file_get_contents("php://input"), true);

$finalRate = $data['finalRate'];
$owner = $data['owner'];
$breaker = $data['breaker'];

$htmlData = [
    'autor' => $owner,
    'fecha' => date('d/m/Y H:i:s'),
    'tarifa' => '$' . $finalRate,
    'mensaje' => 'Este recibo debe considerarse a la tarifa en la fecha indicada.'
];

// Generar el PDF pero no mostrarlo directamente
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$template = file_get_contents('plantilla.html');
foreach ($htmlData as $key => $value) {
    $template = str_replace('{{' . $key . '}}', htmlspecialchars($value), $template);
}

$dompdf->loadHtml($template);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar el PDF como respuesta binaria al navegador
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="recibo.pdf"');
echo $dompdf->output();
