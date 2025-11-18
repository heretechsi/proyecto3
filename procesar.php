<?php

require('config.php');
$tipo       = $_FILES['archivo_csv']['type'];
$tamanio    = $_FILES['archivo_csv']['size'];
$archivotmp = $_FILES['archivo_csv']['tmp_name'];
$lineas     = file($archivotmp);

$i = 0;

foreach ($lineas as $linea) {
    $cantidad_registros         = count($lineas);
    $cantidad_regist_agregados  = ($cantidad_registros - 1);

    if ($i != 0) {
        $datos = explode(",", $linea);

        
        $col1  = !empty($datos[0]) ? ($datos[0]) : '';
        $col2  = !empty($datos[1]) ? ($datos[1]) : '';
        $col3  = !empty($datos[2]) ? ($datos[2]) : '';
        $col4  = !empty($datos[3]) ? ($datos[3]) : '';
        $col5  = !empty($datos[4]) ? ($datos[4]) : '';
        $col6  = !empty($datos[5]) ? ($datos[5]) : '';
        $col7  = !empty($datos[6]) ? ($datos[6]) : '';
        $col8  = !empty($datos[7]) ? ($datos[7]) : '';

        
        $query = "INSERT INTO inscripciones (libro, tipo, foja, numero, anho, comuna, comprador, vendedor) VALUES ('$col1', '$col2', '$col3', '$col4', '$col5', '$col6', '$col7', '$col8')";
        mysqli_query($conn, $query) or die(mysqli_error($con));
        
    }
    $i++;
}
sleep(1);
header("Location: ing_ind.php");
?>

