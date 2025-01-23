<?php
include 'db.php';
date_default_timezone_set('America/Caracas');
header("Content-Type: application/json");

// Si no hay una sesión iniciada, redirigir al inicio
session_start();
if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

// Definir el rango de fechas para el cálculo de asistencias
// Desde el primer día del mes actual hasta ayer
$primerDiaMes = date('Y-m-01'); 
$ayer = date('Y-m-d', strtotime('yesterday')); 

// Array para almacenar las fechas de días laborables (lunes a viernes)
$diasLaborables = array();

// Crear objeto DateTime para iterar desde el primer día del mes hasta ayer
$fecha = new DateTime($primerDiaMes);
$fechaFin = new DateTime($ayer);

// Recorrer cada día y guardar solo los días laborables (lunes a viernes)
while ($fecha <= $fechaFin) {
    $diaSemana = $fecha->format('N'); // 1 (lunes) a 7 (domingo)
    
    // Si es día de semana (1-5, lunes a viernes)
    if ($diaSemana <= 5) {
        $diasLaborables[] = $fecha->format('Y-m-d');
    }
    
    $fecha->modify('+1 day');
}

// Consulta SQL para obtener información de empleados y sus horas trabajadas
// Une las tablas usuarios, cargos y registros para obtener toda la información necesaria
$sql = "SELECT 
    u.id, u.tipo_usuario, u.nombre, u.apellido, u.cedula, u.email, u.fecha_ingreso, 
    c.salario_base, c.cargo,
    COALESCE(SUM(r.horas_trabajadas), 0) AS horas_trabajadas
FROM 
    usuarios u
    -- Unión con la tabla cargos para obtener información del cargo y salario
    LEFT JOIN cargos c ON u.id = c.usuario_id
    -- Unión con la tabla registros para obtener las horas trabajadas este mes
    LEFT JOIN registros r ON u.id = r.usuario_id AND MONTH(r.entrada) = MONTH(CURDATE())
GROUP BY u.id";

$infoEmpleado = mysqli_query($conn, $sql);
$empleados = array();
while ($row = mysqli_fetch_assoc($infoEmpleado)) {
    $empleados[] = $row;
}

// Obtener las fechas específicas de asistencia de cada empleado en el mes actual
$sql = "SELECT 
    r.usuario_id,
    DATE(r.entrada) as fecha_asistencia
FROM registros r
WHERE MONTH(r.entrada) = MONTH(CURDATE())
GROUP BY r.usuario_id, DATE(r.entrada)";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Crear un array que mapea cada usuario_id con sus fechas de asistencia
$asistenciasPorUsuario = array();
while ($row = $result->fetch_assoc()) {
    if (!isset($asistenciasPorUsuario[$row['usuario_id']])) {
        $asistenciasPorUsuario[$row['usuario_id']] = array();
    }
    $asistenciasPorUsuario[$row['usuario_id']][] = $row['fecha_asistencia'];
}

// Calcular las inasistencias comparando días laborables vs días de asistencia
$inasistenciasPorUsuario = array();
foreach ($empleados as $empleado) {
    $inasistenciasPorUsuario[$empleado['id']] = array();
    $asistenciasEmpleado = $asistenciasPorUsuario[$empleado['id']] ?? array();
    
    // Si un día laborable no está en las asistencias, es una inasistencia
    foreach ($diasLaborables as $dia) {
        if (!in_array($dia, $asistenciasEmpleado)) {
            $inasistenciasPorUsuario[$empleado['id']][] = $dia;
        }
    }
}

// Obtener los días libres (vacaciones, permisos) del mes actual
$sql = "SELECT usuario_id, fecha_inicio, fecha_final FROM dias_libres";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Procesar los rangos de días libres y convertirlos en días individuales
$usuariosDiasLibres = array();

while($row = $result->fetch_assoc()) {
    $usuario_id = $row['usuario_id'];
    $inicio = new DateTime($row['fecha_inicio']);
    $final = new DateTime($row['fecha_final']);
    $final->modify('+1 day'); // Incluir el día final en el rango
    
    // Inicializar array para el usuario si no existe
    if (!isset($usuariosDiasLibres[$usuario_id])) {
        $usuariosDiasLibres[$usuario_id] = array(
            'usuario_id' => $usuario_id,
            'dias_libres' => array()
        );
    }
    
    // Generar todas las fechas entre inicio y final
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($inicio, $interval, $final);
    
    // Guardar cada fecha individual
    foreach ($period as $fecha) {
        $usuariosDiasLibres[$usuario_id]['dias_libres'][] = $fecha->format('Y-m-d');
    }
}

// Eliminar duplicados y convertir a array indexado
$resultadoDiasLibres = array();
foreach ($usuariosDiasLibres as $dias) {
    $dias['dias_libres'] = array_values(array_unique($dias['dias_libres']));
    $resultadoDiasLibres[] = $dias;
}

/* Calcular propiedades finales para cada empleado */
foreach ($empleados as &$empleado) {
    // Calcular monto por cobrar (salario base * horas trabajadas)
    $empleado['por_cobrar'] = $empleado['salario_base'] * $empleado['horas_trabajadas'];
    
    // Obtener los días libres del empleado
    $diasLibresEmpleado = [];
    foreach ($resultadoDiasLibres as $dl) {
        if ($dl['usuario_id'] == $empleado['id']) {
            $diasLibresEmpleado = $dl['dias_libres'];
            break;
        }
    }
    
    // Obtener las inasistencias del empleado
    $inasistenciasBase = $inasistenciasPorUsuario[$empleado['id']] ?? [];
    
    // Calcular inasistencias reales: 
    // Solo contar los días que el empleado faltó Y NO eran días libres aprobados
    $inasistenciasReales = 0;
    foreach ($inasistenciasBase as $fecha) {
        if (!in_array($fecha, $diasLibresEmpleado)) {
            $inasistenciasReales++;
        }
    }
    
    $empleado['inasistencias'] = $inasistenciasReales;
}

echo json_encode($empleados);
exit();
