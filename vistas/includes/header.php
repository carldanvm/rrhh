<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <title>RRHH</title>

    <style>
        hr {
            margin: 5px 0;
            padding: 0;
            border: none;
            border-top: 1px solid #000;
        }
    </style>

</head>

<body>
    <header class="sticky-top bg-dark text-white">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                
                <!-- Logo/Título -->
                <a class="navbar-brand" href="index.php?page=inicio">
                    <h1 style="font-size: 1.3rem;" class="h3 mb-0">Sistema de recursos humanos</h1>
                </a>

                <!-- Botón hamburguesa para móviles -->
                <button style="padding: 2px;" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menú de navegación -->
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <?php
                        if (isset($_SESSION['logeado_id'])) {
                            echo '<li class="nav-item">
                                <a class="nav-link" href="index.php?page=inicio">Inicio</a>
                              </li>';

                            echo '<li class="nav-item">
                                <a class="nav-link" href="index.php?page=panel_rrhh">Panel RRHH</a>
                              </li>';

                            echo '<li class="nav-item">
                                <a class="nav-link" href="index.php?page=logout">Cerrar sesión</a>
                              </li>';
                        } else {
                            echo '<li class="nav-item">
                                <a class="nav-link" href="index.php?page=login">Iniciar sesión</a>
                              </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
