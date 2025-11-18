<?php
//require_once("conexion.php");
require('config.php');



if (isset($_POST['Libro']) && isset($_POST['Tipo']) && isset($_POST['Foja']) && isset($_POST['Numero']) && isset($_POST['Anho']) && isset($_POST['Comuna']) && isset($_POST['Comprador']) && isset($_POST['Vendedor'])) {
    $libro = $_POST['Libro'];
    $tipo = $_POST['Tipo'];
    $foja = $_POST['Foja'];
    $numero = $_POST['Numero'];
    $anho = $_POST['Anho'];
    $comuna = $_POST['Comuna'];
    $comprador = $_POST['Comprador'];
    $vendedor = $_POST['Vendedor'];


    $query = "INSERT INTO inscripciones (libro, tipo, foja, numero, anho, comuna, comprador, vendedor) VALUES ('$libro', '$tipo', '$foja', '$numero', '$anho', '$comuna', '$comprador', '$vendedor')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    if ($libro !="") {
        sleep(1);
        header("Location: ing_ind.php");
    } else {
        echo "Error al guardar el registro.";
    }
} else {
    echo "Faltan datos.";
}
?>
