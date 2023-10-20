<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

if(isset($_POST['registrar'])) {
    // Obtén los datos del formulario
    $codigoProducto = $_POST['codigoProducto'];
    $nombreProducto = $_POST['nombreProducto'];
    $precioUnitario = $_POST['precioUnitario'];
    $cantidadProducto = $_POST['cantidadProducto'];
    $fechaVencimiento = date('Y-m-d', strtotime($_POST['fechaVencimiento'])); // Convert the date to 'YYYY-MM-DD' format

    // Prepara la consulta SQL para insertar el nuevo producto
    $sql = "INSERT INTO producto (codigoProducto, nombreProducto, precioUnitario, cantidadProducto, fechaVencimiento) VALUES (?, ?, ?, ?, ?)";
    $stmt= $conexion->prepare($sql);
    $stmt->bind_param("sssss", $codigoProducto, $nombreProducto, $precioUnitario, $cantidadProducto, $fechaVencimiento);
    $stmt->execute();

    // Redirige al usuario a la página principal después de insertar el producto
    header("Location: crud_interfaz.php");
}
?>
