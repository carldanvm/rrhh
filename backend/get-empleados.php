<?php
include 'db.php';
header("Content-Type: application/json");

// Si no hay una sesión iniciada, redirigir al inicio
session_start();
if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

$sql = "SELECT id, tipo_usuario, nombre, apellido, cedula, email, fecha_ingreso FROM usuarios";
$result = mysqli_query($conn, $sql);

$empleados = array();

while ($row = mysqli_fetch_assoc($result)) {
    $empleados[] = $row;
}

echo json_encode($empleados);
exit();
