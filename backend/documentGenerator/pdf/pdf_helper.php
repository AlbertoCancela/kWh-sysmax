<?php
require '../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function generarPDF(string $templatePath, array $data, string $fileName = 'documento.pdf', bool $descargar = false): void
{
    // Verificar que la plantilla exista
    if (!file_exists($templatePath)) {
        throw new Exception("No se encontró la plantilla: $templatePath");
    }

    // Cargar la plantilla HTML
    $template = file_get_contents($templatePath);

    // Reemplazar variables {{clave}}
    foreach ($data as $key => $value) {
        $template = str_replace('{{' . $key . '}}', htmlspecialchars($value), $template);
    }

    // Configurar opciones de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);

    // Cargar HTML procesado
    $dompdf->loadHtml($template);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Mostrar o descargar el PDF
    $dompdf->stream($fileName, ['Attachment' => $descargar]);
}
