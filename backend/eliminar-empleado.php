<?php
include 'db.php';
header("Content-Type: application/json");

// Si no hay una sesion iniciada, redirigir al inicio
session_start();
if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

// Obtener el ID del empleado a eliminar
$empleadoId = $_POST['empleadoId'];

if (!$empleadoId) {
    echo json_encode(['success' => false, 'error' => 'No se proporcionó un ID de empleado']);
    exit();
}

// Eliminar el empleado
$stmt = mysqli_prepare($conn, "DELETE FROM usuarios WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $empleadoId);
mysqli_stmt_execute($stmt);
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Error al eliminar el empleado']);
    exit();
}

echo json_encode(['success' => true]);