<?php include 'includes/header.php'; ?>
<div class="w-100">
    <div class="row d-flex align-items-center flex-1 flex-row">

        <div style="border-right: 1px solid black; height: 100%;" class="col-6 d-flex flex-column align-items-center justify-content-center">
            <div id="reloj-container">
                <h2 id="saludo"></h2>
            </div>

            <div id="calendar-container">
                <h4 style="margin-bottom: 15px" id="calendar-month-year"></h4>
                <div id="calendar"></div>
            </div>
        </div>

        <script src="js/calendario_reloj.js"></script>

        <div class="col-6 d-flex flex-column align-items-center justify-content-center registro-horas-contenedor">

            <div class="registro-horas-formulario">

                <div id="logo-empresa">
                    <img src="img/LogoMicrosoft.jpg" alt="logo de la empresa contratada" id="imagen-empresa">
                </div>

                <div id="comenzar-registro">
                    <h4 style="color:black">Registre aquí su entrada o salida</h4>
                    <div id="formulario-registro-horas">
                        <input type="number" name="cedula" placeholder="Cédula">
                        <input type="text" name="password" placeholder="Pin">
                        <button type="button" onclick="comenzarRegistro()" class="boton-registrar">Registrar</button>
                        <div id="error-registro-hora" style="color:red"><!-- Aqui se mostrara mensaje de error si es necesario --></div>
                    </div>

                    <div style="color:green; text-align: center;" id="mensaje-exito-horas">
                        <!-- Aqui se mostrara el mensaje de exito -->
                    </div>
                </div>

                <div id="confirmar-registro" style="display: none;">
                    <h4 id="mensaje-bienvenida"><!-- Mensaje de bienvenida --></h4>
                    <div id="info-registro"><!-- Informacion de registro (es salida o entrada) --></div>
                    <button class="boton-cancelar" type="button" onclick="cancelarRegistro()">Cancelar</button>
                    <!-- El boton de confirmar se crea dinamicamente -->
                </div>



            </div>

        </div>

    </div>
</div>





<?php include 'includes/footer.php'; ?>