<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

include('../config.php');

if (isset($_POST['anno']) && isset($_POST['tipoRegistro']) && isset($_POST['fojaInicial'])) {
    $anno = $_POST['anno'];
    $tipoRegistro = $_POST['tipoRegistro'];
    $fojaInicial = $_POST['fojaInicial'];

    // Verifica si el año es válido 
    if (is_numeric($anno) && strlen($anno) === 4) {
        $carpeta = $tipoRegistro . '/' . $anno . '/'; // Carpeta de destino basada en el tipo de registro y el año
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true) or die("Hubo un error al crear el directorio de almacenamiento");
        }

        $cantidadArchivosCargados = 0; // Variable para contar archivos cargados

        // Determinar si la foja inicial es frente (X.1) o vuelta (X.2)
        $isVuelta = strpos($fojaInicial, 'v') !== false;

        // Obtener el número de foja inicial y subfoja
        if ($isVuelta) {
            $fojaActual = intval($fojaInicial);
            $subfoja = 2; // Empieza en vuelta
        } else {
            $fojaActual = intval($fojaInicial);
            $subfoja = 1; // Empieza en frente
        }

        foreach ($_FILES["miarchivo"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $nombreArchivo = $_FILES["miarchivo"]["name"][$key];
                $fuente = $_FILES["miarchivo"]["tmp_name"][$key];

                // Renombrar la imagen
                $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                $nuevoNombre = $fojaActual . '.' . $subfoja . '.' . $extension;
                $target_path = $carpeta . $nuevoNombre;

                if (move_uploaded_file($fuente, $target_path)) {
                    $cantidadArchivosCargados++;

                    // Obtener fecha y hora actual
                    $fechaCarga = date("Y-m-d H:i:s");
                    $usuarioId = $_SESSION['user_id'];
                    $rutaImagen = $target_path;

                    // Insertar información en la base de datos
                    $query = "INSERT INTO fojas (tipo_registro, ano, foja, subfoja, ruta_imagen, usuario_id, fecha_carga) 
                              VALUES (?, ?, ?, ?, ?, ?, NOW())";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sidssi", $tipoRegistro, $anno, $fojaActual, $subfoja, $rutaImagen, $usuarioId);

                    if ($stmt->execute()) {
                        // Éxito en la inserción
                    } else {
                        // Manejar el error si la inserción falla
                        echo "Error al insertar datos: " . $conn->error;
                    }

                    // Ajustar la foja y subfoja para la próxima imagen
                    if ($subfoja == 1) {
                        $subfoja = 2;
                    } else {
                        $subfoja = 1;
                        $fojaActual++;
                    }
                }
            }
        }

        if ($cantidadArchivosCargados > 0) {
            // Redireccionar a la página de carga exitosa con la cantidad de archivos cargados
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "cargado.html?anno=' . $anno . '&tipoRegistro=' . $tipoRegistro . '&foja=' . $fojaInicial . '&cantidad=' . $cantidadArchivosCargados . '";
                    }, 100);
                  </script>';
        } else {
            echo "No se han cargado archivos o ha ocurrido un error.";
        }
    } else {
        echo "El año ingresado no es válido.";
    }
} else {
    echo "No se ha proporcionado un año, tipo de registro o foja inicial.";
}
?>
