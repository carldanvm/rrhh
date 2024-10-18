<?php
        session_start();    
        
        include 'probar-bd.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['siguiente'])) {
            $_SESSION["estado"] = $_POST["estado"];
            $_SESSION["municipio"] = $_POST["municipio"];
            $_SESSION["ciudad"] = $_POST["ciudad"];
            $_SESSION["calle"] = $_POST["calle"];
            $_SESSION["zip"] = $_POST["zip"];
            $_SESSION["vivienda"] = $_POST["vivienda"];
        }
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro empleados</title>
</head>

<body>
    <h1 style="background-color: lightblue; padding: 20px">Registro de nuevo empleado</h1>
    <h4>Ingrese toda la informacion del cargo del nuevo empleado</h4>
    
    <form action="registro_cargos.php" method="post">
        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo" required><br><br>

        <label for="area">Area de trabajo:</label>
        <input type="text" id="area" name="area" required><br><br>

        <label for="salario_base">Salario base:</label>
        <input type="text" id="salario_base" name="salario_base" required><br><br>

        <input type="submit" name="registrar" value="Registrar usuario"><br><br>
        <button type="button" onclick="window.location.href='/rrhh/vistas/inicio.php';">Cancelar</button>
    </form>

    <?php
        include 'probar-bd.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
            $estado = $_SESSION["estado"];
            $municipio = $_SESSION["municipio"];
            $ciudad = $_SESSION["ciudad"];
            $calle = $_SESSION["calle"];
            $zip = $_SESSION["zip"];
            $vivienda = $_SESSION["vivienda"];

            $cargo = $_POST["cargo"];
            $area = $_POST["area"];
            $salario_base = $_POST["salario_base"];

            $usuario_id = $_SESSION['usuario_id'];

            $sql = "INSERT INTO direccion (usuario_id, estado, municipio, ciudad, calle, zip, vivienda) VALUES ('$usuario_id', '$estado', '$municipio', '$ciudad', '$calle', '$zip', '$vivienda')";
            mysqli_query($conn, $sql);

            $sql = "INSERT INTO cargos (usuario_id, cargo, area, salario_base) VALUES ('$usuario_id', '$cargo', '$area', '$salario_base')";
            

            if (mysqli_query($conn, $sql)) {    //Esto es para verificar que se guardo todo bien
                echo "<h3>Datos guardados correctamente</h3>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            
            mysqli_close($conn);
            session_destroy();
        }

    ?>

    
</body>
</html>