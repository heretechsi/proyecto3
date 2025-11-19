<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['existe' => false, 'error' => 'No autorizado']);
    exit();
}

header('Content-Type: application/json');

require 'config.php';

$numeroSolicitud = isset($_POST['numeroSolicitud']) ? intval($_POST['numeroSolicitud']) : null;

if (!$numeroSolicitud) {
    echo json_encode(['existe' => false, 'error' => 'Número de solicitud inválido']);
    exit();
}

// Consulta para verificar si existe el ID en la tabla solicitudes
$sql = "SELECT id FROM solicitudes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $numeroSolicitud);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['existe' => true]);
} else {
    echo json_encode(['existe' => false, 'error' => 'La solicitud no existe']);
}

$stmt->close();
$conn->close();
?>
