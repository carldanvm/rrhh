<?php
include 'db.php';
header("Content-Type: application/json");

// Si no hay una sesion iniciada, redirigir al inicio
session_start();
if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

// Obtener y validar datos
$empleadoId = isset($_POST['empleadoId']) ? $_POST['empleadoId'] : null;
$fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : null;
$fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : null;

// Validaciones
if (!$empleadoId) {
    echo json_encode(['success' => false, 'error' => 'No se proporcionó un ID de empleado']);
    exit();
}

if (!$fechaInicio) {
    echo json_encode(['success' => false, 'error' => 'No se proporcionó una fecha de inicio']);
    exit();
}

if (!$fechaFin) {
    echo json_encode(['success' => false, 'error' => 'No se proporcionó una fecha de fin']);
    exit();
}

// Convertir fechas de DD/MM/YYYY a YYYY-MM-DD
$fechaInicio = DateTime::createFromFormat('d/m/Y', $fechaInicio)->format('Y-m-d');
$fechaFin = DateTime::createFromFormat('d/m/Y', $fechaFin)->format('Y-m-d');

// Preparar la consulta SQL usando prepared statements para evitar SQL injection
$sql = "INSERT INTO dias_libres (usuario_id, fecha_inicio, fecha_final) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $empleadoId, $fechaInicio, $fechaFin);

if ($stmt->execute()) {
    $_SESSION['mensaje'] = 'Días libres asignados correctamente';
    echo json_encode(['success' => true, 'message' => 'Días libres asignados correctamente']);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();