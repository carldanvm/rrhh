<?php 
    include 'backend/db.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cedula']) && isset($_POST['password'])) {
        $cedula = $_POST['cedula'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM usuarios WHERE cedula = $cedula";
        $result = mysqli_query($conn, $sql);
        $fila = mysqli_fetch_assoc($result);

        // Revisar si el usuario es de RRHH
        if ($fila['tipo_usuario'] != 'rrhh') {
            $_SESSION['error'] = "Empleado $fila[nombre] $fila[apellido], usted NO es de RRHH";
            header("location: index.php?page=login");
            exit();
        }

        // Revisar si la cedula existe
        if (mysqli_num_rows($result) == 0) {
            $_SESSION['error'] = "La cedula no esta registrada";
            header("location: index.php?page=login");
            exit();
        }

        if ($fila['password'] != $password) {
            $_SESSION['error'] = "La contraseña es incorrecta";
            header("location: index.php?page=login");
            exit();
        }

        if ($fila['password'] == $password && $fila['tipo_usuario'] === 'rrhh') {
            
            $_SESSION['logeado_id'] = $fila['id'];
            $_SESSION['logeado_nombre'] = $fila['nombre'];
            $_SESSION['logeado_apellido'] = $fila['apellido'];
            $_SESSION['logeado_cedula'] = $fila['cedula'];
            $_SESSION['logeado_email'] = $fila['email'];

            header("location: index.php?page=panel_rrhh");
            exit();
        }

    }
?>