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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="./images/favicon.png" />
    <title>CBR - Copias de Registro</title>
    <script src="pdf-lib.min.js"></script>
    <script src="jspdf.min.js"></script>
</head>

<body class="prepararcopia">
    <aside id="sidebar2">

        <div class="header">
            <h1 id="titulo">
                <span>Conservador</span><br>
                <span>de Bienes</span><br>
                <span>Raíces</span>
            </h1>
            <div class="logo-container">
                <img src="./images/logo6.png" alt="Logotipo">
            </div>
        </div>

        <!-- <h2 id="titulo2">COMUNA DE LLAY LLAY</h2> -->

        <div id="header">
            <h2>Generar Copias de Registro</h2>
        </div>

        <form id="form">
            <div class="div4">
                <!-- <label for="registro">Registro:</label> -->
                <select id="registro" name="registro">
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

            <div class="div2">
                <!-- <label for="copia" class="form-label">Documento</label> -->
                        <select class="form-select" id="copia">
                            <option value="">Seleccione tipo de copia</option>
                            <option value="Simple">Autorizada</option>
                            <option value="Vigente">Vigente</option>
                            <option value="VigenteParte">Vigente en parte</option>
                            <option value="DominioVigente">Dominio vigente</option>
                            <option value="DominioVigenteParte">Dominio vigente en parte</option>
                            <option value="DominioVigenteAguas">Vigencia de Aguas</option>
                            <option value="DominioVigenteAguasParte">Vigencia en parte de Aguas</option>
                            <option value="DocumentoEspecial">Documento especial</option>
                        </select>
                        <input class="caja1" type="text" id="numeroSolicitud" placeholder="No. de Solicitud" title="No. de Solicitud">
                        <input type="checkbox" id="noMembrete" name="noMembrete">
                        <label for="noMembrete">No Incluir Membrete</label>
            </div>

            <div class="div2">
                <!-- <label for="fojaInicial">Foja Inicial:</label> -->
                <input class="caja1"  type="text" id="fojaInicial" placeholder="Foja inicial" title="Foja inicial">

                <!-- <label for="fojaFinal">Foja Final:</label> -->
                <input class="caja1" type="text" id="fojaFinal" placeholder="Foja final" title="Foja final">

                <!-- <label for="numero" class="form-label">No. Inscripción</label> -->
                <input type="text" class="form-control" id="numero" placeholder="No. Inscripción" title="No. Inscripción">

                <!-- <label for="ano">Año:</label> -->
                <input type="text" id="ano" placeholder="Año" title="Año">
            </div>

            <div class="div4">

                <!-- <label for="nombre" class="form-label">Nombres</label> -->
                <input type="text" class="form-control" id="nombre" placeholder="Ingrese nombres" title="Nombres" style="width: 48%">
                <!-- <label for="apellido" class="form-label">Apellidos</label> -->
                <!-- <input type="text" class="form-control" id="apellido" placeholder="Ingrese apellidos"> -->

            </div>

            <div class="div4" id="camposDominioVigente" style="display: none;">
                <input type="text" id="lugar" placeholder="Lugar" title="Lugar" style="width: 48%">
                <input type="text" id="comuna" placeholder="Comuna" title="Comuna" style="width: 48%">
            </div>

            <div class="div4" id="camposDominioVigenteAguas" style="display: none;">
                <input type="text" id="canal" placeholder="Canal" title="Canal" style="width: 48%">
            </div>

            <div class="div4" id="camposDocEspecial" style="display: none;">
                <input type="text" id="tituloDocEspecial" placeholder="Título del documento" title="Título del documento" style="width: 48%">
                <textarea id="contenidoDocEspecial" placeholder="Contenido del documento" title="Contenido del documento" style="width: 48%; height: 100px; resize: none;"></textarea>
            </div>


            <div class="div3">
                <button id="showImagesButton" class="button2 with-icon">Mostrar Imágenes</button>
                <button id="limpiarDatosButton" class="button2 with-icon">Limpiar Datos</button>
            </div>

            <div class="div3">
                <button id="cropImageButton" class="button2 with-icon">Recortar primera foja</button>
                <button id="cropImageButton2" class="button2 with-icon">Recortar última foja</button>
            </div>

            <div class="div3">
                <button id="generarPdfCopiasButton" class="button2 with-icon">Generar Copias</button>
                <button id="generatePdfFinalButton" class="button2 with-icon">Documento Final</button>
            </div>
           
        </form>

    </aside>

    <main id="imageGallery">
        <!-- Aquí se mostrarán las imágenes -->

    </main>

    <script src="script-prepararcopia.js"></script>
    <script src="script-copiaSolo1foja.js"></script>
    <script src="certificadoSimple.js"></script>
    <script src="certificadoVigente.js"></script>
    <script src="certificadoVigenteParte.js"></script>
    <script src="certificadoDominioVigente.js"></script>
    <script src="certificadoDominioVigenteParte.js"></script>
    <script src="certificadoDominioVigenteAguas.js"></script>
    <script src="certificadoDominioVigenteAguasParte.js"></script>
    <script src="certificadoDocEspecial.js"></script>

    <script>

        function loadImage(url) {
            return new Promise(resolve => {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', url, true);
                xhr.responseType = "blob";
                xhr.onload = function (e) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const res = event.target.result;
                        resolve(res);
                    }
                    const file = this.response;
                    reader.readAsDataURL(file);
                }
                xhr.send();
            });
        }

        window.addEventListener('DOMContentLoaded', async () => {
            // Esperar a que el DOM esté completamente cargado
            const canvas = document.querySelector("canvas");

            if (canvas) {
                // Acceder al canvas solo si existe
                canvas.height = canvas.offsetHeight;
                canvas.width = canvas.offsetWidth;
                // signaturePad = new SignaturePad(canvas, {});
            }

            const form = document.querySelector('#form');

            const camposDominioVigente = document.getElementById('camposDominioVigente');
            const copiaSelect = document.getElementById('copia');

            copiaSelect.addEventListener('change', () => {
                
                if (copiaSelect.value === 'DominioVigente' || copiaSelect.value === 'DominioVigenteParte') {
                    camposDominioVigente.style.display = 'block';
                } else {
                    camposDominioVigente.style.display = 'none';
                }
            });

            const camposDominioVigenteAguas = document.getElementById('camposDominioVigenteAguas');
            const copiaSelect1 = document.getElementById('copia');

            copiaSelect1.addEventListener('change', () => {
                
                if (copiaSelect1.value === 'DominioVigenteAguas' || copiaSelect.value === 'DominioVigenteAguasParte') {
                    camposDominioVigenteAguas.style.display = 'block';
                } else {
                    camposDominioVigenteAguas.style.display = 'none';
                }
            });
         
            const camposDocEspecial = document.getElementById('camposDocEspecial');
            const copiaSelect2 = document.getElementById('copia');

            copiaSelect2.addEventListener('change', () => {
                if (copiaSelect2.value === 'DocumentoEspecial') {
                    camposDocEspecial.style.display = 'block';
                } else {
                    camposDocEspecial.style.display = 'none';
                }
            });

            form.addEventListener('submit', (e) => {
                e.preventDefault();

                let registro = document.getElementById('registro').value;
                let nombres = document.getElementById('nombre').value;
                //let apellidos = document.getElementById('apellido').value;
                // let email = document.getElementById('email').value;

                let fojaInicial = document.getElementById('fojaInicial').value;
                let fojaFinal = document.getElementById('fojaFinal').value;
                let numero = document.getElementById('numero').value;
                let ano = document.getElementById('ano').value;

            })
        });

    </script>

    <script>
        // Asigna el evento del botón copias
        const generarPdfCopiasButton = document.getElementById("generarPdfCopiasButton");
        generarPdfCopiasButton.addEventListener("click", (event) => {
            event.preventDefault();
            const fojaInicial = document.getElementById("fojaInicial").value;
            const fojaFinal = document.getElementById("fojaFinal").value;
            
            if (fojaInicial === fojaFinal) {
                generarPDFUnaFoja();
            } else {
                generarCopiasOnly();
            }
            localStorage.clear();
        });

        // Asigna el evento del botón documento final
        document.getElementById('generatePdfFinalButton').addEventListener('click', (event) => {
            event.preventDefault();
            const noMembrete = document.getElementById('noMembrete').checked;
            localStorage.setItem('noMembrete', noMembrete);

            const fojaInicial = document.getElementById('fojaInicial').value;
            const fojaFinal = document.getElementById('fojaFinal').value;
    
            if (fojaInicial === fojaFinal) {
                generarDocumentoFinal1();
            } else {
                generarDocumentoFinal();
            }
            localStorage.clear();
        });


    </script>

</body>

</html>