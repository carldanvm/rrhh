<?php include 'includes/header.php'; ?>

<div id="comenzar-registro">
    <h3>Registrar su entrada/salida de trabajo</h3>
    <div>
        <input type="number" name="cedula" placeholder="Cedula">
        <br><br>
        <input type="text" name="password" placeholder="Clave">
        <br><br>
        <button type="button" onclick="comenzarRegistro()">Registrar</button>
    </div>
</div>

<div id="confirmar-registro" style="display: none;">
    <h4 id="mensaje-bienvenida"><!-- Mensaje de bienvenida --></h4>
    <div id="info-registro"><!-- Informacion de registro (es salida o entrada) --></div>
    <button type="button" onclick="cancelarRegistro()">Cancelar</button>
    <!-- El boton de confirmar se crea dinamicamente -->
</div>

<?php include 'includes/footer.php'; ?>