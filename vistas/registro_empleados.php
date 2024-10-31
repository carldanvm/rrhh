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
        value="<?php if (isset($_SESSION['datos_form']['nombre'])){ echo $_SESSION['datos_form']['nombre'];} ?>"><br><br>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido"
        required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
        title="El apellido solo puede contener letras y no puede estar vacio o en blanco"
        value="<?php if (isset($_SESSION['datos_form']['apellido'])){ echo $_SESSION['datos_form']['apellido'];} ?>"><br><br>

    <label for="cedula">Cedula:</label>
    <input type="text" id="cedula" name="cedula"
        required pattern="\d+" maxlength="8"
        title="La cedula debe contener solo numeros, sin puntos y sin espacios en blanco"
        value="<?php if (isset($_SESSION['datos_form']['cedula'])){ echo $_SESSION['datos_form']['cedula'];} ?>"><br><br>

    <label for="email">Correo electronico:</label>
    <input type="email" id="email" name="email"
        required pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|hotmail\.com)$"
        title="Solo se permiten correos de Gmail, Outlook o Hotmail" value="<?php if (isset($_SESSION['datos_form']['email'])){ echo $_SESSION['datos_form']['email'];} ?>"><br><br>

    <label for="password">Contraseña para el empleado:</label>
    <input type="text" id="password" name="password" required><br><br>

    <label for="fecha_ingreso">Fecha de ingreso:</label>
    <input type="date" id="fecha_ingreso" name="fecha_ingreso" required
        value="<?php if (isset($_SESSION['datos_form']['fecha_ingreso'])){ echo $_SESSION['datos_form']['fecha_ingreso'];} ?>"><br><br>

    <hr>

    <h4>Datos de la dirección</h4>

    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado"
        required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
        title="El estado solo puede contener letras y no puede estar vacio o en blanco" value="<?php if (isset($_SESSION['datos_form']['estado'])){ echo $_SESSION['datos_form']['estado'];}?>"><br><br>

    <label for="municipio">Municipio:</label>
    <input type="text" id="municipio" name="municipio"
        required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
        title="El municipio solo puede contener letras y no puede estar vacio o en blanco" value="<?php if (isset($_SESSION['datos_form']['municipio'])){ echo $_SESSION['datos_form']['municipio'];} ?>"><br><br>

    <label for="ciudad">Ciudad:</label>
    <input type="text" id="ciudad" name="ciudad"
        required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
        title="La ciudad solo puede contener letras y no puede estar vacio o en blanco" value="<?php if (isset($_SESSION['datos_form']['ciudad'])){ echo $_SESSION['datos_form']['ciudad'];} ?>"><br><br>

    <label for="calle">Calle:</label>
    <input type="text" id="calle" name="calle"
        required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
        title="La calle no puede estar vacio o en blanco" value="<?php if (isset($_SESSION['datos_form']['calle'])){ echo $_SESSION['datos_form']['calle'];} ?>"><br><br>

    <label for="zip">Codigo postal:</label>
    <input type="text" id="zip" name="zip"
        required pattern="\d+" maxlength="5"
        title="El codigo postal debe contener solo numeros, sin puntos y sin espacios en blanco" value="<?php if (isset($_SESSION['datos_form']['zip'])){ echo $_SESSION['datos_form']['zip'];} ?>"><br><br>

    <label for="vivienda">Referencia de la vivienda:</label>
    <input type="text" id="vivienda" name="vivienda"
        required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
        title="La referencia no puede estar vacio o en blanco" value="<?php if (isset($_SESSION['datos_form']['vivienda'])){ echo $_SESSION['datos_form']['vivienda'];} ?>"><br><br>

    <hr>

    <h4>Datos del cargo</h4>

    <label for="cargo">Cargo:</label>
    <input type="text" id="cargo" name="cargo"
        required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
        title="El cargo no puede estar vacio o en blanco" value="<?php if (isset($_SESSION['datos_form']['cargo'])){ echo $_SESSION['datos_form']['cargo'];} ?>"><br><br>

    <label for="area">Area de trabajo:</label>
    <input type="text" id="area" name="area"
        required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
        title="El area de trabajo no puede estar vacio o en blanco" value="<?php if (isset($_SESSION['datos_form']['area'])){ echo $_SESSION['datos_form']['area'];} ?>"><br><br>

    <label for="salario_base">Salario base:</label>
    <input type="text" id="salario_base" name="salario_base"
        required pattern="\d+" maxlength="6"
        title="El salario base debe contener solo numeros, sin puntos y sin espacios en blanco" value="<?php if (isset($_SESSION['datos_form']['salario_base'])){ echo $_SESSION['datos_form']['salario_base'];} ?>"><br><br>

    <div style="display: flex; flex-direction: row; gap: 10px; margin-top: 20px; align-items: center;">
        <input type="submit" name="registrar" value="Registrar empleado"><br><br>
        <button type="button" onclick="window.location.href='index.php?page=panel_rrhh'">Cancelar registro</button>
        <div class="errores" style="color: red; font-weight: bold; font-size: 1.1rem;">
            <!-- Errores de validacion -->
             <?php 
                if (isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
             ?>
        </div>
    </div>
</form>


<?php include "includes/footer.php"; ?>