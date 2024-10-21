<?php include "includes/header.php"; ?>

<hr>
<h2 style="background-color: lightgray; padding: 10px">Registro de nuevo empleado</h2>
<hr>
<h4>Ingrese todos los datos personales necesarios para realizar el registro de un nuevo empleado</h4>

<form action="index.php?page=registrar" method="post">
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

    <label for="cargo">Cargo:</label>
    <input type="text" id="cargo" name="cargo"
        required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
        title="El cargo no puede estar vacio o en blanco"><br><br>

    <label for="area">Area de trabajo:</label>
    <input type="text" id="area" name="area"
        required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
        title="El area de trabajo no puede estar vacio o en blanco"><br><br>

    <label for="salario_base">Salario base:</label>
    <input type="text" id="salario_base" name="salario_base"
        required pattern="\d+" maxlength="6"
        title="El salario base debe contener solo numeros, sin puntos y sin espacios en blanco"><br><br>

    <input type="submit" name="registrar" value="Registrar empleado"><br><br>
    <button type="button" onclick="window.location.href='index.php?page=panel_rrhh'">Cancelar registro</button>
</form>

<?php include "includes/footer.php"; ?>