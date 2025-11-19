<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

require 'config.php';

$id_certificado = isset($_POST['id_certificado']) ? intval($_POST['id_certificado']) : 0;
$pdfData = isset($_FILES['pdf']) ? file_get_contents($_FILES['pdf']['tmp_name']) : null;

if (!$id_certificado || !$pdfData) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit();
}

$mm = date('m');
$aa = date('y');
$tableName = "solicitud_{$mm}_{$aa}";

$sqlCreate = "CREATE TABLE IF NOT EXISTS `{$tableName}` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_certificado` INT NOT NULL,
    `data` LONGBLOB NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME DEFAULT NULL
)";
if (!$conn->query($sqlCreate)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al crear tabla: ' . $conn->error]);
    exit();
}

$createdAt = date('Y-m-d H:i:s');

// LA CLAVE ESTÁ AQUÍ:
$sql = "INSERT INTO `{$tableName}` (`id_certificado`, `data`, `created_at`) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error en preparación de sentencia: ' . $conn->error]);
    exit();
}

// Aquí vamos a usar 'isb' y pasar la variable de blob, NO null ni send_long_data
$stmt->bind_param('isb', $id_certificado, $pdfData, $createdAt);

// Ejecutar la inserción
if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'PDF guardado exitosamente en tabla ' . $tableName,
        'table' => $tableName,
        'id_certificado' => $id_certificado
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al guardar el PDF: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
