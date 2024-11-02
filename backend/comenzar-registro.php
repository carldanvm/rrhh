<?php
header("Content-Type: application/json");

include 'db.php';
session_start();

if (isset($_POST["cedula"]) && isset($_POST["password"])) {


    $cedula = $_POST["cedula"];
    $password = $_POST["password"];

    // Verificar si la cedula existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
    $result = $conn->query($sql);

    // Si la cedula existe, verificar si la contraseña es correcta
    if ($result->num_rows > 0) {
        
        // Verificar si la contraseña es correcta
        $fila = $result->fetch_assoc();
        if ($password == $fila["password"]) {

            // Si la cedula y la contraseña son correctas, guardar nombre, apellido e id en la respuesta
            $respuesta = array(
                "id" => $fila["id"],
                "nombre" => $fila["nombre"],
                "apellido" => $fila["apellido"]
            );


            // Verificar si es una entrada o una salida
            $sql = "SELECT * FROM registros WHERE usuario_id = '$fila[id]' ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);
            $fila = $result->fetch_assoc();

            // Si no hay registros, es una entrada
            if ($result->num_rows == 0) {
                $respuesta["registro"] = "entrada";

                echo json_encode($respuesta);
                exit();
            }

            // Si el registro no tiene salida, entonces es una salida
            if ($fila["salida"] == null) {
                $respuesta["registro"] = "salida";
                $respuesta["hora_entrada"] = $fila["entrada"];

                echo json_encode($respuesta);
                exit();

            }else{
                // Si el registro tiene salida, entonces es una entrada
                $respuesta["registro"] = "entrada";

                echo json_encode($respuesta);
                exit();
            }

        }else{
            // La contraseña es incorrecta retornar un error
            http_response_code(401);
            $respuesta = array("error" => "La contrasena es incorrecta", "status" => "401");
            echo json_encode($respuesta);
            exit();
        }


    } else {
        // La cedula no existe retornar un error
        http_response_code(404);
        $respuesta = array("error" => "La cedula no esta registrada", "status" => "404");
        echo json_encode($respuesta);
        exit();
    }   
    
}
