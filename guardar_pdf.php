<?php
// ============================================================================
// GUARDAR PDF EN BASE DE DATOS - TABLA DINÁMICA solicitud_mm_aa
// ============================================================================

session_start();
header('Content-Type: application/json; charset=utf-8');

// Validar sesión del usuario
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

// Incluir configuración de base de datos
require 'config.php';

// Obtener datos del POST
$id_certificado = isset($_POST['id_certificado']) ? intval($_POST['id_certificado']) : 0;
$pdfData = isset($_FILES['pdf']) ? file_get_contents($_FILES['pdf']['tmp_name']) : null;

// Validar que los datos no estén vacíos
if (!$id_certificado || !$pdfData) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit();
}

// Obtener mes y año actual
$mm = date('m');
$aa = date('y');
$tableName = "solicitud_{$mm}_{$aa}";

// SQL para crear la tabla dinámica si no existe
$sqlCreate = "CREATE TABLE IF NOT EXISTS `{$tableName}` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_certificado` INT NOT NULL,
    `data` LONGBLOB NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME DEFAULT NULL
)";

// Ejecutar creación de tabla
if (!$conn->query($sqlCreate)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al crear tabla: ' . $conn->error]);
    exit();
}

// Preparar la fecha actual
$createdAt = date('Y-m-d H:i:s');

// SQL para insertar el registro
$sql = "INSERT INTO `{$tableName}` (`id_certificado`, `data`, `created_at`) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Validar que la sentencia se preparó correctamente
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error en preparación de sentencia: ' . $conn->error]);
    exit();
}

// Vincular parámetros (i = integer, s = string)
$stmt->bind_param('iss', $id_certificado, $pdfData, $createdAt);

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

// Cerrar conexiones
$stmt->close();
$conn->close();
?>