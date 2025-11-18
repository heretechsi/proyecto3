<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determinar la acción (cargar o eliminar)
    $action = $_POST['action'] ?? '';

    // Datos comunes
    $foja = $_POST['foja'] ?? '';            // Número de foja proporcionado por el usuario
    $tipoImagen = $_POST['tipo_imagen'] ?? ''; // bis, bisv, bis2, etc.
    $ano = $_POST['ano'] ?? '';               // Año proporcionado en el formulario
    $registro = $_POST['registro'] ?? '';     // Tipo de registro proporcionado
    $uploadDir = "$registro/$ano/";           // Carpeta destino

    // Asignar sufijo basado en el tipo de imagen
    $sufijos = [
        "bis" => ".3",
        "bisv" => ".4",
        "bis2" => ".5",
        "bis2v" => ".6",
        "bis3" => ".7",
        "bis3v" => ".8",
    ];
    $sufijo = $sufijos[$tipoImagen] ?? null;

    if ($action === 'upload') {
        // *** Lógica para cargar imagen ***
        if (!$foja || !$tipoImagen) {
            die('Error: Faltan datos obligatorios (No. Foja o Tipo de Imagen).');
        }

        // Validar y crear el directorio si no existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Verificar si el tipo de imagen es válido
        if (!$sufijo) {
            die('Error: Tipo de imagen no válido.');
        }

        // Verificar si hay un archivo cargado
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            die('Error: NO SE CARGÓ ningún archivo o hubo un error en la carga.');
        }

        $archivoTmp = $_FILES['imagen']['tmp_name'];
        $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

        // Verificar que sea una imagen
        $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
        if (!in_array($extension, $extensionesPermitidas)) {
            die('Error: Solo se permiten archivos JPG, JPEG o PNG.');
        }

        // Construir el nombre final del archivo
        $nombreFinal = $foja . $sufijo . '.' . $extension;
        $rutaFinal = $uploadDir . $nombreFinal;

        // Mover el archivo al directorio destino
        if (move_uploaded_file($archivoTmp, $rutaFinal)) {
            echo "La imagen SE CARGÓ CORRECTAMENTE como $rutaFinal.";
        } else {
            echo "Error: NO SE PUDO ELIMINAR LA IMAGEN.";
        }
    } elseif ($action === 'delete') {
        // *** Lógica para eliminar imagen ***
        if (!$foja || !$tipoImagen) {
            echo "NO SE PUDO ELIMINAR LA IMAGEN. Revisar si los parámetros son correctos o la imagen realmente existe.";
            exit();
        }

        // Verificar si el tipo de imagen es válido
        if (!$sufijo) {
            echo "NO SE PUDO ELIMINAR LA IMAGEN. Revisar si los parámetros son correctos o la imagen realmente existe.";
            exit();
        }

        // Construir el nombre del archivo
        $rutaArchivo = $uploadDir . $foja . $sufijo . '.*';
        $encontrado = false;

        // Buscar y eliminar archivos que coincidan con el patrón
        foreach (glob($rutaArchivo) as $archivo) {
            $encontrado = true;
            if (unlink($archivo)) {
                echo "La imagen $archivo fue ELIMINADA CORRECTAMENTE.";
            } else {
                echo "Error: No se pudo eliminar la imagen $archivo.";
            }
        }

        // Si no se encontró ningún archivo, mostrar el mensaje genérico
        if (!$encontrado) {
            echo "NO SE PUDO ELIMINAR LA IMAGEN. Revisar si los parámetros son correctos o la imagen realmente existe.";
        }
    } else {
        echo "Error: Acción no válida.";
    }
} else {
    echo "Método no permitido.";
}
?>
