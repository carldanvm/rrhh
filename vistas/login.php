<?php include "includes/header.php"; ?>


<div class="formulario-login">
    <h4 style="color:black">Iniciar sesion como RRHH</h4 style="color:#000B58">
    <form action="index.php?page=logear" method="post">
        <input type="text" name="cedula" placeholder="Cedula" required pattern="\d+" maxlength="8"
                title="La cedula debe contener solo numeros, sin puntos y sin espacios en blanco"><br>
        <br>
        <input type="password" name="password" placeholder="Password" required><br>
        <br>
        <button type="submit" class="boton-iniciar-sesion">Iniciar sesión</button>
        <button type="button" class="boton-cancelar" onclick="window.location.href='index.php?page=inicio'">Cancelar</button>
    </form>
</div>
<br>

<div class="error" style="color: red; font-weight: bold" >
    <?php 
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];

            unset($_SESSION['error']);
        }
    ?>
</div>

<?php include "includes/footer.php"; ?>