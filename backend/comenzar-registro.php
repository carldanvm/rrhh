<?php
// Incluir el archivo de configuración de la base de datos
include 'db.php';

// Establecer el tipo de contenido de la respuesta como JSON
header("Content-Type: application/json");

// Hacer la zona horaria
date_default_timezone_set('America/Caracas');

// Verificar que se recibieron los datos necesarios (cedula y password)
if (isset($_POST["cedula"]) && isset($_POST["password"])) {
    // Asignar los valores recibidos a variables
    $cedula = $_POST["cedula"];
    $password = $_POST["password"];

    // Buscar el usuario en la base de datos por cédula
    $sql = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
    $result = $conn->query($sql);

    // Si se encontró un usuario con esa cédula
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario y guardar su ID para uso posterior
        $fila = $result->fetch_assoc();
        $usuario_id = $fila['id'];

        // Verificar si la contraseña proporcionada coincide con la almacenada
        if ($password == $fila["password"]) {
            // Preparar el array de respuesta con los datos básicos del usuario
            $respuesta = array(
                "id" => $fila["id"], // Agregar el ID del usuario a la respuesta
                "nombre" => $fila["nombre"],
                "apellido" => $fila["apellido"]
            );

            // Buscar el último registro de asistencia del usuario
            $sql = "SELECT * FROM registros WHERE usuario_id = ? ORDER BY id DESC LIMIT 1";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $usuario_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // DETERMINACIÓN DEL TIPO DE REGISTRO (ENTRADA O SALIDA)
            
            // Caso 1: Si no hay registros previos, es una entrada
            if ($result->num_rows == 0) {
                $respuesta["registro"] = "entrada";
            }
            // Caso 2: Si hay registros previos, verificar el último
            else if ($fila = $result->fetch_assoc()) {
                // Si el último registro no tiene salida, entonces es una salida
                if (is_null($fila["salida"])) {
                    $respuesta["registro"] = "salida";
                    $respuesta["hora_entrada"] = $fila["entrada"];
                } 
                // Si el último registro ya tiene salida, entonces es una nueva entrada
                else {
                    $respuesta["registro"] = "entrada";
                }
            }

            // PROCESAMIENTO DE ENTRADA
            if ($respuesta["registro"] == "entrada") {
                // Insertar nuevo registro con la hora de entrada
                $sql = "INSERT INTO registros (usuario_id, entrada) VALUES (?, CURRENT_TIMESTAMP)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $usuario_id);
                mysqli_stmt_execute($stmt);

                echo json_encode($respuesta);
                exit();
            }

            // PROCESAMIENTO DE SALIDA
            if ($respuesta["registro"] == "salida") {
                // Obtener la hora de entrada del registro actual para calcular las horas trabajadas
                $sql = "SELECT entrada FROM registros WHERE usuario_id = ? ORDER BY id DESC LIMIT 1";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $usuario_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $registro = $result->fetch_assoc();
                
                // Calcular el total de horas trabajadas
                $entrada = new DateTime($registro['entrada']);
                $salida = new DateTime();
                $interval = $entrada->diff($salida);
                
                // Calcular las horas trabajadas considerando todos los componentes de tiempo
                $total_minutos = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i + ($interval->s / 60);
                $horas_trabajadas = $total_minutos / 60;
                
                // Redondear a 2 decimales para mejor precisión
                $horas_trabajadas = round($horas_trabajadas, 3);
                
                // Actualizar el registro con la hora de salida y las horas trabajadas
                // Solo actualiza el registro más reciente que no tenga hora de salida
                $sql = "UPDATE registros SET salida = CURRENT_TIMESTAMP, horas_trabajadas = ? WHERE usuario_id = ? AND salida IS NULL ORDER BY id DESC LIMIT 1";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "di", $horas_trabajadas, $usuario_id);
                mysqli_stmt_execute($stmt);

                echo json_encode($respuesta);
                exit();
            }

        } else {
            // Error: Contraseña incorrecta
            http_response_code(401);
            $respuesta = array("error" => "La contrasena es incorrecta", "status" => "401");
            echo json_encode($respuesta);
            exit();
        }
    } else {
        // Error: Usuario no encontrado
        http_response_code(404);
        $respuesta = array("error" => "La cedula no existe", "status" => "404");
        echo json_encode($respuesta);
        exit();
    }
}
