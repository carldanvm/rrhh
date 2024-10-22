<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cedula = $_POST["cedula"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $fecha_ingreso = $_POST["fecha_ingreso"];
    // Datos de la direccion
    $estado = $_POST["estado"];
    $municipio = $_POST["municipio"];
    $ciudad = $_POST["ciudad"];
    $calle = $_POST["calle"];
    $zip = $_POST["zip"];
    $vivienda = $_POST["vivienda"];
    // Datos del cargo
    $cargo = $_POST["cargo"];
    $area = $_POST["area"];
    $salario_base = $_POST["salario_base"];

    $dominios_validos = ['gmail.com', 'outlook.com', 'hotmail.com'];

    // verificamos el dominio del correo
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $dominio = substr(strrchr($email, "@"), 1);

        if (in_array($dominio, $dominios_validos)) {

            //si el correo es valido, verificamos si la cedula existe en la BD
            $sql = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "Ya existe un usuario con esa cedula. Por favor, ingresa otra cedula.";
                header("refresh: 3; location: index.php?page=registro_empleados");
                exit();
            } else {

                // Guarda el nuevo usuario en la base de datos
                $sql = "INSERT INTO usuarios (nombre, apellido, cedula, email, password, fecha_ingreso) VALUES ('$nombre', '$apellido', '$cedula', '$email', '$password', '$fecha_ingreso')";

                $resultado = mysqli_query($conn, $sql);

                if (!$resultado){
                    echo mysqli_error($conn) . "<br>". "<br>" ;
                    exit('Error al registrar el usuario');
                }


                // Obtiene el ID del nuevo usuario
                $id = mysqli_insert_id($conn);


                // Guarda la nueva direccion en la base de datos
                $sql = "INSERT INTO direccion (usuario_id, estado, municipio, ciudad, calle, zip, vivienda) VALUES ('$id', '$estado', '$municipio', '$ciudad', '$calle', '$zip', '$vivienda')";

                $resultado = mysqli_query($conn, $sql);

                if (!$resultado){
                    echo mysqli_error($conn) . "<br>". "<br>";
                    exit('Error al registrar la direccion');
                }


                // Guarda la informacion del cargo en la base de datos
                $sql = "INSERT INTO cargos (usuario_id, cargo, area, salario_base) VALUES ('$id', '$cargo', '$area', '$salario_base')";

                $resultado = mysqli_query($conn, $sql);

                if (!$resultado){
                    echo mysqli_error($conn) . "<br>". "<br>";
                    exit('Error al registrar el cargo');
                }

                // Redireccionar al panel_rrhh
                $_SESSION['mensaje'] = "Usuario registrado exitosamente";
                header("location: index.php?page=panel_rrhh");
            } 

        } else {
            echo "El dominio del correo no está permitido.";
            header("location: index.php?page=registro_empleados");
        }

    } else {
        echo "Formato de correo inválido.";
        header("location: index.php?page=registro_empleados");
    }

}

?>