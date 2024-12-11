<?php include 'includes/header.php'; ?>

<div class="container-fluid" >
    <div class="row full-page align-items-center">


        <div class="col-12 col-md-6">
            <div class="px-5">
                <div class="card pt-3">
    
                    <div class="d-flex justify-content-center">
                        <img style="width: 300px; height: auto;" class="card-img-top" src="img/logo.png" alt="logo de la empresa contratada">
                    </div>
    
                    <div class="card-body p-4">
                        <div id="comenzar-registro" class="text-center">
                            <h4 class="card-title text-dark mb-4">Registre aquí su entrada o salida</h4>
                            <div id="formulario-registro-horas" class="d-flex flex-column gap-3">
                                <input type="number" name="cedula" placeholder="Cédula" class="form-control">
                                <input type="text" name="password" placeholder="Pin" class="form-control">
                                <button type="button" onclick="comenzarRegistro()" class="btn btn-primary boton-registrar">Registrar</button>
                                <div id="error-registro-hora" class="text-danger"><!-- Aqui se mostrara mensaje de error si es necesario --></div>
                            </div>
    
                            <div id="mensaje-exito-horas" class="text-success mt-3">
                                <!-- Aqui se mostrara el mensaje de exito -->
                            </div>
                        </div>
    
                        <div id="confirmar-registro" class="text-center" style="display: none;">
                            <h4 id="mensaje-bienvenida" class="card-title mb-3"><!-- Mensaje de bienvenida --></h4>
                            <div id="info-registro" class="mb-3"><!-- Informacion de registro (es salida o entrada) --></div>
                            <button class="btn btn-danger boton-cancelar" type="button" onclick="cancelarRegistro()">Cancelar</button>
                            <!-- El boton de confirmar se crea dinamicamente -->
                        </div>
                    </div>
    
                </div>

            </div>

        </div>


        <div class="col-12 col-md-6 d-flex justify-content-center">
            <div style="max-width: 400px;">
                <div class="p-2">
                    <div id="reloj-container" class="text-center p-2 mb-2 bg-light rounded shadow-sm">
                        <h2 id="saludo" class="display-4 mb-0"></h2>
                    </div>
        
                    <div id="calendar-container" class="bg-white p-2 rounded shadow-sm">
                        <h4 id="calendar-month-year" class="text-primary mb-2 text-center"></h4>
                        <div id="calendar" class="border rounded"></div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>






<script src="js/calendario_reloj.js"></script>
<?php include 'includes/footer.php'; ?>