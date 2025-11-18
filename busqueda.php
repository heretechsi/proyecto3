<?php
//require_once("conexion.php");
require('config.php');


if (isset($_POST['libro']) && isset($_POST['nombre']) && isset($_POST['anho_inicio']) && isset($_POST['anho_fin'])) {
    $libro = $_POST['libro'];
    $nombre = $_POST['nombre'];
    $anho_i = $_POST['anho_inicio'];
    $anho_f = $_POST['anho_fin'];


    $query = "select libro, tipo, foja, numero, anho, comuna, comprador, vendedor from inscripciones where libro = '$libro' and (anho BETWEEN $anho_i AND $anho_f) and (comprador like '%$nombre%' OR vendedor LIKE '%nombre%');";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    

        
// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Verificar si hay resultados

echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Ingreso de Datos</title>
        <!-- Bootstrap CSS -->
        <link rel='stylesheet' href='styles.css'>
        <link rel='shortcut icon' href='./images/favicon.png' />
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='bg-light header_indice'>

        <div class='container my-4'>
            <div class='row'>";        
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                            <div class='col-md-6 col-lg-12 mb-4'>
                                <div class='card shadow-sm h-100'>
                                    <div class='card-header bg-success text-white'>
                                        Registro de {$row['libro']}
                                    </div>
                                    <div class='card-body'>
                                        <p class='card-text'><strong>Tipo:</strong> {$row['tipo']}</p>
                                        <p class='card-text'><strong>Foja:</strong> {$row['foja']}</p>
                                        <p class='card-text'><strong>Número:</strong> {$row['numero']}</p>
                                        <p class='card-text'><strong>Año:</strong> {$row['anho']}</p>
                                        <p class='card-text'><strong>Comuna:</strong> {$row['comuna']}</p>
                                        <p class='card-text'><strong>Comprador:</strong> {$row['comprador']}</p>
                                        <p class='card-text'><strong>Vendedor:</strong> {$row['vendedor']}</p>
                                        "?>
                                        <a href="index.php?
                                                    libro=<?= urlencode($row['libro']) ?>&
                                                    foja=<?= urlencode($row['foja']) ?>&
                                                    anho=<?= urlencode($row['anho']) ?>"
                                                class='btn btn-primary mt-2'>
                                                mirar imagen
                                        </a>
                                        <?php
                                        echo "
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    } else {
                        echo "
                            <div class='col-12'>
                                <div class='alert alert-warning text-center'>
                                    No se encontraron resultados.
                                </div>
                            </div>";
                        }
       
                echo "   
            </div>
            <div>
                <a href='indice.php'><button class='btn btn-primary mt-2'>realizar otra busqueda</button></a>
        </div>
    </body>
    " ;
    }else{
        echo "faltaron datos";
    }
?>

                                     