<?php include "includes/header.php"; ?>

<h2>Login</h2>

<div>
    <form action="index.php?page=logear" method="post">
        <input type="number" name="cedula" placeholder="Cedula"><br>
        <br>
        <input type="password" name="password" placeholder="Password"><br>
        <br>
        <button type="submit">Iniciar sesión</button>
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