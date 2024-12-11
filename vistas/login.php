<?php include "includes/header.php"; ?>

<div class="container">
    <div class="row justify-content-center align-items-center full-page">
        <div class="col-12 col-md-4 mb-5">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="text-center mb-0">Iniciar sesión como RRHH</h4>
                </div>
                <div class="card-body">
                    <form action="index.php?page=logear" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="cedula" placeholder="Cedula"
                                required pattern="\d+" maxlength="8"
                                title="La cedula debe contener solo numeros, sin puntos y sin espacios en blanco">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                            <button type="button" class="btn btn-secondary"
                                onclick="window.location.href='index.php?page=inicio'">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger mt-3 text-center">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>