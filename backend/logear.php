<?php 
    include 'backend/db.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cedula']) && isset($_POST['password'])) {
        $cedula = $_POST['cedula'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM usuarios WHERE cedula = '$cedula' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        // Revisar si el usuario existe para redirecionar al panel de RRHH
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['logeado_id'] = $row['id'];
            $_SESSION['logeado_nombre'] = $row['nombre'];
            $_SESSION['logeado_apellido'] = $row['apellido'];
            $_SESSION['logeado_cedula'] = $row['cedula'];
            $_SESSION['logeado_email'] = $row['email'];

            header("location: index.php?page=panel_rrhh");
            exit();
        }else{
            header("location: index.php?page=login");
            exit();
        }
    }
?>