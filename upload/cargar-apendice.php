<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

// Incluye el archivo de configuración de la base de datos
include('../config.php');

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario
    $tipoRegistro = $_POST['tipoRegistro'];
    $ano = $_POST['anno'];
    $usuarioId = $_SESSION['user_id'];

    // Validar datos
    if (empty($tipoRegistro) || empty($ano) || empty($_FILES['miarchivo']['name'][0])) {
        echo "Por favor complete todos los campos y cargue al menos un archivo.";
        exit();
    }

    // Preparar la ruta de carga
    $uploadDir = "./Apendices/" . $tipoRegistro . "/" . $ano . "/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Maneja cada archivo cargado
    $fileCount = count($_FILES['miarchivo']['name']);
    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = $_FILES['miarchivo']['name'][$i];
        $tempName = $_FILES['miarchivo']['tmp_name'][$i];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // Cambia la lógica de nombres de archivos
        $incrementalNumber = str_pad($i + 1, 2, "0", STR_PAD_LEFT);
        $newFileName = "ap-" . str_pad($incrementalNumber, 2, "0", STR_PAD_LEFT) . "." . $fileExt;
        $filePath = $uploadDir . $newFileName;

        // Mueve el archivo al directorio de carga
        if (move_uploaded_file($tempName, $filePath)) {
            // Inserta la información en la base de datos
            $stmt = $conn->prepare("INSERT INTO apendices (tipo_registro, ano, ruta_imagen, usuario_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sisi", $tipoRegistro, $ano, $filePath, $usuarioId);
            
            if ($stmt->execute()) {
                echo "Archivo cargado y guardado en la base de datos: $newFileName<br>";
            } else {
                echo "Error al guardar en la base de datos: " . $stmt->error . "<br>";
            }
            $stmt->close();
        } else {
            echo "Error al cargar el archivo: $fileName<br>";
        }
    }
    
    $conn->close();
} else {
    echo "Solicitud no válida.";
}
?>
