<?php
include 'db.php';
date_default_timezone_set('America/Caracas');
header("Content-Type: application/json");

// Si no hay una sesión iniciada, redirigir al inicio
session_start();
/* if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
} */

/* Obtener la información de los empleados con sus horas trabajadas */
$primerDiaMes = date('Y-m-01'); // Primer día del mes actual
$ayer = date('Y-m-d', strtotime('yesterday')); // Día anterior al actual

// Array para almacenar las fechas de días laborables
$diasLaborables = array();

// Crear objeto DateTime para el primer día del mes
$fecha = new DateTime($primerDiaMes);
$fechaFin = new DateTime($ayer);

// Recorrer los días hasta ayer
while ($fecha <= $fechaFin) {
    $diaSemana = $fecha->format('N'); // 1 (lunes) a 7 (domingo)
    
    // Si es día de semana (1-5, lunes a viernes)
    if ($diaSemana <= 5) {
        $diasLaborables[] = $fecha->format('Y-m-d');
    }
    
    // Avanzar al siguiente día
    $fecha->modify('+1 day');
}

// Consulta SQL para obtener información de empleados y sus horas trabajadas
$sql = "SELECT 
    u.id, u.tipo_usuario, u.nombre, u.apellido, u.cedula, u.email, u.fecha_ingreso, 
    c.salario_base, c.cargo,
    COALESCE(SUM(r.horas_trabajadas), 0) AS horas_trabajadas
FROM 
    usuarios u
    -- Unión con la tabla cargos para obtener información del cargo
    LEFT JOIN cargos c ON u.id = c.usuario_id
    -- Unión con la tabla registros para obtener las horas trabajadas este mes
    LEFT JOIN registros r ON u.id = r.usuario_id AND MONTH(r.entrada) = MONTH(CURDATE())
-- Agrupamos por id de usuario para obtener la suma de horas trabajadas por cada empleado
GROUP BY u.id";

$infoEmpleado = mysqli_query($conn, $sql);

$empleados = array();

while ($row = mysqli_fetch_assoc($infoEmpleado)) {
    $empleados[] = $row;
}

// Obtener asistencias del mes actual
$sql = "SELECT 
    r.usuario_id,
    COUNT(DISTINCT DATE(r.entrada)) as total_asistencias
FROM registros r
WHERE MONTH(r.entrada) = MONTH(CURDATE())
GROUP BY r.usuario_id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Calcular total de días laborables (ya tenemos el array $diasLaborables)
$totalDiasLaborables = count($diasLaborables);

// Crear array asociativo de inasistencias por ID
$inasistenciasPorUsuario = array();
while ($row = $result->fetch_assoc()) {
    $inasistenciasPorUsuario[$row['usuario_id']] = $totalDiasLaborables - $row['total_asistencias'];
}

/* Por cada empleado, añadir propiedades calculadas */
foreach ($empleados as &$empleado) {
    $empleado['por_cobrar'] = $empleado['salario_base'] * $empleado['horas_trabajadas'];
    // Agregar inasistencias (0 si no tiene registros)
    $empleado['inasistencias'] = $inasistenciasPorUsuario[$empleado['id']] ?? $totalDiasLaborables;
}

echo json_encode($empleados);
exit();
