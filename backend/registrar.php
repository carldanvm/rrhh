<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Datos del usuario
    $tipo_usuario = $_POST["tipo_usuario"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cedula = $_POST["cedula"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $password = $_POST["password"];
    $fecha_ingreso = $_POST["fecha_ingreso"];

    // Datos de la direccion
    $estado = $_POST["estado"];
    $municipio = $_POST["municipio"];
    $parroquia = $_POST["parroquia"];
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
    $dominio = substr(strrchr($email, "@"), 1);

    // Si el formato de correo es incorrecto redireccionar al formulario de registro
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Formato de correo no permitido.";
        header("location: index.php?page=registro_empleados");
        exit();
    }

    // Si el dominio de correo es incorrecto redireccionar al formulario de registro
    if (!in_array($dominio, $dominios_validos)) {
        $_SESSION['error'] = "Dominio de correo no permitido.";
        header("location: index.php?page=registro_empleados");
        exit();
    }

    //Verificamos si ya existe un usuario con esa cedula o con ese email
    $sql = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
    $resultCedula = mysqli_query($conn, $sql);

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultEmail = mysqli_query($conn, $sql);

    // Si ya existe un usuario con esa cedula o con ese email redireccionar al formulario de registro
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
    $sql = "INSERT INTO usuarios (tipo_usuario, nombre, apellido, cedula, email, telefono, password, fecha_ingreso) VALUES ('$tipo_usuario', '$nombre', '$apellido', '$cedula', '$email', '$telefono', '$password', '$fecha_ingreso')";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        $_SESSION['error'] = "Error al registrar el usuario en la base de datos";
        header("location: index.php?page=registro_empleados");
        exit();
    }

    // Obtiene el ID del nuevo usuario
    $id = mysqli_insert_id($conn);



    // Guarda la nueva direccion en la base de datos
    $sql = "INSERT INTO direccion (usuario_id, estado, municipio,parroquia , calle, zip, vivienda) VALUES ('$id', '$estado', '$municipio', '$parroquia', '$calle', '$zip', '$vivienda')";
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
}
