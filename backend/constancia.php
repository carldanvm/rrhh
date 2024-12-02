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

    $salario_en_palabras = numero_a_palabras($salario);

    $fecha_actual = formatoFechaEspanol(date('Y-m-d'));
    $fecha_ingreso_escrita = formatoFechaEspanol($fecha_ingreso);

    // Crear el PDF
    $dompdf = new Dompdf();

    // Generar el contenido del PDF
    $html = "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Constancia de Trabajo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 50px; }
        .logo { float: left; }
        .date { float: right; font-size: 17px; margin-top: 15%; margin-right: 30px;}
        .clear { clear: both; }
        .title { text-align: center; margin-bottom: 20px; margin-top: 3%}
        .content { text-align: justify; margin: 0 30px; font-size: 19px;}
        .footer { text-align: center; margin-top: 30%; font-size: 17px;}
        .signature { margin-top: 30px; text-align: center; font-size: 17px;}
    </style>
</head>
<body>
    <div class='header'>
        <img src='img/LogoMicrosoft.jpg' class='logo' height='100' alt='logo de la empresa contratada'>
        <div class='date'>Caracas, " . $fecha_actual . "</div>
        <div class='clear'></div>
    </div>
    <div class='title'>
        <h3>A quien pueda interesar</h3>
    </div>
    <div class='content'>
        <p style='text-indent: 50px;'>Por medio de la presente, hacemos constar que <b>" . $nombre . " " . $apellido . "</b>,
        portador de la cédula de identidad número <b>" . $cedula . "</b> y número de teléfono <b>" . $telefono . "</b>, 
        labora en nuestra empresa <b>Microsoft Corp.</b> desde el " . $fecha_ingreso_escrita
        . " hasta la actualidad. Desempeña el cargo de <b>" . $cargo . "</b> en el departamento de <b>" . $area
        . "</b> con un salario mensual de <b>$" . $salario . " (" . $salario_en_palabras . " dólares estadounidenses)</b>,
        demostrando un alto nivel de compromiso, responsabilidad y dedicación en las labores que le han sido asignadas.</p>

        <p style='text-indent: 50px;'>Esta constancia se expide a solicitud del interesado, a los efectos que estime conveniente. Si tiene
        alguna pregunta o requiere información adicional, no dude en ponerse en contacto con nosotros.</p>
    </div>
    <div class='signature'>
        <p>Atentamente,</p>
        <br>
        <p><strong>Pepito Perez</strong></p>
        <p>Gerente de Recursos Humanos</p>
    </div>
    <div class='footer'>
        <hr>
        <p>Calle Juan, torre Banaven, piso 10, municipio Chacao, edo. Miranda, Caracas, Venezuela.</p>
        <p>Teléfono: (0212) 123-4567 - Correo: rrhh@gmail.com </p>
    </div>
</body>
</html>";

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
} catch (Exception $e) {
    echo json_encode(['error' => 'Error al generar la constancia: ' . $e->getMessage()]);
    exit();
}



// Enviar el PDF al navegador
echo json_encode(['success' => true, 'pdf_url' => 'backend/' . $pdfFile]);
