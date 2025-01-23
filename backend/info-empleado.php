<?php 

include 'db.php';
header("Content-Type: application/json");

// Si no hay una sesión iniciada, redirigir al inicio
session_start();
if(!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

$empleadoId = isset($_POST['empleadoId']) ? $_POST['empleadoId'] : null;

if (!$empleadoId) {
    echo json_encode(['error' => 'No se proporcionó un ID de empleado válido.']);
    exit();
}

$sql = "SELECT usuarios.id, tipo_usuario, nombre, apellido, cedula, email, telefono, fecha_ingreso, cargos.cargo, cargos.area, cargos.salario_base, direccion.estado, direccion.municipio, direccion.parroquia, direccion.calle, direccion.zip, direccion.vivienda FROM `usuarios` LEFT JOIN cargos ON usuarios.id = cargos.usuario_id LEFT JOIN direccion ON usuarios.id = direccion.usuario_id WHERE usuarios.id = ?";

try{
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $empleadoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $empleado = $result->fetch_assoc();

    if (!$empleado) {
        echo json_encode(['error' => 'No se encontró el empleado.']);
        exit();
    }

    $estadoId = $empleado['estado'];
    $municipioId = $empleado['municipio'];
    $parroquiaId = $empleado['parroquia'];

    $sql = "SELECT estado FROM estados WHERE id_estado = ?";
    $sql2 = "SELECT municipio FROM municipios WHERE id_municipio = ?";
    $sql3 = "SELECT parroquia FROM parroquias WHERE id_parroquia = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $estadoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $empleado['estado'] = $result->fetch_assoc()['estado'];

    $stmt = $conn->prepare($sql2);
    $stmt->bind_param("i", $municipioId);
    $stmt->execute();
    $result = $stmt->get_result();
    $empleado['municipio'] = $result->fetch_assoc()['municipio'];

    $stmt = $conn->prepare($sql3);
    $stmt->bind_param("i", $parroquiaId);
    $stmt->execute();
    $result = $stmt->get_result();
    $empleado['parroquia'] = $result->fetch_assoc()['parroquia'];

    echo json_encode($empleado);


} catch (Exception $e) {
    echo json_encode(['error' => 'Error al obtener la información del empleado: ' . $e->getMessage()]);
    exit();
}

?>