<?php
include 'db.php';

// Si no hay una sesion iniciada, redirigir al inicio
session_start();
if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Datos del usuario
    $id = $_POST["id"]; // ID del usuario a editar
    $tipo_usuario = $_POST["tipo_usuario"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cedula = $_POST["cedula"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
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

    // Si el formato de correo es incorrecto redireccionar al formulario
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Formato de correo no permitido.";
        header("location: ../index.php?page=panel_rrhh");
        exit();
    }

    // Si el dominio de correo es incorrecto redireccionar al formulario
    if (!in_array($dominio, $dominios_validos)) {
        $_SESSION['error'] = "Dominio de correo no permitido.";
        header("location: ../index.php?page=panel_rrhh");
        exit();
    }

    // Verificar si el correo ya existe (excluyendo el usuario actual)
    $stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE email = ? AND id != ?");
    mysqli_stmt_bind_param($stmt, "si", $email, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "El correo ya está registrado";
        header("Location: ../index.php?page=panel_rrhh");
        exit();
    }

    // Verificar si la cédula ya existe (excluyendo el usuario actual)
    $stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE cedula = ? AND id != ?");
    mysqli_stmt_bind_param($stmt, "si", $cedula, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "La cédula ya está registrada";
        header("Location: ../index.php?page=panel_rrhh");
        exit();
    }

    // Iniciar transacción
    mysqli_begin_transaction($conn);

    try {
        // Actualizar datos del usuario
        $stmt = mysqli_prepare($conn, "UPDATE usuarios SET 
            tipo_usuario = ?, 
            nombre = ?, 
            apellido = ?, 
            cedula = ?, 
            email = ?, 
            telefono = ?, 
            fecha_ingreso = ? 
            WHERE id = ?");
        
        mysqli_stmt_bind_param($stmt, "sssssssi", 
            $tipo_usuario, 
            $nombre, 
            $apellido, 
            $cedula, 
            $email, 
            $telefono, 
            $fecha_ingreso, 
            $id
        );
        $resultado = mysqli_stmt_execute($stmt);

        if (!$resultado) {
            throw new Exception("Error al actualizar el usuario");
        }

        // Actualizar dirección
        $stmt = mysqli_prepare($conn, "UPDATE direccion SET 
            estado = ?, 
            municipio = ?, 
            parroquia = ?, 
            calle = ?, 
            zip = ?, 
            vivienda = ? 
            WHERE usuario_id = ?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $estado, $municipio, $parroquia, $calle, $zip, $vivienda, $id);
        $resultado = mysqli_stmt_execute($stmt);

        if (!$resultado) {
            throw new Exception("Error al actualizar la dirección");
        }

        // Actualizar cargo
        $stmt = mysqli_prepare($conn, "UPDATE cargos SET 
            cargo = ?, 
            area = ?, 
            salario_base = ? 
            WHERE usuario_id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $cargo, $area, $salario_base, $id);
        $resultado = mysqli_stmt_execute($stmt);

        if (!$resultado) {
            throw new Exception("Error al actualizar el cargo");
        }

        // Si todo salió bien, confirmar los cambios
        mysqli_commit($conn);

        // Redireccionar al panel_rrhh con un mensaje de éxito
        $_SESSION['mensaje'] = "Usuario actualizado exitosamente";
        unset($_SESSION['datos_form']);
        exit();

    } catch (Exception $e) {
        // Si algo salió mal, revertir los cambios
        mysqli_rollback($conn);
        $_SESSION['error'] = "Error al actualizar: " . $e->getMessage();
        header("location: ../index.php?page=panel_rrhh");
        exit();
    }
}
