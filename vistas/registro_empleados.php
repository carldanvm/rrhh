<?php include "includes/header.php"; ?>


<div class="container">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <form id="registrar-empleado-form" action="index.php?page=registrar" method="post">
                <div class="card shadow mt-4 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0 fs-4" id="step-title">Información Personal</h2>
                        <div class="step-indicator">
                            Paso <span id="current-step">1</span> de 3
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Paso 1: Información Personal -->
                        <div class="step" id="step-1">
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
                                    value="<?php echo isset($_SESSION['datos_form']['nombre']) ? $_SESSION['datos_form']['nombre'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input class="form-control" type="text" id="apellido" name="apellido"
                                    required pattern="^[A-Za-z]+(?:\s[A-Za-z]+)*$"
                                    title="El apellido solo puede contener letras y no puede estar vacio o en blanco"
                                    value="<?php echo isset($_SESSION['datos_form']['apellido']) ? $_SESSION['datos_form']['apellido'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="cedula" class="form-label">Cédula</label>
                                <input class="form-control" type="text" id="cedula" name="cedula"
                                    required pattern="\d+" maxlength="8"
                                    title="La cedula debe contener solo numeros, sin puntos y sin espacios en blanco"
                                    value="<?php echo isset($_SESSION['datos_form']['cedula']) ? $_SESSION['datos_form']['cedula'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    required pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|hotmail\.com)$"
                                    title="Solo se permiten correos de Gmail, Outlook o Hotmail"
                                    value="<?php echo isset($_SESSION['datos_form']['email']) ? $_SESSION['datos_form']['email'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input class="form-control" type="text" id="telefono" name="telefono"
                                    required pattern="\d+" maxlength="13"
                                    title="El telefono debe contener solo numeros, sin espacios en blanco ni cualquier otro simbolo"
                                    value="<?php echo isset($_SESSION['datos_form']['telefono']) ? $_SESSION['datos_form']['telefono'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input class="form-control" type="password" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
                                <input class="form-control" type="date" id="fecha_ingreso" name="fecha_ingreso" required
                                    value="<?php echo isset($_SESSION['datos_form']['fecha_ingreso']) ? $_SESSION['datos_form']['fecha_ingreso'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen del rostro del empleado (foto actual)</label>
                                <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*" required>
                                <input type="hidden" id="descriptor_facial" name="descriptor_facial" required>
                                <div id="face-status" class="form-text mt-2"></div>
                            </div>

                        </div>

                        <!-- Paso 2: Datos de dirección -->
                        <div class="step d-none" id="step-2">
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="" disabled selected>Seleccione un estado</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="municipio" class="form-label">Municipio</label>
                                <select class="form-select" id="municipio" name="municipio" required>
                                    <option value="" disabled selected>Seleccione un municipio</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="parroquia" class="form-label">Parroquia</label>
                                <select class="form-select" id="parroquia" name="parroquia" required>
                                    <option value="" disabled selected>Seleccione una parroquia</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="calle" class="form-label">Calle</label>
                                <input class="form-control" type="text" id="calle" name="calle"
                                    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                                    title="La calle no puede estar vacio o en blanco"
                                    value="<?php echo isset($_SESSION['datos_form']['calle']) ? $_SESSION['datos_form']['calle'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="zip" class="form-label">Código postal</label>
                                <input class="form-control" type="text" id="zip" name="zip"
                                    required pattern="\d+" maxlength="5"
                                    title="El codigo postal debe contener solo numeros, sin puntos y sin espacios en blanco"
                                    value="<?php echo isset($_SESSION['datos_form']['zip']) ? $_SESSION['datos_form']['zip'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="vivienda" class="form-label">Referencia de vivienda</label>
                                <input class="form-control" type="text" id="vivienda" name="vivienda"
                                    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                                    title="La referencia no puede estar vacio o en blanco"
                                    value="<?php echo isset($_SESSION['datos_form']['vivienda']) ? $_SESSION['datos_form']['vivienda'] : ''; ?>">
                            </div>
                        </div>

                        <!-- Paso 3: Datos del cargo -->
                        <div class="step d-none" id="step-3">
                            <div class="mb-3">
                                <label for="cargo" class="form-label">Cargo</label>
                                <input class="form-control" type="text" id="cargo" name="cargo"
                                    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                                    title="El cargo no puede estar vacio o en blanco"
                                    value="<?php echo isset($_SESSION['datos_form']['cargo']) ? $_SESSION['datos_form']['cargo'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="area" class="form-label">Área de trabajo</label>
                                <input class="form-control" type="text" id="area" name="area"
                                    required pattern="^[A-Za-z0-9]+(?:\s[A-Za-z0-9]+)*$"
                                    title="El área no puede estar vacio o en blanco"
                                    value="<?php echo isset($_SESSION['datos_form']['area']) ? $_SESSION['datos_form']['area'] : ''; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="salario_base" class="form-label">Salario base</label>
                                <input class="form-control" type="text" id="salario_base" name="salario_base"
                                    required pattern="\d+" maxlength="6"
                                    title="El salario base debe contener solo numeros, sin puntos y sin espacios en blanco"
                                    value="<?php echo isset($_SESSION['datos_form']['salario_base']) ? $_SESSION['datos_form']['salario_base'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="prev-step" disabled>Anterior</button>
                        <button type="button" class="btn btn-primary" id="next-step" disabled>Siguiente</button>
                        <button type="submit" class="btn btn-success d-none" id="submit-form">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/libs/face-api.min.js"></script>
<script src="js/face-recognition.js"></script>
<script src="js/selectorDirecciones.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registrar-empleado-form');
        const steps = document.querySelectorAll('.step');
        const nextBtn = document.getElementById('next-step');
        const prevBtn = document.getElementById('prev-step');
        const submitBtn = document.getElementById('submit-form');
        const stepTitle = document.getElementById('step-title');
        const currentStepSpan = document.getElementById('current-step');
        let currentStep = 0;

        const titles = [
            'Información Personal',
            'Datos de dirección',
            'Datos del cargo'
        ];

        function updateStep() {
            steps.forEach((step, index) => {
                step.classList.toggle('d-none', index !== currentStep);
            });

            // Actualizar título y número de paso
            stepTitle.textContent = titles[currentStep];
            currentStepSpan.textContent = currentStep + 1;

            // Actualizar botones
            prevBtn.disabled = currentStep === 0;
            nextBtn.classList.toggle('d-none', currentStep === steps.length - 1);
            submitBtn.classList.toggle('d-none', currentStep !== steps.length - 1);
        }

        function validateCurrentStep() {
            const currentStepElement = steps[currentStep];
            const inputs = currentStepElement.querySelectorAll('input, select');
            let isValid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required') && !input.value) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

        nextBtn.addEventListener('click', () => {
            if (validateCurrentStep()) {
                currentStep++;
                updateStep();
            }
        });

        prevBtn.addEventListener('click', () => {
            currentStep--;
            updateStep();
        });

        form.addEventListener('submit', (e) => {
            if (!validateCurrentStep()) {
                e.preventDefault();
            }
        });

        // Inicializar
        updateStep();
    });
</script>
<?php include "includes/footer.php"; ?>