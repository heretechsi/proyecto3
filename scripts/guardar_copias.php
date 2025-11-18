<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $targetDir = "../copias/";
    $targetFile = $targetDir . basename($_FILES['pdf']['name']);

    // Asegúrate de que la carpeta exista y tenga permisos de escritura
    if (move_uploaded_file($_FILES['pdf']['tmp_name'], $targetFile)) {
        echo "El archivo ". htmlspecialchars(basename($_FILES['pdf']['name'])). " ha sido guardado.";
    } else {
        echo "Lo siento, ha habido un error al guardar su archivo.";
    }
} else {
    echo "No se ha recibido ningún archivo.";
}
?>
