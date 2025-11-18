<?php
require('config.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login/login.html");
    exit();
}

$nombre         = $_SESSION['nombre'] ?? '';
$rut            = $_SESSION['rut'] ?? '';
$telefono       = $_SESSION['telefono'] ?? '';
$ciudad         = $_SESSION['ciudad'] ?? '';
$direccion      = $_SESSION['direccion'] ?? '';
$email          = $_SESSION['email'] ?? '';
$nombre_bol     = $_SESSION['nombre_bol'] ?? '';
$rut_bol        = $_SESSION['rut_bol'] ?? '';
$ciudad_bol     = $_SESSION['ciudad_bol'] ?? '';
$direccion_bol  = $_SESSION['direccion_bol'] ?? '';
$envio          = $_SESSION['envio'] ?? '';
$datos          = $_SESSION['datos'] ?? '';

if ($datos === 'datos') {
    $query =   "INSERT INTO solicitudes (nombre, rut, telefono, ciudad, direccion, email, nombre_boleta, rut_boleta, ciudad_boleta, direccion_boleta, tipo_envio)
                VALUES ('$nombre', '$rut', '$telefono', '$ciudad', '$direccion', '$email', '$nombre_bol', '$rut_bol', '$ciudad_bol', '$direccion_bol', '$envio')";

    if ($conn->query($query) === TRUE) {
    $ultimo_id = $conn->insert_id;
    }
}


$o = 0;

// 🔹 Insertar documentos
foreach ($_SESSION['documentos'] as $doc) {
    
    // Detectar si es tipo “solicitud” o “archivo” según las claves
    if (isset($doc['registro'])) {
        $tipo = "solicitud";
        $registro = $doc['registro'];
        $fojas = $doc['fojas'];
        $nro = $doc['nro'];
        $anio = $doc['anio'];
        $certificado = $doc['certificado'];
        $obs = $doc['observacion'];

        $query = "INSERT INTO solicitudes_detalles (libro, foja, numero, anio, certificado, observacion, solicitud)
                    VALUES ('$registro', '$fojas', '$nro', '$anio', '$certificado', '$obs', '$ultimo_id')";
        if ($conn->query($query) === TRUE) {
            $o++;
            
            } else {
            echo "Error al ingresar solicitud: " . $conn->error;
            }
    }
   
   
   
    /*      
        if (isset($doc['not_reg'])) {
        $tipo = "archivo";
        $registro = $doc['not_reg'];
        $nro = $doc['nro_rep'];
        $anio = $doc['anio_archivo'];
        $tomo = $doc['tomo'];
        $bimestre = $doc['bimestre'];
        $certificado = $doc['certificado_archivo'];
        $obs = $doc['observacion'];

        $query =   "INSERT INTO solicitudes_detalles (libro, numero, anio, tomo, bimestre, certificado, observacion, solicitud)
                    VALUES ('$registro', '$nro', '$anio', '$tomo', '$bimestre', '$certificado', '$ultimo_id')";
                    if ($conn->query($query) === TRUE) {
                    $o++;
                    } else {
                    echo "Error al ingresar solicitud: " . $conn->error;
                    }
        }
    */

}

// 🔹 Vaciar sesión de documentos
unset($_SESSION['documentos']);

// 🔹 Confirmación
echo "<div style='padding:20px; font-family:Arial'>
        <h2>✅ Solicitud registrada exitosamente</h2>
        <p>Se ingresaron los $o documentos requeridos en la solicitud $ultimo_id.</p>
        <a href='solicitudpdf.php' class='btn btn-success'>Ver Solicitud</a>
        <a href='index.php' class='btn btn-success'>Volver</a>
      </div>";

$conn->close();


?>


