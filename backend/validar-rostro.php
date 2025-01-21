<?php
    session_start();
    header("Content-Type: application/json");
    include 'db.php';

    // Verificar si se recibieron los descriptores
    $descriptores = isset($_POST['descriptores']) ? $_POST['descriptores'] : null;

    if (empty($descriptores) || !is_array($descriptores)) {
        http_response_code(400);
        echo json_encode(["error" => "No se proporcionaron descriptores válidos"]);
        exit;
    }

    // Calcula que tan diferentes son dos rostros
    function calcularDistanciaEuclidiana($rostro1, $rostro2) {
        // Si alguno no es array, no podemos comparar
        if (!is_array($rostro1) || !is_array($rostro2)) {
            return false;
        }
        
        // Asegurarnos que tienen el mismo tamaño
        if (count($rostro1) != count($rostro2)) {
            return false;
        }
        
        $diferencia_total = 0;
        
        // Por cada característica del rostro
        for ($i = 0; $i < count($rostro1); $i++) {
            // Calcular diferencia entre características
            $diferencia = $rostro1[$i] - $rostro2[$i];
            // Sumar al total (elevamos al cuadrado para que no haya negativos)
            $diferencia_total = $diferencia_total + ($diferencia * $diferencia);
        }
        
        // Sacar la raíz cuadrada para tener la distancia final
        return sqrt($diferencia_total);
    }

    function entradaOsalida($usuarioId) {
        global $conn;
        $sql = "SELECT * FROM registros WHERE usuario_id = '$usuarioId' ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $fila = mysqli_fetch_assoc($result);
        
        //Si no hay registros, es una entrada
        if ($result->num_rows == 0) {
            return "entrada";
        }

        //Si el registro no tiene salida, es una salida
        if ($fila['salida'] == null) {
            return "salida";
        }

        //Si el registro tiene salida, es una entrada
        return "entrada";
    }

    // Obtener los descriptores faciales de la base de datos
    $sql = "SELECT id, cara, nombre, apellido FROM usuarios WHERE cara IS NOT NULL AND cara != ''";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Error al consultar la base de datos"]);
        exit;
    }

    $usuarioEncontrado = false;
    $usuarioId = null;
    $usuarioNombre = null;
    $usuarioApellido = null;

    // Por cada descriptor en la base de datos
    while ($row = mysqli_fetch_assoc($result)) {
        $descriptorDB = json_decode($row['cara'], true);
        if ($descriptorDB === null || empty($descriptorDB)) {
            continue;
        }

        // Comparar con cada descriptor proporcionado
        foreach ($descriptores as $descriptor) {
            $distancia = calcularDistanciaEuclidiana($descriptor, $descriptorDB);
            if ($distancia !== false && $distancia < 0.6) {
                $usuarioEncontrado = true;
                $usuarioId = $row['id'];
                $usuarioNombre = $row['nombre'];
                $usuarioApellido = $row['apellido'];
                break 2; // Salir de ambos bucles
            }
        }
    }

    if ($usuarioEncontrado) {
        echo json_encode([
            "success" => true,
            "usuario_id" => $usuarioId,
            "usuario_nombre" => $usuarioNombre,
            "usuario_apellido" => $usuarioApellido,
            "tipo_registro" => entradaOsalida($usuarioId)
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "No se encontró coincidencia"
        ]);
    }