<?php
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        // Título principal
        $numeroSolicitud = $_POST['nro'] ?? '';
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'SOLICITUD : ',0,1,'C');
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,"CONSERVADOR DE BIENES RAICES , Pagina". $this->PageNo(),0,1,'C');
        
    }
}

// Datos dinámicos
$numeroSolicitud = $_POST['nro'] ?? '';
$NOMBRE   = $_POST['nombre'] ?? '';
$dir      = $_POST['direccion'] ?? '';
$COMUNA   = $_POST["comuna"] ?? '';
$rut       = $_POST['rut'] ?? '';
$direccion = mb_convert_encoding($dir, 'ISO-8859-1', 'UTF-8');
$comuna    = $_POST['comuna'] ?? '';
$telefono  = $_POST['telefono'] ?? '';
$palabra1 =mb_convert_encoding('DIRECCIÓN', 'ISO-8859-1', 'UTF-8');
$detalle1 = ["vigencia","Propiedad","24-20-2020","$15300"];
$detalle2 = ["copia","Hipoteca","23V-20-2015","$7000"];
$total    = "$12300";

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Número de solicitud
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,$numeroSolicitud,0,1,'C');
$pdf->Ln(5);

// =====================
// Cuadro DATOS BOLETA
// =====================
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DATOS BOLETA",1,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(40,8,"Nombre:",1,0);
$pdf->Cell(0,8,$NOMBRE,1,1);

$pdf->Cell(40,8,"Direccion:",1,0);
$pdf->Cell(0,8,$direccion,1,1);

$pdf->Cell(40,8,"Comuna:",1,0);
$pdf->Cell(0,8,$COMUNA,1,1);

// =====================
// Cuadro DETALLES
// =====================
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"DETALLES",1,1,'C');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,8,"registro",1,0,'C');
$pdf->Cell(40,8,"tipo",1,0,'C');
$pdf->Cell(40,8,"datos",1,0,'C');
$pdf->Cell(70,8,"Monto",1,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(40,8,$detalle1[0],1,0,'C');
$pdf->Cell(40,8,$detalle1[1],1,0,'C');
$pdf->Cell(40,8,$detalle1[2],1,0,'C');
$pdf->Cell(70,8,$detalle1[3],1,1,'C');

$pdf->Cell(40,8,$detalle2[0],1,0,'C');
$pdf->Cell(40,8,$detalle2[1],1,0,'C');
$pdf->Cell(40,8,$detalle2[2],1,0,'C');
$pdf->Cell(70,8,$detalle2[3],1,1,'C');

// Total
$pdf->SetFont('Arial','B',12);
$pdf->Cell(120,8,"TOTAL",1,0,'R');
$pdf->Cell(70,8,$total,1,1,'C');

// =====================
// Cuadro ANOTACIONES

// =====================
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"ANOTACIONES",1,1,'C');

// Espacio en blanco para escribir
for($i=0; $i<5; $i++) {
    $pdf->Cell(0,8,"",1,1);
}

// =====================
// Firma
// =====================
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);


$pdf->Output();
?>
