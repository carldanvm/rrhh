<?php 
    include 'backend/db.php';

    if (!$conn) {
        echo "<h1>Error de conexión</h1>";
    }else{
        echo "<h1>Conexión exitosa</h1>";
    }
?>