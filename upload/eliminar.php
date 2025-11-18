<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

include('../config.php');

if (isset($_POST['annoEliminar']) && isset($_POST['tipoRegistroEliminar']) && isset($_POST['fojaInicialEliminar']) && isset($_POST['fojaFinalEliminar'])) {
    $anno = $_POST['annoEliminar'];
    $tipoRegistro = $_POST['tipoRegistroEliminar'];
    $fojaInicial = $_POST['fojaInicialEliminar'];
    $fojaFinal = $_POST['fojaFinalEliminar'];

    // Verifica si el año es válido
    if (is_numeric($anno) && strlen($anno) === 4) {
        $carpeta = $tipoRegistro . '/' . $anno . '/'; // Carpeta de destino basada en el tipo de registro y el año

        // Determinar si las fojas inicial y final son vueltas
        $isVueltaInicial = strpos($fojaInicial, 'v') !== false;
        $isVueltaFinal = strpos($fojaFinal, 'v') !== false;

        // Obtener el número de foja inicial y final
        $fojaInicialNumero = intval($fojaInicial);
        $fojaFinalNumero = intval($fojaFinal);

        // Ajustar la subfoja inicial y final
        $subfojaInicial = $isVueltaInicial ? 2 : 1;
        $subfojaFinal = $isVueltaFinal ? 2 : 1;

        // Bucle para eliminar las imágenes del rango especificado
        for ($fojaActual = $fojaInicialNumero; $fojaActual <= $fojaFinalNumero; $fojaActual++) {
            for ($subfoja = ($fojaActual == $fojaInicialNumero) ? $subfojaInicial : 1; $subfoja <= 2; $subfoja++) {
                if ($fojaActual == $fojaFinalNumero && $subfoja > $subfojaFinal) {
                    break;
                }

                $archivo = $carpeta . $fojaActual . '.' . $subfoja . '.jpg'; // Asumiendo que la extensión es .jpg, ajustar según sea necesario
                if (file_exists($archivo)) {
                    unlink($archivo);
                }

                // También eliminar de la base de datos
                $query = "DELETE FROM fojas WHERE tipo_registro = ? AND ano = ? AND foja = ? AND subfoja = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sidi", $tipoRegistro, $anno, $fojaActual, $subfoja);
                $stmt->execute();
            }
        }

        echo "Fojas eliminadas correctamente.";
    } else {
        echo "El año ingresado no es válido.";
    }
} else {
    echo "Datos incompletos.";
}
?>
