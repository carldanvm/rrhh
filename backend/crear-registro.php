<?php 
    header("Content-Type: application/json");
    include 'db.php';

    date_default_timezone_set('America/Caracas');

    if (isset($_POST["tipo_registro"]) && isset($_POST["usuario_id"]) ) {

        $tipo_registro = $_POST["tipo_registro"];
        $usuario_id = $_POST["usuario_id"];

        if ($tipo_registro == 'entrada') {
            // Crear un nuevo registro con la entrada
            $sql = "INSERT INTO registros (usuario_id, entrada) VALUES ($usuario_id, CURRENT_TIMESTAMP)";
            $result = mysqli_query($conn, $sql);

            $respuesta = array('mensaje' => 'Entrada registrada exitosamente', 'fecha' => date('Y-m-d H:i:s'));
            echo json_encode($respuesta);
            exit();
        }

        if ($tipo_registro == 'salida') {
            // Obtener el id del registro mas reciente cuya salida deberia ser null
            $sql = "SELECT id FROM registros WHERE usuario_id = $usuario_id ORDER BY id DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $fila = mysqli_fetch_assoc($result);
            $registro_id = $fila['id'];

            // Actualizar el registro con la salida
            $sql = "UPDATE registros SET salida = CURRENT_TIMESTAMP WHERE id = $registro_id";
            $result = mysqli_query($conn, $sql);

            // Calcular horas trabajadas
            $sql = "SELECT entrada, salida FROM registros WHERE usuario_id = $usuario_id AND id = $registro_id";
            $result = mysqli_query($conn, $sql);
            $fila = mysqli_fetch_assoc($result);
            $entrada = $fila['entrada'];
            $salida = $fila['salida'];
            $horas_trabajadas = strtotime($salida) - strtotime($entrada);
            $horas_trabajadas = $horas_trabajadas / 3600;

            // Actualizar el registro con las horas trabajadas
            $sql = "UPDATE registros SET horas_trabajadas = $horas_trabajadas WHERE id = $registro_id";
            $result = mysqli_query($conn, $sql);

            $respuesta = array('mensaje' => 'Salida registrada exitosamente', 'fecha' => date('Y-m-d H:i:s'), 'horas_trabajadas' => $horas_trabajadas);
            echo json_encode($respuesta);
            exit();
            
        }

        
    }else{
        http_response_code(400);
        echo json_encode(["error" => "No se proporcionaron datos"]);
        exit();
    }


?>