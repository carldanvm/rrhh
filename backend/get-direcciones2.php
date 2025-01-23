<?php
include 'db.php';

// Si no hay una sesion iniciada, redirigir al inicio
session_start();
if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

header('Content-Type: application/json');

try {
    // Consulta optimizada que obtiene todos los datos en una sola consulta
    $sql = "SELECT 
                e.id_estado,
                e.estado,
                m.id_municipio,
                m.municipio,
                p.id_parroquia,
                p.parroquia
            FROM estados e
            LEFT JOIN municipios m ON e.id_estado = m.id_estado
            LEFT JOIN parroquias p ON m.id_municipio = p.id_municipio
            ORDER BY e.estado, m.municipio, p.parroquia";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Error en la consulta: " . $conn->error);
    }

    $data = array();
    
    // Procesar los resultados y estructurarlos jerárquicamente
    while ($row = $result->fetch_assoc()) {
        $estadoId = $row['id_estado'];
        $municipioId = $row['id_municipio'];

        // Si el estado no existe en el array, crearlo
        if (!isset($data[$estadoId])) {
            $data[$estadoId] = array(
                'id' => $estadoId,
                'nombre' => $row['estado'],
                'municipios' => array()
            );
        }

        // Si hay un municipio y no existe en el array del estado, crearlo
        if ($municipioId && !isset($data[$estadoId]['municipios'][$municipioId])) {
            $data[$estadoId]['municipios'][$municipioId] = array(
                'id' => $municipioId,
                'nombre' => $row['municipio'],
                'parroquias' => array()
            );
        }

        // Si hay una parroquia, agregarla al municipio correspondiente
        if ($row['id_parroquia'] && $municipioId) {
            $data[$estadoId]['municipios'][$municipioId]['parroquias'][] = array(
                'id' => $row['id_parroquia'],
                'nombre' => $row['parroquia']
            );
        }
    }

    // Convertir los arrays asociativos de municipios a arrays indexados
    foreach ($data as &$estado) {
        $estado['municipios'] = array_values($estado['municipios']);
    }

    // Convertir el array asociativo principal a array indexado
    $data = array_values($data);

    // Enviar la respuesta
    echo json_encode(array(
        'status' => 'success',
        'data' => $data
    ));

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array(
        'status' => 'error',
        'message' => $e->getMessage()
    ));
}
