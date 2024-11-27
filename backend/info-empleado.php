<?php 

include 'db.php';
header("Content-Type: application/json");

$empleadoId = isset($_POST['empleadoId']) ? $_POST['empleadoId'] : null;

if (!$empleadoId) {
    echo json_encode(['error' => 'No se proporcionó un ID de empleado válido.']);
    exit();
}

$sql = "SELECT usuarios.id, tipo_usuario, nombre, apellido, cedula, email, telefono, fecha_ingreso, cargos.cargo, cargos.area, cargos.salario_base, direccion.estado, direccion.municipio, direccion.ciudad, direccion.calle, direccion.zip, direccion.vivienda FROM `usuarios` LEFT JOIN cargos ON usuarios.id = cargos.usuario_id LEFT JOIN direccion ON usuarios.id = direccion.usuario_id WHERE usuarios.id = $empleadoId";

try{
    $result = $conn->query($sql);
    $empleado = $result->fetch_assoc();

    echo json_encode($empleado);


} catch (Exception $e) {
    echo json_encode(['error' => 'Error al obtener la información del empleado: ' . $e->getMessage()]);
    exit();
}

?>