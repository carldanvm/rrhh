<?php include 'includes/header.php'; ?>

<div class="row">

    <div class="col-4 registro-horas-contenedor">

        <div class="registro-horas-formulario">

            <div id="comenzar-registro">
                <h4>Registrar su entrada/salida de trabajo</h4>
                <div id="formulario-registro-horas">
                    <input type="number" name="cedula" placeholder="Cedula">
                    <input type="text" name="password" placeholder="Clave">
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

    <div class="col-8 calendario">
        <div style="background: #ffffff; padding: 10px;">
            <h2>Aqui va a ir el calendario</h2>
        </div>
    </div>


</div>




<?php include 'includes/footer.php'; ?>