<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login/login.html");
    exit();
}

$libro     = $_GET['libro'] ?? '';
$foja      = $_GET['foja'] ?? '';
$anho      = $_GET['anho'] ?? '';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="./images/favicon.png" />
    <title>CBR - Visualizador de Imágenes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <aside id="sidebar">

        <div class="header">
            <h1 id="titulo">
                <span>Conservador</span><br>
                <span>de Bienes Raíces</span><br>
            </h1>
            <div class="logo-container2">
                <img src="./images/logo6.png" alt="Logotipo">
            </div>
        </div>
       
        <h2>Conservador Llay-Llay</h2>

        <div class="div4">
            <!-- <label for="registro">Tipo de Registro:</label> -->
        <select id="registro" name="registro" value="<?php echo $libro; ?>">
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
        
        <div class="div2">
            <!-- <label for="year">Año:</label> -->
            <input type="text" id="year" placeholder="Año" title="Año" value="<?php echo $anho; ?>">
        
            <!-- <label for="foja">Foja:</label> -->
            <input type="text" id="foja" placeholder="Foja" title="Foja" value="<?php echo $foja; ?>">
        </div>
        
        <div class="div3">
            <button id="retrocederButton" class="button2 with-icon">◄</button>
            <button id="avanzarButton" class="button2 with-icon">►</button>
        </div>
        <div class="div3">
            <button id="zoomOutButton" class="button2 with-icon">Zoom -</button>
            <button id="zoomInButton" class="button2 with-icon">Zoom +</button>
        </div>
        
        <div style="text-align: center;">________________________</div> 
        <br>
        <div>
            <button id="uploadButton" class="button2 with-icon" onclick="openImageUploadPage()">Administrar imágenes</button>
            <button id="generarPdfCopiasButton" class="button2 with-icon" onclick="openCopiaPage()">Generar Copias</button>
            <a href=ing_ind.php style="text-decoration: none;"><button id="generarPdfCopiasButton" class="button2 with-icon">Ingresar Indice</button></a>
            <a href=indice.php style="text-decoration: none;"><button id="generarPdfCopiasButton" class="button2 with-icon">Mirar Indice</button></a>
            <!-- <button class="button2">Cerrar Sesión</button> -->
            <!-- <a href="./login/logout.php">Cerrar sesión</a> -->
            <form action="./login/logout.php" method="post" style="display:inline;">
                <button id="logoutButton" type="submit" class="button2 with-icon">Cerrar Sesión</button>
            </form>
        </div>
             
    </aside>

    <main id="imageGallery">
        <!-- Aquí se mostrarán las imágenes -->
    </main>
    <script src="script.js"></script>
</body>
</html>
