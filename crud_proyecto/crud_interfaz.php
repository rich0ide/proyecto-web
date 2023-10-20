<?php
$host = 'localhost';
$db   = 'bdnegocio';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$stmt = $pdo->query('SELECT * FROM producto');
$productos = $stmt->fetchAll();
?>

<?php
include 'conexion.php';
$sql = 'SELECT * FROM producto';
if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM producto WHERE codigoProducto LIKE '%$search%' OR nombreProducto LIKE '%$search%'";
}
$result = $conexion->query($sql);
$productos = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title></title>
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
            align-items: center;
            width: 80%;
            height: 530px;
            background-color: #fff;
            padding: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        form, .table-container {
            width: 48%;
        }
        form{
            background-color: #fff;
            padding: 20px;
        }
        .table-container {
            height: 400px; /* Ajusta esto a la altura que prefieras */
            overflow-y: auto; /* Esto agrega el scroll vertical si la tabla es más alta que el contenedor */
        }
        form input[type="text"], form input[type="date"] {
        width: 90%; /* Hacer los campos más largos */
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
        #regresar-button {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>

</head>
<body>
<a id="regresar-button" href="login.html"><i class="fa fa-arrow-left"></i> Cerrar Sesión</a>
<div style="position: absolute; top: 10px; right: 10px;">
    <a href="reporte.php" class="btn btn-primary" style="margin-right: 10px;"><i class="fa fa-file-text"></i> Reporte</a>
    <a href="facturacion.php" class="btn btn-primary"><i class="fa fa-money"></i>  Facturación</a>
</div>


<div class="container">
<!-- Formulario para agregar un nuevo producto -->
<form action="create.php" method="post">
    <center><h3>Datos del Producto</h3></center>
    <label for="codigo">Código:</label><br>
    <input type="text" id="codigo" name="codigoProducto"><br>
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombreProducto"><br>
    <label for="precio">Precio Unitario:</label><br>
    <input type="text" id="precio" name="precioUnitario"><br>
    <label for="cantidad">Cantidad:</label><br>
    <input type="text" id="cantidad" name="cantidadProducto"><br>
    <label for="fecha">Fecha de Vencimiento:</label><br>
    <input type="date" id="fecha" name="fechaVencimiento"><br>
    <button type="submit" class="btn btn-primary" name="registrar" value="ok" style="margin-top: 20px; background-color: #006999;">Crear Nuevo Registro</button>
</form>

<!-- Tabla para mostrar los productos -->
<div class="table-container">

<!-- Barra de búsqueda -->
<div style="position: sticky; top: 0; background-color: #f0f0f0; padding: 0px 0;">
    <form action="crud_interfaz.php" method="get" style="width: 100%;">
        <input type="text" name="search" placeholder="Buscar por código o nombre" style="width: 80%;">
        <button type="submit" style="width: 18%;"><i class="fa fa-search"></i> Buscar</button>
    </form>
</div>
<table>
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Precio Unitario</th>
        <th>Cantidad</th>
        <th>Fecha de Vencimiento</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= $producto['codigoProducto'] ?></td>
            <td><?= $producto['nombreProducto'] ?></td>
            <td><?= $producto['precioUnitario'] ?></td>
            <td><?= $producto['cantidadProducto'] ?></td>
            <td><?= $producto['fechaVencimiento'] ?></td>
            <td>
                <a href="update.php?id=<?= $producto['codigoProducto'] ?>" class="btn btn-default"><i class="fa fa-pencil"></i> Modificar</a>   
                <a href="delete.php?id=<?= $producto['codigoProducto'] ?>" class="btn btn-default" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')"><i class="fa fa-trash"></i> Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
</div>
</body>
</html>