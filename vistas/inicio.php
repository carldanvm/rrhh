<?php include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row full-page align-items-center justify-content-center">


        <div class="col-12 col-md-6">
            <div class="px-5">
                <div class="card pt-3">

                    <div class="d-flex justify-content-center">
                        <img style="max-width: 100%; height: auto; width: 300px;" class="card-img-top px-3" src="img/logo.png" alt="logo de la empresa contratada">
                    </div>

                    <div class="card-body p-4">
                        <div id="comenzar-registro" class="text-center">
                            <h4 class="card-title text-dark mb-4" id="titulo-registro">Registre aquí su entrada o salida</h4>
                            <div id="formulario-registro-horas" class="d-flex flex-column gap-3">
                                <div class="d-flex flex-column gap-3 align-items-center">
                                    <div id="reconocimiento-facial">
                                        <button type="button" id="startFaceRecognition" onclick="startFaceRecognition()" class="btn btn-primary boton-registrar">Realizar registro</button>

                                        <div class="d-flex justify-content-center gap-3 w-100">
                                            <button type="button" id="confirmar-registro" class="btn btn-success btn-lg fw-bold shadow-sm flex-grow-1 d-none">
                                                Confirmar registro
                                            </button>
                                            <button type="button" id="cancelar-registro" onclick="location.reload()" class="btn btn-outline-danger d-none">
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                    <div id="registro-manual" class="d-none d-flex flex-column gap-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cedula" placeholder="Cédula" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="password" placeholder="Contraseña" required>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="registroManual" onclick="registroManual()">Realizar registro</button>
                                    </div>
                                </div>
                                <div id="mensaje-exito-horas" class="text-success mt-3 d-none">
                                    <!-- Aqui se mostrara el mensaje de exito si es necesario -->
                                </div>
                                <div id="error-registro-hora" class="text-danger d-none"><!-- Aqui se mostrara mensaje de error si es necesario --></div>
                                <div class="d-flex justify-content-start">
                                    <button class="btn btn-link text-decoration-none p-0" id="toggle-form" onclick="toggleFormulario()">Registrar con contraseña</button>
                                </div>
                            </div>


                            <div id="video-container" class="d-none position-relative">
                                <div id="detection-status" class="text-center mb-3">
                                    <h3 id="status-display" class="mb-2">Posicione su rostro frente a la cámara</h3>
                                </div>
                                <div class="position-relative">
                                    <video id="videoElement" class="w-100 rounded" playsinline autoplay muted></video>
                                    <canvas id="canvasElement" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                                </div>
                                <button type="button" id="cancelarCamara" onclick="stopFaceRecognition()" class="btn btn-danger mt-3">Cancelar</button>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



    </div>
</div>




<script src="js/libs/face-api.min.js"></script>
<script src="js/face-recognition-main-page.js"></script>
<?php include 'includes/footer.php'; ?>