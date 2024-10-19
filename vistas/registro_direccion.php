<?php include "includes/header.php"; ?>

<hr>
<h2 style="background-color: lightgray; padding: 10px">Registro de nuevo empleado</h2>
<hr>
<h4>Ingrese todos los datos de direccion del nuevo empleado</h4>

<form action="index.php?page=registro_cargos" method="post">
    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado" 
    required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$" 
    title="El estado solo puede contener letras y no puede estar vacio o en blanco"><br><br>

    <label for="municipio">Municipio:</label>
    <input type="text" id="municipio" name="municipio"
    required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$" 
    title="El municipio solo puede contener letras y no puede estar vacio o en blanco"><br><br>

    <label for="ciudad">Ciudad:</label>
    <input type="text" id="ciudad" name="ciudad" 
    required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$" 
    title="La ciudad solo puede contener letras y no puede estar vacio o en blanco"><br><br>

    <label for="calle">Calle:</label>
    <input type="text" id="calle" name="calle"
    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$" 
    title="La calle no puede estar vacio o en blanco"><br><br>

    <label for="zip">Codigo postal:</label>
    <input type="text" id="zip" name="zip"
    required pattern="\d+" maxlength="5" 
    title="El codigo postal debe contener solo numeros, sin puntos y sin espacios en blanco"><br><br>

    <label for="vivienda">Referencia de la vivienda:</label>
    <input type="text" id="vivienda" name="vivienda" 
    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$" 
    title="La referencia no puede estar vacio o en blanco"><br><br>

    <input type="submit" name="siguiente" value="Siguiente"><br><br>
    <button type="button" onclick="window.location.href='index.php?page=inicio';">Cancelar registro</button>
</form>


<?php include 'includes/footer.php'; ?>