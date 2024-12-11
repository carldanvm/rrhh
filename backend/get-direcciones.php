<?php
include 'db.php';

// Si no hay una sesion iniciada, redirigir al inicio
session_start();
if (!isset($_SESSION['logeado_id'])) {
    header('Location: ../index.php?page=login');
    exit();
}



    $sql = "SELECT * FROM estados";
    $resultEstados = $conn->query($sql);

    $sql = "SELECT * FROM ciudades";
    $resultCiudades = $conn->query($sql);

    $sql = "SELECT * FROM municipios";
    $resultMunicipios = $conn->query($sql);

    $sql = "SELECT * FROM parroquias";
    $resultParroquias = $conn->query($sql);

    $estados = array();
    while ($row = $resultEstados->fetch_assoc()) {
        $estados[] = $row;
    }

    $ciudades = array();
    while ($row = $resultCiudades->fetch_assoc()) {
        $ciudades[] = $row;
    }

    $municipios = array();
    while ($row = $resultMunicipios->fetch_assoc()) {
        $municipios[] = $row;
    }

    $parroquias = array();
    while ($row = $resultParroquias->fetch_assoc()) {
        $parroquias[] = $row;
    }

    /* Recorrer estados */
    foreach ($estados as &$estado) {

        /* obtener ciudades y municipios del estado */
        $ciudadesFiltradas = array_filter($ciudades, function ($ciudad) use ($estado) {
            return $ciudad['id_estado'] == $estado['id_estado'];
        });

        $municipiosFiltrados = array_filter($municipios, function ($municipio) use ($estado) {
            return $municipio['id_estado'] == $estado['id_estado'];
        });

        /* A cada municipio anadirle sus parroquias */
        foreach ($municipiosFiltrados as &$municipio) {
            $municipio['parroquias'] = array_filter($parroquias, function ($parroquia) use ($municipio) {
                return $parroquia['id_municipio'] == $municipio['id_municipio'];
            });
        }

        /* A cada estado anadirle sus ciudades y municipios */
        $estado['ciudades'] = $ciudadesFiltradas;
        $estado['municipios'] = $municipiosFiltrados;

        

    }
    unset($estado);

    echo json_encode($estados);

