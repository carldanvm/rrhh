<?php
include 'db.php';
header("Content-Type: application/json");

// Si no hay una sesión iniciada, redirigir al inicio
session_start();
if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

/* Obtener la información de los empleados con sus horas trabajadas */
$sql = "SELECT u.id, u.tipo_usuario, u.nombre, u.apellido, u.cedula, u.email, u.fecha_ingreso, 
               c.salario_base, c.cargo,
               COALESCE(SUM(r.horas_trabajadas), 0) AS horas_trabajadas
        FROM usuarios u
        LEFT JOIN cargos c ON u.id = c.usuario_id
        LEFT JOIN registros r ON u.id = r.usuario_id AND MONTH(r.entrada) = MONTH(CURDATE())
        GROUP BY u.id";

$result = mysqli_query($conn, $sql);

$empleados = array();

while ($row = mysqli_fetch_assoc($result)) {
    $empleados[] = $row;
}

/* Por cada empleado, anadir una nueva propiedad "por cobrar" que va a ser la multiplicacion de salario base por horas trabajadas, si alguna propiedad es null, cambiarlo a 0 */
foreach ($empleados as &$empleado) {
    $empleado['por_cobrar'] = $empleado['salario_base'] * $empleado['horas_trabajadas'];
}

echo json_encode($empleados);
exit();
