<?php
include "conexion.php";
$codigoProducto = $_GET['id'];
$tabla = 'producto';
$sql = "DELETE FROM {$tabla} WHERE codigoProducto = '{$codigoProducto}'";
if ($conexion->query($sql) === TRUE) {
  echo "<script>alert('Registro eliminado con éxito'); window.location.href='crud_interfaz.php';</script>";
} else {
  echo "Error al eliminar el registro: " . $conexion->error;
}
$conexion->close();
?>