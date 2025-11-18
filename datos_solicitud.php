<?php

require('config.php');


if (isset($_POST['solicitud'])) {
    $solicitud = $_POST['solicitud'];
    


    $query = "select * from solicitudes_detalles where solicitud = $solicitud";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    

        

$result = mysqli_query($conn, $query) or die(mysqli_error($conn));



echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Ingreso de Datos</title>
        <!-- Bootstrap CSS -->
        
        <link rel='shortcut icon' href='./images/favicon.png' />
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
            <style>
                body {
                background-image: url('images/backgroundHome.jpg');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                }
            </style>
    </head>
    <body class='bg-light header_indice'>

        <div class='container my-4'>
            <div class='row'>
            <div class='col-md-6 col-lg-12 mb-4'>
            <div class='card-header bg-success text-white'>
                                    <h3>Solicitud Nro $solicitud</h3>
                                    </div>";
                
                    
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                            <div class='col-md-6 col-lg-12 mb-4'>
                                <div class='card shadow-sm h-100'>
                                    
                                    <div class='card-body'>
                                        <p class='card-text'><strong>registo de {$row['libro']} - ";
                                        if (($row['tomo'] ?? '') && ($row['bimestre'] ?? '')) {
                                            echo "Tomo {$row['tomo']} - ";
                                            echo "Bimestre {$row['bimestre']} - ";
                                        }
                                        echo "foja {$row['foja']} - nro {$row['numero']} - año {$row['anio']} - {$row['certificado']} </strong>
                                      
                                        
                                        <p class='card-text'>Obs: {$row['observacion']}</p>
                                       
                                        
                                        ";
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
                <a href='buscar_solicitud.php'><button class='btn btn-primary mt-2'>realizar otra busqueda</button></a>
            </div>
        </div>
    </body>
    " ;
    }else{
        echo "faltaron datos";
    }
?>
