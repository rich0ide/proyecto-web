<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    // Movernos a la derecha
    $this->Cell(55);
    // Título
    $this->Cell(90,10,'REPORTE DE PRODUCTOS',1,0,'C');
    // Salto de línea
    $this->Ln(20);
    $this->Cell(25,10,'Codigo',1,0,'C',0);
    $this->Cell(70,10,'Nombre',1,0,'C',0);
    $this->Cell(20,10,'Precio',1,0,'C',0);
    $this->Cell(20,10,'Cantidad',1,0,'C',0);
    $this->Cell(50,10,'Fecha de Vencimiento',1,1,'C',0);
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

require 'conexion.php';
$consulta = "SELECT * FROM producto";
$resultado = $conexion->query($consulta);

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
while ($row = $resultado->fetch_assoc()){
    $pdf->Cell(25,10,$row['codigoProducto'],1,0,'C',0);
    $pdf->Cell(70,10,$row['nombreProducto'],1,0,'C',0);
    $pdf->Cell(20,10,$row['precioUnitario'],1,0,'C',0);
    $pdf->Cell(20,10,$row['cantidadProducto'],1,0,'C',0);
    $pdf->Cell(50,10,$row['fechaVencimiento'],1,1,'C',0);
}
$pdf->Output('F','reporte.pdf');
header('Content-type: application/pdf');
readfile('reporte.pdf');
?>