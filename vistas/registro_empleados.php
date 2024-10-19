<?php include "includes/header.php"; ?>

    <hr>
    <h2 style="background-color: lightgray; padding: 10px">Registro de nuevo empleado</h2>
    <hr>
    <h4>Ingrese todos los datos personales necesarios para realizar el registro de un nuevo empleado</h4>
    
    <form action="index.php?page=registro_empleados" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" 
        required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$" 
        title="El nombre solo puede contener letras y no puede estar vacio o en blanco"
        value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>"><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" 
        required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$" 
        title="El apellido solo puede contener letras y no puede estar vacio o en blanco"
        value="<?php echo isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : ''; ?>"><br><br>

        <label for="cedula">Cedula:</label>
        <input type="text" id="cedula" name="cedula" 
        required pattern="\d+" maxlength="8" 
        title="La cedula debe contener solo numeros, sin puntos y sin espacios en blanco"
        value="<?php echo isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : ''; ?>"><br><br>

        <label for="email">Correo electronico:</label>
        <input type="email" id="email" name="email" 
        required pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|hotmail\.com)$" 
        title="Solo se permiten correos de Gmail, Outlook o Hotmail"><br><br>

        <label for="password">Contraseña para el empleado:</label>
        <input type="text" id="password" name="password" required
        value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"><br><br>

        <label for="fecha_ingreso">Fecha de ingreso:</label>
        <input type="date" id="fecha_ingreso" name="fecha_ingreso" required
        value="<?php echo isset($_POST['fecha_ingreso']) ? htmlspecialchars($_POST['fecha_ingreso']) : ''; ?>"><br><br>

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

            $dominios_validos = ['gmail.com', 'outlook.com', 'hotmail.com'];

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $dominio = substr(strrchr($email, "@"), 1);
                if (in_array($dominio, $dominios_validos)) {
                    // si el correo es valido se guardan los datos en la base de datos
                    $sql = "INSERT INTO usuarios (nombre, apellido, cedula, email, password, fecha_ingreso) VALUES ('$nombre', '$apellido', '$cedula', '$email', '$password', '$fecha_ingreso')";
                    $result = $conn->query($sql);

                    if($result) {   
                        echo "<br><h5>Registrando informacion... continue con el registro la direccion del nuevo empleado</h5>";
                        header("refresh:2; url=index.php?page=registro_direccion");
                    } else {
                        echo "Error al registrar al nuevo empleado";
                    }

                } else {
                    echo "<br><b>El dominio del correo no esta permitido</b>";
                    //header("refresh:3; url=index.php?page=registro_empleados");
                }

            } else {
                echo "<br><b>Formato de correo invalido! Solo se permiten correos con dominio de Gmail, Outlook o Hotmail</b>";
                //header("refresh:3; url=index.php?page=registro_empleados");
            }
            
            $_SESSION['usuario_id'] = mysqli_insert_id($conn);
        }
    ?>


<?php include "includes/footer.php"; ?>