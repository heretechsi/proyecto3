<?php
// index.php — Formulario dividido en secciones con Bootstrap (3 inputs por fila)
$enviado = false;
$datos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($_POST as $k => $v) {
    $datos[$k] = trim((string)$v);
  }
  $enviado = true; // Aquí podrías validar y guardar en DB
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formulario con secciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background-image: url('images/backgroundHome.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
</style>
</head>
<body>
<div class="container py-4">
  <div class="card shadow rounded-4">
    <div class="card-body p-4">
      <h1 class="h3 mb-4">Formulario de Solicitud</h1>

      <form method="post">
        <!-- Sección 1: Datos de solicitante -->
        <h4 class="mb-3">Datos de solicitante</h4>
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">RUT</label>
            <input type="text" class="form-control" name="rut" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Teléfono</label>
            <input type="tel" class="form-control" name="telefono" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Dirección</label>
            <input type="text" class="form-control" name="direccion" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Ciudad</label>
            <input type="text" class="form-control" name="ciudad" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Nombre Boleta</label>
            <input type="text" class="form-control" name="nombre_boleta" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">RUT Boleta</label>
            <input type="text" class="form-control" name="rut_boleta" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Ciudad Boleta</label>
            <input type="text" class="form-control" name="ciudad_boleta" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Dirección Boleta</label>
            <input type="text" class="form-control" name="direccion_boleta" required>
          </div>
        </div>

        <!-- Sección 2: Solicitud de documento -->
        <h4 class="mb-3">Solicitud de documento</h4>
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label class="form-label">Registro</label>
            <select class="form-select" name="registro" required>
              <option value="" selected disabled>Selecciona…</option>
              <option>Propiedad</option>
              <option>Hipoteca</option>
              <option>Prohibicion</option>
              <option>Agua</option>
              <option>Hipoteca Agua</option>
              <option>Prohibicion Agua</option>
              <option>Comercio</option>
              <option>Descubrimiento</option>
              <option>Minas</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Fojas</label>
            <input type="text" class="form-control" name="fojas" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Nro</label>
            <input type="text" class="form-control" name="nro" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Año</label>
            <input type="text" class="form-control" name="anio" required>
          </div>
          <div class="col-md-8">
            <label class="form-label">Certificado</label>
            <select class="form-select" name="certificado" required>
              <option value="" selected disabled>Selecciona…</option>
              <option>Copia autorizada</option>
              <option>Copia con vigencia</option>
              <option>Certificado de hipotecas y gravámenes (GP) a 30</option>
              <option>Certificado de hipotecas y gravámenes (GP) a 20</option>
              <option>Certificado de hipotecas y gravámenes (GP) a 10 años</option>
              <option>Certificado de Prenda Agraria</option>
              <option>Certificado de Prenda Industrial</option>
              <option>Certificado de Bien Familiar</option>
              <option>Certificado de Litigios</option>
              <option>Carpeta Inmobiliaria</option>
              <option>Certificado de Vigencia de Sociedad (Incluye Copia Autorizada)</option>
              <option>Certificado de Capital de Sociedad</option>
              <option>Certificado de Representante Legal</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label">Observación</label>
            <textarea class="form-control" name="observacion" rows="3"></textarea>
          </div>
        </div>

        <!-- Sección 3: Archivo -->
        <h4 class="mb-3">Archivo</h4>
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label class="form-label">Nro o Rep</label>
            <input type="text" class="form-control" name="nro_rep" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Año</label>
            <input type="text" class="form-control" name="anio_archivo" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Tomo</label>
            <input type="text" class="form-control" name="tomo" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Bimestre</label>
            <input type="number" class="form-control" name="bimestre" value="1" required>
          </div>
          <div class="col-md-8">
            <label class="form-label">Certificado</label>
            <select class="form-select" name="certificado_archivo" required>
              <option value="" selected disabled>Selecciona…</option>
              <option>Copia autorizada</option>
              <option>Vigencia</option>
              <option>Agregado</option>
              <option>Copia condominio</option>
            </select>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
