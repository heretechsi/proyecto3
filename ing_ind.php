<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login/login.html");
    exit();
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso de Datos</title>
    <!-- Bootstrap CSS -->
   <style>
body {
  background-image: url('images/backgroundHome.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
</style>
    <link rel="shortcut icon" href="./images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-6">
    <h1 class="mb-4 text-center text-white">Ingreso de Datos</h1>

    <div class="row">
        

        <!-- Ingresar Manual -->
        <div class="col-md-6"> 
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            Ingresar un solo registro
        </div>
        <div class="card-body">
            <form action="registrar.php" method="post">
                <div class="row">
                    <?php
                    $campos = ['Libro', 'Tipo', 'Foja', 'Numero', 'Anho', 'Comuna', 'Comprador', 'Vendedor'];
                    foreach ($campos as $campo) {
                        $campo1 = ($campo == "Anho") ? "Año" : $campo;
                        echo "<div class='col-6'>";  // cada input ocupa media fila
                        echo "<label>$campo1:</label>";
                        echo "<input type=\"text\" name=\"$campo\" id=\"$campo\" class=\"form-control input_ing\" style='border: 1px solid black;' required>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <button type="submit" class="btn btn-success">Guardar Registro</button>
            </form>
        </div>
    </div>
</div>

<br><br><br>
<!-- Subir CSV -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Subir archivo Excel o CSV
                </div>
                <div class="card-body">
                    <form action="procesar.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="archivo_csv" class="form-label">Selecciona el archivo</label>
                            <input type="file" name="archivo_csv" id="archivo_csv"  class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
