    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login/login.html");
        exit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>CBR - Administrar Apéndices</title>
        <link rel="stylesheet" href="assets/bootstrap/3.3.7/bootstrap.min.css">
        <link rel="shortcut icon" href="./images/favicon.png" />
        <script src="assets/jquery-3.2.1.min.js"></script>
        <script src="assets/bootstrap/3.3.7/bootstrap.min.js"></script>
        <style type="text/css">
    * {
        font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif
    }
    .main {
        margin:auto;
        display: inline-block;
        width:100%;
        text-align:center;
        padding:60px;
    }
    input[type=submit] {
        background:#6ca16e;
        width:100%;
        padding:5px 15px;
        background:#ccc;
        cursor:pointer;
        font-size:16px;
    }
    input[type=text] {
        width:40%;
        padding:5px 15px;
        height:25px;
        font-size:16px;
    }
    .form-control {
        padding: 5px 0px;
    margin-bottom: 10px;
    }

    .loader {
        border: 12px solid #f3f3f3;
        border-top: 12px solid #5f9ea0;
        border-radius: 50%;
        width: 100px;
        height: 100px;
        animation: spin 1s linear infinite;
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
        z-index: 9999;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    </style>
    </head>
    <style>
    body {
        background-image:url('./images/backgroundUpload.jpg');
        background-repeat: no-repeat;
        background-size: cover; 
    }
    </style>
    <body>
    <div class="main">
        <h1>Administrar Apéndices - Conservador Bienes Raíces</h1>
        <br>    
        <div class="panel panel-primary">
        <div class="panel-heading">
                <h3>Cargar imágenes</h3>
        </div>
            <div class="panel-body">
                <form name="MiForm" id="MiForm" method="post" action="cargar-apendice.php" enctype="multipart/form-data">
                    
                    <!-- Agrega el campo de selección para el tipo de registro -->
                    <div style="display: column;">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Tipo de Registro:</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="tipoRegistro">
                            <option value="sin dato">Seleccione tipo de Registro</option>
                            <option value="Propiedad">Propiedad</option>
                            <option value="Hipotecas y Gravámenes">Hipoteca</option>
                            <option value="Interdicciones y Prohibiciones">Prohibición</option>
                            <option value="Propiedad de Aguas">Aguas</option>
                            <option value="Hipotecas y Gravámenes de Aguas">Hipoteca de aguas</option>
                            <option value="Interdicciones y Prohibiciones de Aguas">Prohibición de aguas</option>
                            <option value="Comercio">Comercio</option>
                            <option value="Descubrimiento de Minas">Descubrimiento de minas</option>
                            <option value="Propiedad de Minas">Minas</option>
                            <option value="Accionista">Accionista</option>
                            <option value="Hipotecas y Gravámenes de Minas">Hipoteca de minas</option>
                            <option value="Interdicciones y Prohibiciones de Minas">Prohibición de minas</option>
                            <option value="Prenda Agraria">Prenda agraria</option>
                            <option value="Preda Industrial">Prenda industrial</option>
                            <option value="Prohibicion Prenda Agraria">Prohibición prenda agraria</option>
                            <option value="Prohibicion Prenda Especial">Prohibición prenda especial</option>
                            <option value="Prohibicion Prenda Industrial">Prohibición prenda industrial</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Arrastrar y soltar aquí o Elegir archivos...</label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" id="miarchivo[]" name="miarchivo[]" multiple="">
                        </div>
                    </div>
                    <br><br><br>

                    <div style="display: column;">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Año:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="anno" />
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Cargar Imágenes</button>
                    </div>

                        
                    </div>
                    </div>
                </form>
            </div>
        </div>
    
    </div>

    <!-- Indicador de carga -->
    <div class="loader" id="loader"></div>

    <!-- JavaScript para mostrar/ocultar el indicador de carga -->
    <script>
        const loader = document.getElementById('loader');
        const uploadForm = document.getElementById('MiForm');

        uploadForm.addEventListener('submit', function() {
            loader.style.display = 'block';
        });
    </script>

    </body></html>
