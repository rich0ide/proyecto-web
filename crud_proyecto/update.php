<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Obtén el código del producto desde la URL
$codigoProducto = $_GET['id'];

// Consulta para obtener los detalles del producto
$stmt = $conexion->prepare("SELECT * FROM producto WHERE codigoProducto = ?");
$stmt->bind_param("s", $codigoProducto);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if(isset($_POST['actualizar'])) {
    // Obtén los datos del formulario
    $nombreProducto = $_POST['nombreProducto'];
    $precioUnitario = $_POST['precioUnitario'];
    $cantidadProducto = $_POST['cantidadProducto'];
    $fechaVencimiento = date('Y-m-d', strtotime($_POST['fechaVencimiento'])); // Convert the date to 'YYYY-MM-DD' format

    // Prepara la consulta SQL para actualizar el producto
    $sql = "UPDATE producto SET nombreProducto = ?, precioUnitario = ?, cantidadProducto = ?, fechaVencimiento = ? WHERE codigoProducto = ?";
    $stmt= $conexion->prepare($sql);
    $stmt->bind_param("sssss", $nombreProducto, $precioUnitario, $cantidadProducto, $fechaVencimiento, $codigoProducto);
    $stmt->execute();

    // Redirige al usuario a la página principal después de actualizar el producto
    header("Location: crud_interfaz.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 80%;
        }
        form, .table-container {
            width: 48%;
        }
        form {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .table-container {
            height: 400px; /* Ajusta esto a la altura que prefieras */
            overflow-y: auto; /* Esto agrega el scroll vertical si la tabla es más alta que el contenedor */
        }
        form input[type="text"], form input[type="date"] {
        width: 98%; /* Hacer los campos más largos */
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #380082;
            padding: 8px;
        }
        th {
            background-color: #006999;
            color: white;
        }
    </style>
</head>
<body>
<body>
<div class="container">
    
<!-- Formulario para actualizar el producto -->
<form action="update.php?id=<?= $producto['codigoProducto'] ?>" method="post">
    <center><h3>Datos del Producto</h3></center>
    <label for="codigo">Código:</label><br>
    <input type="text" id="codigo" name="codigoProducto" value="<?= $producto['codigoProducto'] ?>" readonly><br>
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombreProducto" value="<?= $producto['nombreProducto'] ?>"><br>
    <label for="precio">Precio Unitario:</label><br>
    <input type="text" id="precio" name="precioUnitario" value="<?= $producto['precioUnitario'] ?>"><br>
    <label for="cantidad">Cantidad:</label><br>
    <input type="text" id="cantidad" name="cantidadProducto" value="<?= $producto['cantidadProducto'] ?>"><br>
    <label for="fecha">Fecha de Vencimiento:</label><br>
    <input type="date" id="fecha" name="fechaVencimiento" value="<?= date('Y-m-d', strtotime($producto['fechaVencimiento'])) ?>"><br>
    <button type="submit" class="btn btn-primary" name="actualizar" value="ok" style="margin-top: 20px; background-color: #006999;">Actualizar Registro</button>
</form>
</div>
</body>
</html>
