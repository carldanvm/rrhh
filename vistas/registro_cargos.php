<?php
include 'includes/header.php';

include 'backend/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['siguiente'])) {
    $_SESSION["estado"] = $_POST["estado"];
    $_SESSION["municipio"] = $_POST["municipio"];
    $_SESSION["ciudad"] = $_POST["ciudad"];
    $_SESSION["calle"] = $_POST["calle"];
    $_SESSION["zip"] = $_POST["zip"];
    $_SESSION["vivienda"] = $_POST["vivienda"];
}
?>

<h1>Registro de nuevo empleado</h1>
<hr>
<h4>Ingrese toda la informacion del cargo del nuevo empleado</h4>

<form action="index.php?page=registro_cargos" method="post">
    <label for="cargo">Cargo:</label>
    <input type="text" id="cargo" name="cargo" required><br><br>

    <label for="area">Area de trabajo:</label>
    <input type="text" id="area" name="area" required><br><br>

    <label for="salario_base">Salario base:</label>
    <input type="text" id="salario_base" name="salario_base" required><br><br>

    <input type="submit" name="registrar" value="Registrar usuario"><br><br>
    <button type="button" onclick="window.location.href='index.php?page=inicio'">Cancelar</button>
</form>

<?php

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
        header("refresh:2; url=index.php?page=panel_rrhh");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    unset($_SESSION["estado"]);
    unset($_SESSION["municipio"]);
    unset($_SESSION["ciudad"]);
    unset($_SESSION["calle"]);
    unset($_SESSION["zip"]);
    unset($_SESSION["vivienda"]);
    unset($_SESSION['usuario_id']);

}

?>

<?php include 'includes/footer.php'; ?>