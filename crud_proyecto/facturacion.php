<?php
include 'conexion.php';
$sql = 'SELECT * FROM producto';
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
		    flex-direction: column;
		    justify-content: center;
		    align-items: center;
		    min-height: 100vh;
		    background-color: #f0f0f0;
		}
		.container {
		    display: flex;
		    justify-content: space-between; /* This will add space between your tables */
		    align-items: flex-start;
		    width: 80%;

		}
		form, .table-container {
		    width: 48%;
		}
		form {
		    background-color: #fff;
		    padding: 10px;
		    box-shadow: 0px 0px 10px rgba(0,0,0,0);
            width: 90%;
		}
		form input[type="text"], form input[type="date"] {
		width: 35%; /* Make the fields longer */
		}
		table {
		    border-collapse: collapse;
		    width: 100%;
		}
		th, td {
		    border: 1px solid #380082;
		    padding: 8px;
            text-align: center;
		}
		th {
		    background-color: #006999;
		    color: white;
            text-align: center;
		}
		/* Add this to position your buttons */
		#imprimir-button {
		    position: center;
		    bottom: 30px;
		    right: 10px;
		}
		#regresar-button {
		    position: absolute;
		    top: 10px;
		    left: 10px;
		}
		.table-title {
		    text-align: center;
		    font-size: 24px;
		}
		/* Style your tables */
		.table-container {
		    display: flex;
		    flex-direction: column;
		    align-items: center;
		    width: 50%;
		    height: 300; /* Set a specific height */
		    overflow-y: auto; /* Enable vertical scrolling */
		    padding:20px;
		}
		/* Change the color of the headers in the second table */
		.table-container:nth-child(2) th {
		    background-color: #db40a7; /* Change this to a different color */
		}
		.total-container {
			height: 350px;
            display: flex;
            background-color: #fff;
            box-shadow: 0px 0px 5px rgba(0,0,0,0);
		    flex-direction: row;
        }

	</style>
</head>
<body>
<a id="regresar-button" href="crud_interfaz.php"><i class="fa fa-arrow-left"></i> Regresar</a>
<form>
<label for="nombre">Nombre:</label><br>
<input type="text" id="nombre" name="nombre"><br>
<label for="nit">NIT:</label><br>
<input type="text" id="nit" name="nit"><br>

<div class="total-container">
<div class="table-container">
<h2 class="table-title">Inventario</h2>
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
            <td><button class="button" onclick="agregar('<?= $producto['codigoProducto'] ?>', '<?= $producto['nombreProducto'] ?>', '<?= $producto['precioUnitario'] ?>', '<?= $producto['cantidadProducto'] ?>')"><i class="fa fa-plus" style="color:green;"></i></button></td>

        </tr>
    <?php endforeach; ?>
</table>
</div>

<div class="table-container">
<h2 class="table-title">Factura</h2>
<table id="factura">
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Precio Unitario</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
        <th>Acciones</th>
    </tr>
</table>
</div>
</div>
<div align="right">
    <h3>Total</h3>
    <p id="total">Q 0.00</p>
<button id="imprimir-button" onclick="generarPDF()"><i class="fa fa-print"></i> Imprimir</button>
</div>
</div>
</form>
<script>

function calcularTotal() {
    // Get the "factura" table
    var table = document.getElementById('factura');

    // Initialize the total
    var total = 0;

    // Loop over the rows in the table
    for (var i = 1; i < table.rows.length; i++) {
        // Get the current row
        var row = table.rows[i];

        // Get the subtotal from the fifth cell in the row
        var subtotal = parseFloat(row.cells[4].textContent);

        // Add the subtotal to the total
        total += subtotal;
    }

    // Display the total
    document.getElementById('total').textContent = 'Q ' + total.toFixed(2);
}

function agregar(codigo, nombre, precio, cantidad) {
    event.preventDefault();
	var table = document.getElementById('factura');

    // Check if a product with the same code already exists in the table
    for (var i = 0; i < table.rows.length; i++) {
        // Get the current row
        var row = table.rows[i];

        // Get the product code from the first cell in the row
        var rowCodigo = row.cells[0].textContent;

        // If the product code matches the one to be added, return without adding it
        if (rowCodigo === codigo) {
            alert('Este producto ya ha sido agregado.');
            return;
        }
    }
    // Create a new row
    var row = document.createElement('tr');

    // Create cells for the product details
    var codigoCell = document.createElement('td');
    var nombreCell = document.createElement('td');
    var precioCell = document.createElement('td');
    var cantidadCell = document.createElement('td');
    var subtotalCell = document.createElement('td');

    // Create a cell for the "Quitar" button
    var quitarCell = document.createElement('td');
    var quitarButton = document.createElement('button');
    quitarButton.innerHTML = '<i class="fa fa-minus" style="color:red;"></i>';
    quitarButton.onclick = function() {
        quitar(codigo);
    };
    quitarCell.appendChild(quitarButton);

    // Add the product details to the cells
    codigoCell.textContent = codigo;
    nombreCell.textContent = nombre;
    precioCell.textContent = precio;
    subtotalCell.textContent = 1*precio;

    // Add an input field for the quantity
    var cantidadInput = document.createElement('input');
    cantidadInput.type = 'number';
    cantidadInput.value = 1; // Set initial value to 0
    cantidadInput.max = cantidad; // Set max value to product's quantity
    cantidadInput.min = 1; // Set max value to product's quantity
    cantidadInput.oninput = function() {
        // Update the subtotal when the quantity changes
        subtotalCell.textContent = (cantidadInput.value * precio).toFixed(2);
        // Calculate the new total
        calcularTotal();
    };
    cantidadCell.appendChild(cantidadInput);

    // Add the cells to the row
    row.appendChild(codigoCell);
    row.appendChild(nombreCell);
    row.appendChild(precioCell);
    row.appendChild(cantidadCell);
    row.appendChild(subtotalCell);
    row.appendChild(quitarCell);

    // Add the row to the "factura" table
    document.getElementById('factura').appendChild(row);

    // Calculate the new total
    calcularTotal();
}

function quitar(codigo) {
    event.preventDefault();
    // Get the "factura" table
    var table = document.getElementById('factura');

    // Loop over the rows in the table
    for (var i = 0; i < table.rows.length; i++) {
        // Get the current row
        var row = table.rows[i];

        // Get the product code from the first cell in the row
        var rowCodigo = row.cells[0].textContent;

        // If the product code matches the one to be removed, delete the row
        if (rowCodigo === codigo) {
            table.deleteRow(i);
            break;
        }
    }
        // Calculate the new total
    calcularTotal();
}

function generarPDF() {
    event.preventDefault();
    var nombre = document.getElementById('nombre').value;
    var nit = document.getElementById('nit').value;
    var factura = [];
    var table = document.getElementById('factura');
    for (var i = 1; i < table.rows.length; i++) {
        var row = table.rows[i];
        var producto = {
            codigoProducto: row.cells[0].textContent,
            nombreProducto: row.cells[1].textContent,
            precioUnitario: row.cells[2].textContent,
            cantidadProducto: row.cells[3].getElementsByTagName('input')[0].value, // Obtiene el valor del campo de entrada
            subtotal: row.cells[4].textContent
        };
        factura.push(producto);
    }

    // Enviar los datos a 'generarFactura.php' usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'imprimir.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Abrir el PDF generado en una nueva pestaña
            var blob = new Blob([xhr.response], {type: 'application/pdf'});
            var url = 'http://localhost/crud_proyecto/factura.pdf';
            window.open(url, '_blank');
        }
    };
    xhr.send(JSON.stringify({nombre: nombre, nit: nit, factura: factura}));
}

</script>
</body>
</html>