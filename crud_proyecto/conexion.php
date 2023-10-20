<!-- REALIZA LA CONEXIÓN A LA BASE DE DATOS -->
<?php
$conexion = new mysqli("localhost","root","","bdnegocio");
$conexion->set_charset("utf8");
?>