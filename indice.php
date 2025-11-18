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
    <title>Ingreso de Datos</title>
    <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="./images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <form name="form23" action="busqueda.php" method="POST" class="card shadow p-4">
        <input type="hidden" name="arx" value="sig">

        <!-- Selector de Registro -->
        <div class="form-group">
            <label for="libro" class="form-label fw-bold">Registro</label>
            <select class="form-select input_ing" name="libro" id="libro">
                <option value="Propiedad">Propiedad</option>
                <option value="Hipoteca">Hipoteca</option>
				<option value="Prohibicion">Prohibición</option>
				<option value="Agua">Agua</option>
				<option value="Descubrimiento">Descubrimiento</option>
				<option value="Minas">Minas</option>
				<option value="Comercio">Comercio</option>
            </select>
        </div>

        <!-- Nombre -->
        <div class="form-group my-3">
            <label for="nombre" class="form-label fw-bold">Nombre</label>
            <input class="form-control form-control-lg input_ing" type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre" required>
        </div>

        <!-- Años -->
        <div class="row my-1">
            <div class="col-md-6">
                <label for="anho_inicio" class="form-label fw-bold">Desde</label>
                <input type="text" class="form-control input_ing" name="anho_inicio" id="anho_inicio" maxlength="4" value="1980" required>
            </div>
            <div class="col-md-6">
                <label for="anho_fin" class="form-label fw-bold">Hasta</label>
                <input type="text" class="form-control input_ing" name="anho_fin" id="anho_fin" maxlength="4" value="<?php echo $año; ?>" required>
            </div>
        </div>
        <!-- Botón -->
        <div class="text-center">
            <button type="submit" name="btSubmit" class="btn btn-primary btn-lg px-5">
                Buscar
            </button>
        </div>
    </form>
</div>

			
</body>
