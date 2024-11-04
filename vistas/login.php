<?php include "includes/header.php"; ?>

<h2>Login</h2>

<div>
    <form action="index.php?page=logear" method="post">
        <input type="text" name="cedula" placeholder="Cedula" required pattern="\d+" maxlength="8"
                title="La cedula debe contener solo numeros, sin puntos y sin espacios en blanco"><br>
        <br>
        <input type="password" name="password" placeholder="Password" required><br>
        <br>
        <button type="submit">Iniciar sesión</button>
        <button type="button" onclick="window.location.href='index.php?page=inicio'">Cancelar</button>
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