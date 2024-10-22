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

    // Guardar todos los datos del post en una variable de sesion
    $_SESSION['datos_form'] = $_POST;

    $dominios_validos = ['gmail.com', 'outlook.com', 'hotmail.com'];

    // verificamos el dominio del correo
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $dominio = substr(strrchr($email, "@"), 1);

        if (in_array($dominio, $dominios_validos)) {

            //Verificamos si ya existe un usuario con esa cedula o con ese email
            $sql = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
            $resultCedula = mysqli_query($conn, $sql);

            $sql = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultEmail = mysqli_query($conn, $sql);

            if (mysqli_num_rows($resultCedula) > 0) {
                $_SESSION['error'] = "Ya existe un usuario con esa cedula.";
                header("location: index.php?page=registro_empleados");
                exit();
            }

            if (mysqli_num_rows($resultEmail) > 0) {
                $_SESSION['error'] = "Ya existe un usuario con ese email.";
                header("location: index.php?page=registro_empleados");
                exit();
            }

            // Guarda el nuevo usuario en la base de datos
            $sql = "INSERT INTO usuarios (nombre, apellido, cedula, email, password, fecha_ingreso) VALUES ('$nombre', '$apellido', '$cedula', '$email', '$password', '$fecha_ingreso')";

            $resultado = mysqli_query($conn, $sql);

            if (!$resultado) {
                $_SESSION['error'] = "Error al registrar el usuario en la base de datos";
                header("location: index.php?page=registro_empleados");
                exit();
            }


            // Obtiene el ID del nuevo usuario
            $id = mysqli_insert_id($conn);


            // Guarda la nueva direccion en la base de datos
            $sql = "INSERT INTO direccion (usuario_id, estado, municipio, ciudad, calle, zip, vivienda) VALUES ('$id', '$estado', '$municipio', '$ciudad', '$calle', '$zip', '$vivienda')";

            $resultado = mysqli_query($conn, $sql);

            if (!$resultado) {
                $_SESSION['error'] = "Error al registrar la nueva direccion en la base de datos";
                header("location: index.php?page=registro_empleados");
                exit();
            }


            // Guarda la informacion del cargo en la base de datos
            $sql = "INSERT INTO cargos (usuario_id, cargo, area, salario_base) VALUES ('$id', '$cargo', '$area', '$salario_base')";

            $resultado = mysqli_query($conn, $sql);

            if (!$resultado) {
                $_SESSION['error'] = "Error al registrar la informacion del cargo en la base de datos";
                header("location: index.php?page=registro_empleados");
                exit();
            }

            // Redireccionar al panel_rrhh con un mensaje de exito y vaciar la variable de sesion datos_form
            $_SESSION['mensaje'] = "Usuario registrado exitosamente";
            unset($_SESSION['datos_form']);
            header("location: index.php?page=panel_rrhh");

        } else {
            $_SESSION['error'] = "Dominio de correo no permitido.";
            header("location: index.php?page=registro_empleados");
            exit();
        }
    } else {
        $_SESSION['error'] = "Formato de correo no permitido.";
        header("location: index.php?page=registro_empleados");
        exit();
    }
}
