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

<?php include "includes/footer.php"; ?>