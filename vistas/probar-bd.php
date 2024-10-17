<?php include 'includes/header.php'; ?>

<?php 
    include 'backend/db.php';

    if ($conn) {
        echo "<h1>Conexión exitosa</h1>";
    } else{
        echo "<h1>Error de conexión</h1>";
    }
?>

<?php include 'includes/footer.php'; ?>