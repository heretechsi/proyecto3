<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login/login.html");
    exit();
}

if (!isset($_SESSION['documentos'])) {
  $_SESSION['documentos'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['accion2'])) {
    if($_POST['accion2'] === 'datos'){


              $_SESSION['nombre'] = $_POST['nombre'];
              $_SESSION['rut'] = $_POST['rut'];
              $_SESSION['telefono'] = $_POST['telefono'];
              $_SESSION['direccion'] = $_POST['direccion'];
              $_SESSION['ciudad'] = $_POST['ciudad'];
              $_SESSION['email'] = $_POST['email'];
              $_SESSION['nombre_bol'] = $_POST['nombre_boleta'];
              $_SESSION['rut_bol'] = $_POST['rut_boleta'];
              $_SESSION['direccion_bol'] = $_POST['direccion_boleta'];
              $_SESSION['ciudad_bol'] = $_POST['ciudad_boleta'];
              $_SESSION['envio'] = $_POST['envio'];
              $_SESSION['datos'] = $_POST['accion2'];
          
    }
  }
  if (isset($_POST['accion'])) {

    
   
    if ($_POST['accion'] === 'solicitud') {
      $certificados = $_POST['certificado'] ?? [];
      if (!empty($certificados)) {
        foreach ($certificados as $cert) {
          $_SESSION['documentos'][] = [
            'registro' => $_POST['registro'] ?? '',
            'fojas' => $_POST['fojas'] ?? '',
            'nro' => $_POST['nro'] ?? '',
            'anio' => $_POST['anio'] ?? '',
            'certificado' => $cert,
            'observacion' => $_POST['observacion'] ?? ''
          ];
        }
      }
    }

    //  --- Sección Archivo ---
    if ($_POST['accion'] === 'archivo') {
      $certificadosArchivo = $_POST['certificado_archivo'] ?? [];
      if (!empty($certificadosArchivo)) {
        foreach ($certificadosArchivo as $cert) {
          $_SESSION['documentos'][] = [
            'not_reg' => $_POST['notaria'] ?? '',
            'nro_rep' => $_POST['nro_rep'] ?? '',
            'anio_archivo' => $_POST['anio_archivo'] ?? '',
            'tomo' => $_POST['tomo'] ?? '',
            'bimestre' => $_POST['bimestre'] ?? '',
            'certificado_archivo' => $cert,
            'observacion' => $_POST['observacion'] ?? ''
          ];
        }
      }
    }

    //  --- Borrar documento ---
    if ($_POST['accion'] === 'borrar' && isset($_POST['index'])) {
      $index = (int)$_POST['index'];
      if (isset($_SESSION['documentos'][$index])) {
        unset($_SESSION['documentos'][$index]);
        $_SESSION['documentos'] = array_values($_SESSION['documentos']);
      }
    }
  }
}else{
  $_SESSION['nombre'] = "";
$_SESSION['rut'] = "";
$_SESSION['telefono'] = "";
$_SESSION['direccion'] = "";
$_SESSION['ciudad'] = "";
$_SESSION['email'] = "";
$_SESSION['nombre_bol'] = "";
$_SESSION['rut_bol'] = "";
$_SESSION['direccion_bol'] = "";
$_SESSION['ciudad_bol'] = "";
$_SESSION['envio'] = "";
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
    .titulo-seccion {
      background-color: #198754;
      color: #fff;
      padding: 10px;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
<div class="container py-4">
  <div class="card shadow rounded-4 mb-4">
    <div class="card-body p-4">
      <h1 class="h3 mb-4">Formulario de Solicitud</h1>

      <!-- Sección 1: Datos de solicitante -->
       <form method="post">
      <h4 class="titulo-seccion">Datos de solicitante</h4>
      <div class="row g-3 mb-3">
        <input type="hidden" name="accion2" value="datos">
        <div class="col-md-4"><label class="form-label">Nombre</label><input type="text" class="form-control" name="nombre" value= "<?php echo $_SESSION['nombre'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">RUT</label><input type="text" class="form-control" name="rut" value= "<?php echo $_SESSION['rut'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">Teléfono</label><input type="tel" class="form-control" name="telefono" value= "<?php echo $_SESSION['telefono'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">Ciudad</label><input type="text" class="form-control" name="ciudad" value= "<?php echo $_SESSION['ciudad'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">Dirección</label><input type="text" class="form-control" name="direccion" value= "<?php echo $_SESSION['direccion'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value= "<?php echo $_SESSION['email'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">Nombre Boleta</label><input type="text" class="form-control" name="nombre_boleta" value= "<?php echo $_SESSION['nombre_bol'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">RUT Boleta</label><input type="text" class="form-control" name="rut_boleta" value= "<?php echo $_SESSION['rut_bol'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">Ciudad Boleta</label><input type="text" class="form-control" name="ciudad_boleta" value= "<?php echo $_SESSION['ciudad_bol'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">Dirección Boleta</label><input type="text" class="form-control" name="direccion_boleta" value= "<?php echo $_SESSION['direccion_bol'] ?>" required></div>
        <div class="col-md-4"><label class="form-label">Tipo de Envio</label><select class="form-select" name="envio" required>
              <option value= "<?php $_SESSION['envio'] ?>" selected disabled>Selecciona…</option>
              <option>chile express</option>
              <option>retiro en sucursal</option>
              <option>envio electronico</option>
              <option>envio whatsapps</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">guardar datos</button>
      </form>
      </div>
    </div>
  </div>

  <!-- Sección 2: Solicitud de documento -->
  <div class="card shadow rounded-4 mb-4">
    <div class="card-body p-4">
      <h4 class="titulo-seccion">Solicitud de documento</h4>
      <form method="post">
        <input type="hidden" name="accion" value="solicitud">
          <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label">Fojas</label><input type="text" class="form-control" name="fojas" required></div>
            <div class="col-md-6"><label class="form-label">Nro</label><input type="text" class="form-control" name="nro" required></div>
            <div class="col-md-6"><label class="form-label">Año</label><input type="text" class="form-control" name="anio" required></div>            
            <div class="col-md-6">
              <label class="form-label">Registro</label>
              <select class="form-select" name="registro" required>
                <option value="" selected disabled>Selecciona…</option>
                <option>Propiedad</option><option>Hipoteca</option><option>Prohibicion</option>
                <option>Agua</option><option>Hipoteca Agua</option><option>Prohibicion Agua</option>
                <option>Comercio</option><option>Descubrimiento</option><option>Minas</option>
              </select>
            </div>  
            <div class="col-md-12">  
              <label class="form-label d-block">Certificados</label>
              <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                <?php
                $certificados = [
                  "Copia autorizada",
                  "Copia con vigencia",
                  "Certificado de hipotecas y gravámenes (GP) a 30",
                  "Certificado de hipotecas y gravámenes (GP) a 20",
                  "Certificado de hipotecas y gravámenes (GP) a 10 años",
                  "Certificado de Prenda Agraria",
                  "Certificado de Prenda Industrial",
                  "Certificado de Bien Familiar",
                  "Certificado de Litigios",
                  "Carpeta Inmobiliaria",
                  "Certificado de Vigencia de Sociedad (Incluye Copia Autorizada)",
                  "Certificado de Capital de Sociedad",
                  "Certificado de Representante Legal"
                ];
                foreach ($certificados as $cert) {
                  echo '<div class="form-check">
                          <input class="form-check-input" type="checkbox" name="certificado[]" value="' . htmlspecialchars($cert) . '" id="' . md5($cert) . '">
                          <label class="form-check-label" for="' . md5($cert) . '">' . htmlspecialchars($cert) . '</label>
                        </div>';
                }
                ?>
              </div>
          </div>
          <div class="col-12"><label class="form-label">Observación</label><textarea class="form-control" name="observacion" rows="3"></textarea></div>
        </div>
        <button type="submit" class="btn btn-primary">Agregar solicitud</button>
      </form>
    </div>
  </div>

  <!-- Sección 3: Archivo -->
  <div class="card shadow rounded-4 mb-4">
    <div class="card-body p-4">
      <h4 class="titulo-seccion">Archivo</h4>
      <form method="post">
        <input type="hidden" name="accion" value="archivo">
        <div class="row g-3 mb-3">
          <div class="col-md-4"><label class="form-label">Notaría o Registro</label><input type="text" class="form-control" name="notaria" required></div>
          <div class="col-md-4"><label class="form-label">Nro o Rep</label><input type="text" class="form-control" name="nro_rep" required></div>
          <div class="col-md-4"><label class="form-label">Año</label><input type="text" class="form-control" name="anio_archivo" required></div>
          <div class="col-md-4"><label class="form-label">Tomo</label><input type="text" class="form-control" name="tomo"></div>
          <div class="col-md-4"><label class="form-label">Bimestre</label><input type="number" class="form-control" name="bimestre" value="1"></div>
          <div class="col-md-12">
            <label class="form-label d-block">Certificados</label>
            <div class="border rounded p-2" style="max-height: 150px; overflow-y: auto;">
              <?php
              $certificadosArchivo = [
                "Copia autorizada",
                "Vigencia",
                "Agregado",
                "Copia condominio"
              ];
              foreach ($certificadosArchivo as $cert) {
                echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="certificado_archivo[]" value="' . htmlspecialchars($cert) . '" id="' . md5("arch".$cert) . '">
                        <label class="form-check-label" for="' . md5("arch".$cert) . '">' . htmlspecialchars($cert) . '</label>
                      </div>';
              }
              ?>
            </div>
          </div>
          <div class="col-12"><label class="form-label">Observación</label><textarea class="form-control" name="observacion" rows="3"></textarea></div>
        </div>
        <button type="submit" class="btn btn-primary">Agregar archivo</button>
      </form>
    </div>
  </div>

  <!-- Sección nueva: Documentos solicitados -->
  <div class="card shadow rounded-4">
    <div class="card-body p-4">
      <h4 class="titulo-seccion">Documentos solicitados</h4>
      <?php if (!empty($_SESSION['documentos'])): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead><tr><th>Detalle</th><th>Acción</th></tr></thead>
            <tbody>
              <?php foreach ($_SESSION['documentos'] as $i => $doc): ?>
                <tr>
                  <td><?= nl2br(htmlspecialchars(implode("-", array_filter($doc)))) ?></td>
                  <td>
                    <form method="post" style="display:inline">
                      <input type="hidden" name="accion" value="borrar">
                      <input type="hidden" name="index" value="<?= $i ?>">
                      <button type="submit" class="btn btn-sm btn-danger">Borrar</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-muted">No hay documentos guardados aún.</p>
      <?php endif; ?>
      <form method="post" action="solicitud_ingreso.php">
  <button type="submit" class="btn btn-success">Solicitar documentos</button>
</form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
