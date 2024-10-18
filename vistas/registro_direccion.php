<!DOCTYPE html>
<html>
<head>
    <title>Registro empleados</title>
</head>

<body>
    <h1 style="background-color: lightblue; padding: 20px">Registro de nuevo empleado</h1>
    <h4>Ingrese todos los datos de direccion del nuevo empleado</h4>
    
    <form action="registro_cargos.php" method="post">
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado" required><br><br>

        <label for="municipio">Municipio:</label>    
        <input type="text" id="municipio" name="municipio" required><br><br>

        <label for="ciudad">Ciudad:</label>
        <input type="text" id="ciudad" name="ciudad" required><br><br>
        
        <label for="calle">Calle:</label>
        <input type="text" id="calle" name="calle" required><br><br>

        <label for="zip">Codigo postal:</label>
        <input type="text" id="zip" name="zip" required><br><br>

        <label for="vivienda">Referencia de la vivienda:</label>
        <input type="text" id="vivienda" name="vivienda" required><br><br>

        <input type="submit" name="siguiente" value="Siguiente"><br><br>
        <button type="button" onclick="window.location.href='/rrhh/vistas/inicio.php';">Cancelar</button>
    </form>

    
</body>
</html>