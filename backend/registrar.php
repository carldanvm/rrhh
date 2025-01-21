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
    $descriptor_facial = $_POST["descriptor_facial"];

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

    // Verificar si el correo ya existe
    $stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "El correo ya está registrado";
        header("Location: index.php?page=registro_empleados");
        exit();
    }

    // Verificar si la cédula ya existe
    $stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE cedula = ?");
    mysqli_stmt_bind_param($stmt, "s", $cedula);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "La cédula ya está registrada";
        header("Location: index.php?page=registro_empleados");
        exit();
    }

    // Guarda el nuevo usuario en la base de datos
    $stmt = mysqli_prepare($conn, "INSERT INTO usuarios (tipo_usuario, nombre, apellido, cedula, email, telefono, password, cara, fecha_ingreso) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssssss", $tipo_usuario, $nombre, $apellido, $cedula, $email, $telefono, $password, $descriptor_facial, $fecha_ingreso);
    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        $_SESSION['error'] = "Error al registrar el usuario en la base de datos";
        header("location: index.php?page=registro_empleados");
        exit();
    }

    // Obtiene el ID del nuevo usuario
    $id = mysqli_insert_id($conn);

    // Guarda la nueva direccion en la base de datos
    $stmt = mysqli_prepare($conn, "INSERT INTO direccion (usuario_id, estado, municipio, parroquia, calle, zip, vivienda) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issssss", $id, $estado, $municipio, $parroquia, $calle, $zip, $vivienda);
    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        $_SESSION['error'] = "Error al registrar la nueva direccion en la base de datos";
        header("location: index.php?page=registro_empleados");
        exit();
    }

    // Guarda la informacion del cargo en la base de datos
    $stmt = mysqli_prepare($conn, "INSERT INTO cargos (usuario_id, cargo, area, salario_base) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isss", $id, $cargo, $area, $salario_base);
    $resultado = mysqli_stmt_execute($stmt);

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
