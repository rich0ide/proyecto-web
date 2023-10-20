<?php
date_default_timezone_set('America/Guatemala');
require('fpdf/fpdf.php');

$datos = json_decode(file_get_contents('php://input'), true);
$nombre = $datos['nombre'];
$nit = $datos['nit'];
$productos = $datos['factura'];

class PDF extends FPDF
{

    // Cabecera de página
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',12);
        // Movernos a la derecha
        $this->Cell(0,10,date('Y-m-d H:i:s'),0,1,'R');
        $this->Cell(55);
        // Salto de línea
        $this->Ln(5);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);


$pdf->Cell(0,10,'Nombre: ' . $nombre,0,1,'L');
$pdf->Cell(0,10,'NIT: ' . $nit,0,1,'L');

$pdf->Cell(25,10,'Codigo',1,0,'C',0);
$pdf->Cell(70,10,'Nombre',1,0,'C',0);
$pdf->Cell(20,10,'Precio',1,0,'C',0);
$pdf->Cell(20,10,'Cantidad',1,0,'C',0);
$pdf->Cell(50,10,'Subtotal',1,1,'C',0);
foreach ($productos as $producto){
    $pdf->Cell(25,10,$producto['codigoProducto'],1,0,'C',0);
    $pdf->Cell(70,10,$producto['nombreProducto'],1,0,'C',0);
    $pdf->Cell(20,10,$producto['precioUnitario'],1,0,'C',0);
    $pdf->Cell(20,10,$producto['cantidadProducto'],1,0,'C',0);
    $pdf->Cell(50,10,$producto['subtotal'],1,1,'C',0);
    $total += floatval($producto['subtotal']);
}

$pdf->Cell(135,10,'Total:',1,0,'R',0);  // 'R' alinea el texto a la derecha
$pdf->Cell(50,10,number_format($total, 2),1,1,'C',0);  // number_format() asegura que el total tenga 2 decimales

$pdf->Output('F','factura.pdf');
header('Content-type: application/pdf');
readfile('factura.pdf');
?>
