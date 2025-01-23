<?php
header("Content-Type: application/json");
include 'db.php';
require_once('lib/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

// Si no hay una sesión iniciada, redirigir al inicio
session_start();
if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

// Función para convertir números a palabras 
function numero_a_palabras($num)
{
    $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
    return $f->format($num);
}

// Función para formatear la fecha de forma escrita
function formatoFechaEspanol($fecha)
{
    $meses = [
        1 => 'enero',
        2 => 'febrero',
        3 => 'marzo',
        4 => 'abril',
        5 => 'mayo',
        6 => 'junio',
        7 => 'julio',
        8 => 'agosto',
        9 => 'septiembre',
        10 => 'octubre',
        11 => 'noviembre',
        12 => 'diciembre'
    ];

    $fechaTimestamp = strtotime($fecha);
    $dia = date('d', $fechaTimestamp);
    $mes = $meses[date('n', $fechaTimestamp)];
    $anio = date('Y', $fechaTimestamp);

    return "$dia de $mes de $anio";
}


// Obtener el ID del usuario al que se le va a generar la constancia, viene por POST
$empleadoId = $_POST['empleadoId'];
if (!$empleadoId) {
    echo json_encode(['error' => 'No se proporcionó un ID de empleado válido']);
    exit();
}

$motivo = $_POST['motivo'];
if (!$motivo) {
    echo json_encode(['error' => 'No se proporcionó un motivo válido']);
    exit();
}

try {
    // Obtener la información del empleado que se va a utilizar para la constancia
    $sql = "SELECT usuarios.id, tipo_usuario, nombre, apellido, cedula, email, telefono, fecha_ingreso, cargos.cargo, cargos.area, cargos.salario_base, direccion.estado, direccion.municipio, direccion.ciudad, direccion.calle, direccion.zip, direccion.vivienda FROM `usuarios` LEFT JOIN cargos ON usuarios.id = cargos.usuario_id LEFT JOIN direccion ON usuarios.id = direccion.usuario_id WHERE usuarios.id = $empleadoId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $empleado = $result->fetch_assoc();
        $nombre = $empleado['nombre'];
        $apellido = $empleado['apellido'];
        $cedula = $empleado['cedula'];
        $telefono = $empleado['telefono'];
        $fecha_ingreso = $empleado['fecha_ingreso'];
        $cargo = $empleado['cargo'];
        $salario = $empleado['salario_base'];
        $area = $empleado['area'];
    } else {
        echo json_encode(['error' => 'Empleado no encontrado']);
        exit();
    }

    /* Validar que el salario sea un número válido y no nulo */
    if (!is_numeric($salario) || $salario === null) {
        throw new Exception('El salario debe ser un número válido');
        exit();
    }

    /* Validar que la fecha de ingreso sea una fecha válida y no nula */
    if (!is_string($fecha_ingreso) || $fecha_ingreso === null) {
        throw new Exception('La fecha de ingreso debe ser una fecha válida');
        exit();
    }

    $fecha_actual = formatoFechaEspanol(date('Y-m-d'));
    $fecha_ingreso_escrita = formatoFechaEspanol($fecha_ingreso);

    /* Ruta de la imagen de la empresa */
    $logoPath = realpath(dirname(__DIR__) . '/img/logo.png');
    $imageData = base64_encode(file_get_contents($logoPath));

    /* Ruta de la imagen de la firma */
    $firmaPath = realpath(dirname(__DIR__) . '/backend/firma/firma.png');
    $firmaData = base64_encode(file_get_contents($firmaPath));
    $srcFirma = "data:image/png;base64," . $firmaData;

    // Generar nombre único para el archivo según el motivo
    $timestamp = date('Ymd_His');
    $tipo_documento = '';
    
    switch(strtolower($motivo)) {
        case 'renuncia':
            $tipo_documento = 'constancia_recepcion_renuncia';
            $html = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .header { text-align: center; margin-bottom: 20px; }
                    .logo { max-width: 200px; }
                    .content { margin: 20px 40px; text-align: justify; }
                    .fecha { text-align: right; margin: 20px 40px; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <img src='data:image/png;base64,$imageData' class='logo'>
                    <h2>CONSTANCIA DE RECEPCIÓN DE RENUNCIA</h2>
                </div>
                <div class='fecha'>$fecha_actual</div>
                <div class='content'>
                    <p>Por medio de la presente, se deja constancia de haber recibido la carta de renuncia presentada por 
                    el(la) trabajador(a) $nombre $apellido, titular de la cédula de identidad N° $cedula, quien se 
                    desempeñaba en el cargo de $cargo en el área de $area desde el $fecha_ingreso_escrita.</p>
                    
                    <p>La renuncia ha sido recibida y procesada en fecha $fecha_actual, siguiendo los procedimientos 
                    establecidos por la empresa para tales fines.</p>
                    
                    <p>Se procederá con los trámites correspondientes para la liquidación de las prestaciones 
                    sociales según lo establecido por la ley.</p>
                </div>
                <table style='width: 100%; margin-top: 100px; border-collapse: collapse;'>
                    <tr style='vertical-align: top;'>
                        <td style='width: 50%; text-align: center; padding: 0 20px;'>
                            <div style='border-bottom: 1px solid black; margin-bottom: 5px;'>
                                <img src='$srcFirma' style='height: 60px; margin-bottom: -20px;' alt='Firma RRHH'>
                            </div>
                            <p style='margin: 5px 0;'>Departamento de Recursos Humanos</p>
                            <p style='margin: 5px 0;'>Fecha: $fecha_actual</p>
                        </td>
                        <td style='width: 50%; text-align: center; padding: 0 20px;'>
                            <div style='border-bottom: 1px solid black; margin-bottom: 5px;'>&nbsp;</div>
                            <p style='margin: 5px 0;'>$nombre $apellido</p>
                            <p style='margin: 5px 0;'>C.I: $cedula</p>
                            <p style='margin: 5px 0;'>Empleado</p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>";
            break;
            
        case 'despido':
            $tipo_documento = 'carta_despido';
            $html = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .header { text-align: center; margin-bottom: 20px; }
                    .logo { max-width: 200px; }
                    .content { margin: 20px 40px; text-align: justify; }
                    .fecha { text-align: right; margin: 20px 40px; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <img src='data:image/png;base64,$imageData' class='logo'>
                    <h2>NOTIFICACIÓN DE TERMINACIÓN DE CONTRATO</h2>
                </div>
                <div class='fecha'>$fecha_actual</div>
                <div class='content'>
                    <p>Por medio de la presente, se notifica formalmente la terminación de la relación laboral con 
                    el(la) trabajador(a) $nombre $apellido, titular de la cédula de identidad N° $cedula, quien se 
                    desempeñaba en el cargo de $cargo en el área de $area desde el $fecha_ingreso_escrita.</p>
                    
                    <p>La decisión se ha tomado conforme a las disposiciones legales vigentes y en cumplimiento 
                    de nuestras políticas internas.</p>
                    
                    <p>Se procederá con los trámites correspondientes para la liquidación de las prestaciones 
                    sociales según lo establecido por la ley.</p>
                </div>
                <table style='width: 100%; margin-top: 100px; border-collapse: collapse;'>
                    <tr style='vertical-align: top;'>
                        <td style='width: 50%; text-align: center; padding: 0 20px;'>
                            <div style='border-bottom: 1px solid black; margin-bottom: 5px;'>
                                <img src='$srcFirma' style='height: 60px; margin-bottom: -20px;' alt='Firma RRHH'>
                            </div>
                            <p style='margin: 5px 0;'>Departamento de Recursos Humanos</p>
                            <p style='margin: 5px 0;'>Fecha: $fecha_actual</p>
                        </td>
                        <td style='width: 50%; text-align: center; padding: 0 20px;'>
                            <div style='border-bottom: 1px solid black; margin-bottom: 5px;'>&nbsp;</div>
                            <p style='margin: 5px 0;'>$nombre $apellido</p>
                            <p style='margin: 5px 0;'>C.I: $cedula</p>
                            <p style='margin: 5px 0;'>Empleado</p>
                            <p><small>Firma en señal de recibido</small></p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>";
            break;
            
        default:
            $tipo_documento = 'carta_terminacion';
            $html = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .header { text-align: center; margin-bottom: 20px; }
                    .logo { max-width: 200px; }
                    .content { margin: 20px 40px; text-align: justify; }
                    .fecha { text-align: right; margin: 20px 40px; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <img src='data:image/png;base64,$imageData' class='logo'>
                    <h2>CONSTANCIA DE TERMINACIÓN LABORAL</h2>
                </div>
                <div class='fecha'>$fecha_actual</div>
                <div class='content'>
                    <p>Por medio de la presente, se deja constancia de la terminación de la relación laboral con 
                    el(la) trabajador(a) $nombre $apellido, titular de la cédula de identidad N° $cedula, quien se 
                    desempeñaba en el cargo de $cargo en el área de $area desde el $fecha_ingreso_escrita.</p>
                    
                    <p>Motivo de terminación: $motivo</p>
                    
                    <p>Durante su tiempo de servicio, el(la) trabajador(a) cumplió con las responsabilidades 
                    asignadas a su cargo. Se procederá con los trámites correspondientes según lo establecido 
                    por la ley.</p>
                </div>
                <table style='width: 100%; margin-top: 100px; border-collapse: collapse;'>
                    <tr style='vertical-align: top;'>
                        <td style='width: 50%; text-align: center; padding: 0 20px;'>
                            <div style='border-bottom: 1px solid black; margin-bottom: 5px;'>
                                <img src='$srcFirma' style='height: 60px; margin-bottom: -20px;' alt='Firma RRHH'>
                            </div>
                            <p style='margin: 5px 0;'>Departamento de Recursos Humanos</p>
                            <p style='margin: 5px 0;'>Fecha: $fecha_actual</p>
                        </td>
                        <td style='width: 50%; text-align: center; padding: 0 20px;'>
                            <div style='border-bottom: 1px solid black; margin-bottom: 5px;'>&nbsp;</div>
                            <p style='margin: 5px 0;'>$nombre $apellido</p>
                            <p style='margin: 5px 0;'>C.I: $cedula</p>
                            <p style='margin: 5px 0;'>Empleado</p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>";
    }

    // Crear el nombre del archivo
    $nombre_archivo = "{$tipo_documento}_{$cedula}_{$timestamp}.pdf";
    
    // Asegurarse de que existe el directorio
    $dir = __DIR__ . '/eliminar-pdf';
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    
    // Crear el PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter', 'portrait');
    $dompdf->render();
    
    // Guardar el archivo
    $output = $dompdf->output();
    $pdf_path = $dir . '/' . $nombre_archivo;
    file_put_contents($pdf_path, $output);
    
    // Devolver la URL relativa del PDF
    $pdf_url = 'backend/eliminar-pdf/' . $nombre_archivo;
    echo json_encode(['success' => true, 'pdf_url' => $pdf_url]);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit();
}
