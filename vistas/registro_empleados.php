<?php include "includes/header.php"; ?>

    <hr>
    <h2 style="background-color: lightgray; padding: 10px">Registro de nuevo empleado</h2>
    <hr>
    <h4>Ingrese todos los datos personales necesarios para realizar el registro de un nuevo empleado</h4>
    
    <form action="index.php?page=registro_empleados" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <label for="cedula">Cedula:</label>
        <input type="text" id="cedula" name="cedula" required><br><br>

        <label for="email">Correo electronico:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Contraseña para el empleado:</label>
        <input type="text" id="password" name="password" required><br><br>

        <label for="fecha_ingreso">Fecha de ingreso:</label>
        <input type="date" id="fecha_ingreso" name="fecha_ingreso" required><br><br>

        <input type="submit" name="siguiente" value="Siguiente"><br><br>
        <button type="button" onclick="window.location.href='index.php?page=inicio'">Cancelar registro</button>
    </form>

    <?php

        include 'backend/db.php';

        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['siguiente'])) {    
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $cedula = $_POST["cedula"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $fecha_ingreso = $_POST["fecha_ingreso"];

            $sql = "INSERT INTO usuarios (nombre, apellido, cedula, email, password, fecha_ingreso) VALUES ('$nombre', '$apellido', '$cedula', '$email', '$password', '$fecha_ingreso')";

            $result = $conn->query($sql);

            $_SESSION['usuario_id'] = mysqli_insert_id($conn);

            if($result) {   
                echo "<br><h5>Registrando informacion... continue con el registro la direccion del nuevo empleado</h5>";
                header("refresh:2; url=index.php?page=registro_direccion");
            } else {
                echo "Error al registrar al nuevo empleado";
            }
        
        }
    ?>


<?php include "includes/footer.php"; ?>