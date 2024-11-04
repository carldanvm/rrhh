<?php include "includes/header.php"; ?>

<hr>
<h2 style="background-color: lightgray; padding: 10px">Registro de nuevo empleado</h2>
<hr>
<br>

<form id="registrar-empleado-form" action="index.php?page=registrar" method="post">
    <div class="row">
        <div class="col-4">
            <div class="grupo-form">
                <h4>Datos personales</h4>

                <select id="tipo_usuario" name="tipo_usuario" required>
                    <option value="" disabled selected>Tipo de usuario</option>
                    <option value="rrhh">RRHH</option>
                    <option value="empleado">Empleado</option>
                </select>
    
                <input type="text" id="nombre" name="nombre" placeholder="Nombre"
                    required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                    title="El nombre solo puede contener letras y no puede estar vacio o en blanco"
                    value="<?php if (isset($_SESSION['datos_form']['nombre'])) {
                                echo $_SESSION['datos_form']['nombre'];
                            } ?>">

                <input type="text" id="apellido" name="apellido" placeholder="Apellido"
                    required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                    title="El apellido solo puede contener letras y no puede estar vacio o en blanco"
                    value="<?php if (isset($_SESSION['datos_form']['apellido'])) {
                                echo $_SESSION['datos_form']['apellido'];
                            } ?>">

                <input type="text" id="cedula" name="cedula" placeholder="Cedula"
                    required pattern="\d+" maxlength="8"
                    title="La cedula debe contener solo numeros, sin puntos y sin espacios en blanco"
                    value="<?php if (isset($_SESSION['datos_form']['cedula'])) {
                                echo $_SESSION['datos_form']['cedula'];
                            } ?>">

                <input type="email" id="email" name="email" placeholder="Correo electronico"
                    required pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|hotmail\.com)$"
                    title="Solo se permiten correos de Gmail, Outlook o Hotmail" 
                    value="<?php if (isset($_SESSION['datos_form']['email'])) {
                                echo $_SESSION['datos_form']['email'];
                            } ?>">

                <input type="text" id="telefono" name="telefono" placeholder="Telefono"
                    required pattern="\d+" maxlength="13"
                    title="El telefono debe contener solo numeros, sin espacios en blanco ni cualquier otro simbolo" 
                    value="<?php if (isset($_SESSION['datos_form']['telefono'])) {
                                echo $_SESSION['datos_form']['telefono'];
                            } ?>">

                <input type="text" id="password" name="password" placeholder="Contraseña para el empleado" required>

                <div>
                    <label for="fecha_ingreso">Fecha de ingreso:</label>
                    <input type="date" id="fecha_ingreso" name="fecha_ingreso" required
                            value="<?php if (isset($_SESSION['datos_form']['fecha_ingreso'])) {
                                        echo $_SESSION['datos_form']['fecha_ingreso'];
                                    } ?>">
                </div>
            </div>
        </div>


        <div class="col-4">
            <div class="grupo-form">
                <h4>Datos de dirección</h4>

                <input type="text" id="estado" name="estado" placeholder="Estado"
                    required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                    title="El estado solo puede contener letras y no puede estar vacio o en blanco" 
                    value="<?php if (isset($_SESSION['datos_form']['estado'])) {
                                echo $_SESSION['datos_form']['estado'];
                            } ?>">


                <input type="text" id="municipio" name="municipio" placeholder="Municipio"
                    required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                    title="El municipio solo puede contener letras y no puede estar vacio o en blanco" 
                    value="<?php if (isset($_SESSION['datos_form']['municipio'])) {
                                echo $_SESSION['datos_form']['municipio'];
                            } ?>">


                <input type="text" id="ciudad" name="ciudad" placeholder="Ciudad"
                    required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                    title="La ciudad solo puede contener letras y no puede estar vacio o en blanco" 
                    value="<?php if (isset($_SESSION['datos_form']['ciudad'])) {
                                echo $_SESSION['datos_form']['ciudad'];
                            } ?>">


                <input type="text" id="calle" name="calle" placeholder="Calle"
                    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                    title="La calle no puede estar vacio o en blanco" 
                    value="<?php if (isset($_SESSION['datos_form']['calle'])) {
                                echo $_SESSION['datos_form']['calle'];
                            } ?>">


                <input type="text" id="zip" name="zip" placeholder="Codigo postal"
                    required pattern="\d+" maxlength="5"
                    title="El codigo postal debe contener solo numeros, sin puntos y sin espacios en blanco" 
                    value="<?php if (isset($_SESSION['datos_form']['zip'])) {
                                echo $_SESSION['datos_form']['zip'];
                            } ?>">


                <input type="text" id="vivienda" name="vivienda" placeholder="Referencia de vivienda"
                    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                    title="La referencia no puede estar vacio o en blanco" 
                    value="<?php if (isset($_SESSION['datos_form']['vivienda'])) {
                                echo $_SESSION['datos_form']['vivienda'];
                            } ?>">
            </div>


        </div>
        <div class="col-4">
            <div class="grupo-form">
                <h4>Datos del cargo</h4>

                <input type="text" id="cargo" name="cargo" placeholder="Cargo"
                    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                    title="El cargo no puede estar vacio o en blanco" 
                    value="<?php if (isset($_SESSION['datos_form']['cargo'])) {
                                echo $_SESSION['datos_form']['cargo'];
                            } ?>">

                <input type="text" id="area" name="area" placeholder="Area de trabajo"
                    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                    title="El area de trabajo no puede estar vacio o en blanco" 
                    value="<?php if (isset($_SESSION['datos_form']['area'])) {
                                echo $_SESSION['datos_form']['area'];
                            } ?>">

                <input type="text" id="salario_base" name="salario_base" placeholder="Salario base"
                    required pattern="\d+" maxlength="6"
                    title="El salario base debe contener solo numeros, sin puntos y sin espacios en blanco" 
                    value="<?php if (isset($_SESSION['datos_form']['salario_base'])) {
                                echo $_SESSION['datos_form']['salario_base'];
                            } ?>">

                <div style="display: flex; flex-direction: row; gap: 10px; margin-top: 20px; align-items: center;">
                    <input type="submit" name="registrar" value="Registrar empleado">
                    <button type="button" onclick="window.location.href='index.php?page=panel_rrhh'">Cancelar</button>
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
            </div>
        </div>
    </div>
</form>

<?php include "includes/footer.php"; ?>