<?php include "includes/header.php"; ?>
<script src="js/selectorDirecciones.js"></script>

<div class="container-fluid">
    <form class="" id="registrar-empleado-form" action="index.php?page=registrar" method="post">
        <div class="row full-page">

            <div class="col-12 col-md-4 pt-1">
                <div class="card shadow-sm">

                    <div class="card-header">
                        <h2 class="card-title">Informacion Personal</h2>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label">Tipo de usuario</label>
                            <select class="form-select" id="tipo_usuario" name="tipo_usuario" required>
                                <option value="" disabled selected>Seleccione tipo de usuario</option>
                                <option value="rrhh">RRHH</option>
                                <option value="empleado">Empleado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input class="form-control" type="text" id="nombre" name="nombre"
                                required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                                title="El nombre solo puede contener letras y no puede estar vacio o en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['nombre'])) {
                                            echo $_SESSION['datos_form']['nombre'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input class="form-control" type="text" id="apellido" name="apellido"
                                required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                                title="El apellido solo puede contener letras y no puede estar vacio o en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['apellido'])) {
                                            echo $_SESSION['datos_form']['apellido'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="cedula" class="form-label">Cédula</label>
                            <input class="form-control" type="text" id="cedula" name="cedula"
                                required pattern="\d+" maxlength="8"
                                title="La cedula debe contener solo numeros, sin puntos y sin espacios en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['cedula'])) {
                                            echo $_SESSION['datos_form']['cedula'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input class="form-control" type="email" id="email" name="email"
                                required pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|hotmail\.com)$"
                                title="Solo se permiten correos de Gmail, Outlook o Hotmail"
                                value="<?php if (isset($_SESSION['datos_form']['email'])) {
                                            echo $_SESSION['datos_form']['email'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input class="form-control" type="text" id="telefono" name="telefono"
                                required pattern="\d+" maxlength="13"
                                title="El telefono debe contener solo numeros, sin espacios en blanco ni cualquier otro simbolo"
                                value="<?php if (isset($_SESSION['datos_form']['telefono'])) {
                                            echo $_SESSION['datos_form']['telefono'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input class="form-control" type="password" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
                            <input class="form-control" type="date" id="fecha_ingreso" name="fecha_ingreso" required
                                value="<?php if (isset($_SESSION['datos_form']['fecha_ingreso'])) {
                                            echo $_SESSION['datos_form']['fecha_ingreso'];
                                        } ?>">
                        </div>
                    </div>


                </div>
            </div>


            <div class="col-12 col-md-4 pt-1">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h2 class="card-title">Datos de dirección</h2>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input class="form-control" type="text" id="estado" name="estado"
                                required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                                title="El estado solo puede contener letras y no puede estar vacio o en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['estado'])) {
                                            echo $_SESSION['datos_form']['estado'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="municipio" class="form-label">Municipio</label>
                            <input class="form-control" type="text" id="municipio" name="municipio"
                                required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                                title="El municipio solo puede contener letras y no puede estar vacio o en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['municipio'])) {
                                            echo $_SESSION['datos_form']['municipio'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input class="form-control" type="text" id="ciudad" name="ciudad"
                                required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                                title="La ciudad solo puede contener letras y no puede estar vacio o en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['ciudad'])) {
                                            echo $_SESSION['datos_form']['ciudad'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="calle" class="form-label">Calle</label>
                            <input class="form-control" type="text" id="calle" name="calle"
                                required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                                title="La calle no puede estar vacio o en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['calle'])) {
                                            echo $_SESSION['datos_form']['calle'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="zip" class="form-label">Código postal</label>
                            <input class="form-control" type="text" id="zip" name="zip"
                                required pattern="\d+" maxlength="5"
                                title="El codigo postal debe contener solo numeros, sin puntos y sin espacios en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['zip'])) {
                                            echo $_SESSION['datos_form']['zip'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="vivienda" class="form-label">Referencia de vivienda</label>
                            <input class="form-control" type="text" id="vivienda" name="vivienda"
                                required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                                title="La referencia no puede estar vacio o en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['vivienda'])) {
                                            echo $_SESSION['datos_form']['vivienda'];
                                        } ?>">
                        </div>
                    </div>


                </div>


            </div>
            <div class="col-12 col-md-4 pt-1">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h2 class="card-title">Datos del cargo</h2>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="cargo" class="form-label">Cargo</label>
                            <input class="form-control" type="text" id="cargo" name="cargo"
                                required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                                title="El cargo no puede estar vacio o en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['cargo'])) {
                                            echo $_SESSION['datos_form']['cargo'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="area" class="form-label">Área de trabajo</label>
                            <input class="form-control" type="text" id="area" name="area"
                                required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                                title="El area de trabajo no puede estar vacio o en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['area'])) {
                                            echo $_SESSION['datos_form']['area'];
                                        } ?>">
                        </div>

                        <div class="mb-3">
                            <label for="salario_base" class="form-label">Salario base</label>
                            <input class="form-control" type="text" id="salario_base" name="salario_base"
                                required pattern="\d+" maxlength="6"
                                title="El salario base debe contener solo numeros, sin puntos y sin espacios en blanco"
                                value="<?php if (isset($_SESSION['datos_form']['salario_base'])) {
                                            echo $_SESSION['datos_form']['salario_base'];
                                        } ?>">
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex justify-content-center gap-2">
                                <input class="btn btn-primary" type="submit" name="registrar" value="Registrar empleado">
                                <button class="btn btn-secondary" type="button" onclick="window.location.href='index.php?page=panel_rrhh'">Cancelar</button>
                            </div>
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>


<?php include "includes/footer.php"; ?>