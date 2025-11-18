
<?php
require('fpdf/fpdf.php'); // recuerda tener FPDF en tu proyecto

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login/login.html");
    exit();
}



class PDF extends FPDF
{
    function Header()
    {
        // Logo (ajusta ruta a tu logo)
        $this->Image('upload/images/favicon.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'SOLICITUD', 0, 0, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $palabra2 =mb_convert_encoding('Raíces', 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 10,"Conservador de Bienes $palabra2 - Datos de contacto", 0, 0, 'C');
    }
}
 
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// --- Datos que vienen del formulario ---
$nro       = $_POST['nro'] ?? '';
$nombre    = $_POST['nombre'] ?? '';
$rut       = $_POST['rut'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$comuna    = $_POST['comuna'] ?? '';
$telefono  = $_POST['telefono'] ?? '';
$palabra1 =mb_convert_encoding('DIRECCIÓN', 'ISO-8859-1', 'UTF-8');

$direc=mb_convert_encoding($direccion, 'ISO-8859-1', 'UTF-8');


// Imprimir datos principales
$pdf->Cell(0, 10, "NRO: $nro", 0, 1);
$pdf->Cell(0, 10, "NOMBRE: $nombre", 0, 1);
$pdf->Cell(0, 10, "RUT: $rut", 0, 1);


$pdf->Cell(0, 10, "$palabra1: $direc", 0, 1);
$pdf->Cell(0, 10, "COMUNA: $comuna", 0, 1);
$pdf->Cell(0, 10, "TELEFONO: $telefono", 0, 1);
$pdf->Ln(5);

// --- Documentos solicitados ---
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, "Documento", 1);
$pdf->Cell(40, 10, "Detalle", 1);
$pdf->Cell(40, 10, "Monto", 1, 1);

$pdf->SetFont('Arial', '', 12);

$total = 0;
if (isset($_POST['documento']) && is_array($_POST['documento'])) {
    foreach ($_POST['documento'] as $i => $doc) {
        $detalle = $_POST['detalle'][$i] ?? '';
        $monto   = $_POST['monto'][$i] ?? 0;

        $pdf->Cell(100, 10, utf8_decode($doc), 1);
        $pdf->Cell(40, 10, utf8_decode($detalle), 1);
        $pdf->Cell(40, 10, number_format($monto, 0, ',', '.'), 1, 1, 'R');

        $total += (int)$monto;
    }
}

// --- Total ---
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 10, "TOTAL", 1);
$pdf->Cell(40, 10, number_format($total, 0, ',', '.'), 1, 1, 'R');

$pdf->Output();