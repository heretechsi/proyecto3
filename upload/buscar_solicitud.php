<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login/login.html");
    exit();
}

$año = date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BUSCAR SOLICITUD</title>
    
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="./images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <form name="form23" action="datos_solicitud.php" method="POST" class="card shadow p-4">
        <input type="hidden" name="arx" value="sig">

        <div class="form-group my-3">
            <label for="nombre" class="form-label fw-bold">Solicitud</label>
            <input class="form-control form-control-lg input_ing" type="text" name="solicitud" id="solicitud" placeholder="Ingrese Solicitud" required>
        </div>
        <div class="text-center">
            <button type="submit" name="btSubmit" class="btn btn-primary btn-lg px-5">
                Buscar
            </button>
        </div>
    </form>
</div>

			
</body>
