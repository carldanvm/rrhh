<?php 
header("Content-Type: application/json");
include 'db.php';
require_once('lib/dompdf/autoload.inc.php');
use Dompdf\Dompdf;


// Si no hay una sesión iniciada, redirigir al inicio
session_start();
if(!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

// Obtener el ID del usuario al que se le va a generar la constancia, viene por POST
$empleadoId = $_POST['empleadoId'];
if (!$empleadoId) {
    echo json_encode(['error' => 'No se proporcionó un ID de empleado válido']);
    exit();
}

// Crear el PDF
$dompdf = new Dompdf();

// Generar el contenido del PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
            font-size: 16pt;
        }
    </style>
</head>
<body>
    <h1>Constancia de Trabajo</h1>
    <p>Esta es una constancia de trabajo para el empleado con el id: ' . $empleadoId . '</p>
</body>
</html>
';

// Insertar el contenido en el PDF, configurar el tamaño y la orientación
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

// Renderizar el PDF
$dompdf->render();

// Generar nombre unico para el PDF
$fecha = date('Y-m-d_H-i-s');
$pdfFile = 'constancias/constancia-trabajo_empleado_' . $empleadoId . '_' . $fecha . '.pdf';

// Guardar el PDF en el servidor
file_put_contents($pdfFile, $dompdf->output());

// Enviar el PDF al navegador
echo json_encode(['success' => true, 'pdf_url' => 'backend/' . $pdfFile]);

?>