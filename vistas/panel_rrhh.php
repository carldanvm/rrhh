<?php 
// Asegurarse de que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "includes/header.php"; 
?>
<div class="container-fluid bg-light px-5">
    <div class="row full-page">
        <!-- Contenido principal -->
        <div class="col-12 contenido-rrhh">

            <!-- Mensaje de exito al registrar empleado -->
            <?php
            if (isset($_SESSION['mensaje'])) {
                echo '<div class="alert alert-success alert-dismissible fade show alert-floating" role="alert" id="mensaje-alerta">';
                echo $_SESSION['mensaje'];
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
                
                // Script mejorado para la animación de cierre
                echo '<script>
                    setTimeout(function() {
                        var alert = document.getElementById("mensaje-alerta");
                        if (alert) {
                            alert.style.transition = "opacity 0.3s ease-out";
                            alert.style.opacity = "0";
                            setTimeout(function() {
                                alert.remove();
                            }, 300);
                        }
                    }, 2000);
                </script>';

                unset($_SESSION['mensaje']);
            }
            ?>

            <!-- TITULO y BOTON PARA REGISTRAR EMPLEADO -->
            <div class="d-flex align-items-center mb-2">
                <h1 class="text-center">Empleados</h1>
                <button id="btn-registrar-empleado" type="button" class="btn btn-primary ms-3 p-1" onclick="window.location.href='index.php?page=registro_empleados'">
                    Registrar empleado
                </button>
            </div>

            <div class="table-responsive">
                <table id="tabla-empleados" class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">
                                ID
                            </th>
                            <th scope="col">
                                Tipo de usuario
                            </th>
                            <th scope="col">
                                Nombre
                            </th>
                            <th scope="col">
                                Apellido
                            </th>
                            <th scope="col">
                                Cedula
                            </th>
                            <th scope="col">
                                Email
                            </th>
                            <th scope="col">
                                Cargo
                            </th>
                            <th scope="col">
                                Salario por hora
                            </th>
                            <th scope="col">
                                Horas trabajadas
                            </th>
                            <th scope="col">
                                Monto a cobrar
                            </th>
                            <th scope="col">
                                Inasistencias
                            </th>
                            <th scope="col">
                                Fecha de ingreso
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los demas registros se agregan dinamicamente con JS -->
                    </tbody>
                </table>
            </div>



        </div>
    </div>
</div>




<!-- Modales -->
<?php include 'modals/empleadoModal.php'; ?>
<?php include 'modals/editarEmpleadoModal.php'; ?>
<?php include 'modals/eliminarModal.php'; ?>
<?php include 'modals/diasLibresModal.php'; ?>


<?php include 'includes/footer.php'; ?>

<script src="js/tabla-rrhh.js"></script>