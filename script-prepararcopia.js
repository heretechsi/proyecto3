let fojaInicialRecortada = null;  // Declaramos variable de recorte como null
let fojaFinalRecortada = null;    // Declaramos variable de recorte como null

console.log("fojaInicialRecortada al cargar la página:", fojaInicialRecortada);
console.log("fojaFinalRecortada al cargar la página:", fojaFinalRecortada);

// Función para convertir el formato de fojas
function convertirFormatoFojas(foja) {
    const numero = parseInt(foja);
    let resultado;

    if (foja.includes("bis") && foja.includes("v")) {
        resultado = `${numero}.4`;
    } else if (foja.includes("bis")) {
        resultado = `${numero}.3`;
    } else if (foja.includes("v")) {
        resultado = `${numero}.2`;
    } else {
        resultado = `${numero}.1`;
    }
    
    console.log(`convertirFormatoFojas(${foja}) -> ${resultado}`);
    return resultado;
}

// Función para mostrar las imágenes antes de generar el PDF
async function mostrarImagenes() {
    const tipoRegistro = document.getElementById("registro").value;
    const selectedYear = document.getElementById("ano").value;
    const fojaInicial = convertirFormatoFojas(document.getElementById("fojaInicial").value);
    const fojaFinal = convertirFormatoFojas(document.getElementById("fojaFinal").value);

    const imageGallery = document.getElementById("imageGallery");
    imageGallery.innerHTML = ""; // Limpia cualquier imagen existente

    const fojaInicialNum = parseFloat(fojaInicial);
    const fojaFinalNum = parseFloat(fojaFinal);

    console.log(`fojaInicialNum: ${fojaInicialNum}, fojaFinalNum: ${fojaFinalNum}`);

    for (let foja = fojaInicialNum; foja <= fojaFinalNum; foja = parseFloat((Math.floor(foja) + (foja % 1) * 10 / 10 + 0.1).toFixed(1))) {
        const fojaRedondeada = foja.toFixed(1);
        console.log(`Generando imagen para foja: ${fojaRedondeada}`);
        const imgPath = `upload/${tipoRegistro}/${selectedYear}/${fojaRedondeada}.jpg`;
        const imageExists = await imageExistsAsync(imgPath);

        if (imageExists) {
            const imgElement = document.createElement("img");
            imgElement.src = imgPath;
            imageGallery.appendChild(imgElement);
        } else {
            console.warn(`La imagen no existe en la ruta: ${imgPath}`);
        }

        // Manejo de bis y vbis
        if (foja % 1 === 0.1) {
            const baseNumber = Math.floor(foja);
            const nextBis = parseFloat(`${baseNumber}.3`);
            const nextVBis = parseFloat(`${baseNumber}.4`);

            console.log(`nextBis: ${nextBis}, nextVBis: ${nextVBis}`);

            if (nextBis <= fojaFinalNum) {
                const nextBisPath = `upload/${tipoRegistro}/${selectedYear}/${nextBis.toFixed(1)}.jpg`;
                const nextBisExists = await imageExistsAsync(nextBisPath);
                if (nextBisExists) {
                    const bisImgElement = document.createElement("img");
                    bisImgElement.src = nextBisPath;
                    imageGallery.appendChild(bisImgElement);
                } else {
                    console.warn(`La imagen bis no existe en la ruta: ${nextBisPath}`);
                }
            }

            if (nextVBis <= fojaFinalNum) {
                const nextVBisPath = `upload/${tipoRegistro}/${selectedYear}/${nextVBis.toFixed(1)}.jpg`;
                const nextVBisExists = await imageExistsAsync(nextVBisPath);
                if (nextVBisExists) {
                    const vBisImgElement = document.createElement("img");
                    vBisImgElement.src = nextVBisPath;
                    imageGallery.appendChild(vBisImgElement);
                } else {
                    console.warn(`La imagen vbis no existe en la ruta: ${nextVBisPath}`);
                }
            }
        }
    }
}

// Función para verificar si una imagen existe
async function imageExistsAsync(url) {
    try {
        const response = await fetch(url, { method: 'HEAD' });
        console.log(`Verificación de existencia de imagen en URL: ${url}, Resultado: ${response.ok}`);
        return response.ok;
    } catch (error) {
        console.error(`Error al verificar la existencia de la imagen en URL: ${url}`, error);
        return false;
    }
}

// Función para generar el PDF de las copias
async function generateCopiasPDF() {
    const tipoRegistro = document.getElementById("registro").value;
    const selectedYear = document.getElementById("ano").value;
    const fojaInicial = convertirFormatoFojas(document.getElementById("fojaInicial").value);
    const fojaFinal = convertirFormatoFojas(document.getElementById("fojaFinal").value);

    const pdfDoc = await PDFLib.PDFDocument.create();

    const fojaInicialNum = parseFloat(fojaInicial);
    const fojaFinalNum = parseFloat(fojaFinal);

    for (let foja = fojaInicialNum; foja <= fojaFinalNum; foja = parseFloat((Math.floor(foja) + (foja % 1) * 10 / 10 + 0.1).toFixed(1))) {
        const fojaRedondeada = foja.toFixed(1);
        const imgPath = `upload/${tipoRegistro}/${selectedYear}/${fojaRedondeada}.jpg`;
        const imageExists = await imageExistsAsync(imgPath);

        if (imageExists) {
            const imageBytes = await fetch(imgPath).then(response => response.arrayBuffer());
            const image = await pdfDoc.embedJpg(imageBytes);
            const page = pdfDoc.addPage([612, 936]);
            page.drawImage(image, {
                x: 0,
                y: 0,
                width: page.getWidth(),
                height: page.getHeight(),
            });
        }

        // Manejo de bis y vbis
        if (foja % 1 === 0.1) {
            const baseNumber = Math.floor(foja);
            const nextBis = parseFloat(`${baseNumber}.3`);
            const nextVBis = parseFloat(`${baseNumber}.4`);

            if (nextBis <= fojaFinalNum) {
                const nextBisPath = `upload/${tipoRegistro}/${selectedYear}/${nextBis.toFixed(1)}.jpg`;
                const nextBisExists = await imageExistsAsync(nextBisPath);
                if (nextBisExists) {
                    const imageBytes = await fetch(nextBisPath).then(response => response.arrayBuffer());
                    const image = await pdfDoc.embedJpg(imageBytes);
                    const page = pdfDoc.addPage([612, 936]);
                    page.drawImage(image, {
                        x: 0,
                        y: 0,
                        width: page.getWidth(),
                        height: page.getHeight(),
                    });
                }
            }

            if (nextVBis <= fojaFinalNum) {
                const nextVBisPath = `upload/${tipoRegistro}/${selectedYear}/${nextVBis.toFixed(1)}.jpg`;
                const nextVBisExists = await imageExistsAsync(nextVBisPath);
                if (nextVBisExists) {
                    const imageBytes = await fetch(nextVBisPath).then(response => response.arrayBuffer());
                    const image = await pdfDoc.embedJpg(imageBytes);
                    const page = pdfDoc.addPage([612, 936]);
                    page.drawImage(image, {
                        x: 0,
                        y: 0,
                        width: page.getWidth(),
                        height: page.getHeight(),
                    });
                }
            }
        }
    }

    return pdfDoc.save();
}
// Genera copias sin certificado
async function generarCopiasOnly() {
    // Recuperar las imágenes recortadas desde localStorage al cargar la página
    let fojaInicialRecortada = localStorage.getItem('fojaInicialRecortada');
    let fojaFinalRecortada = localStorage.getItem('fojaFinalRecortada');

    // Genera el PDF de las copias
    const copiasPdfBytes = await generateCopiasPDF();
    
    if (!copiasPdfBytes) {
        alert("No se han generado las copias.");
        return;
    }

    const pdfDoc = await PDFLib.PDFDocument.create();
    
    // Añade las páginas de las copias
    const copiasPdf = await PDFLib.PDFDocument.load(copiasPdfBytes);
    const copiasPages = await pdfDoc.copyPages(copiasPdf, copiasPdf.getPageIndices());

    // Reemplaza la primera y última página si las imágenes recortadas están disponibles
    if (fojaInicialRecortada) {
        await generatePdfWithAdjustedWidth(fojaInicialRecortada, pdfDoc, true); // true para la primera página (a margen inferior)
    } else {
        pdfDoc.addPage(copiasPages[0]);
    }

    for (let i = 1; i < copiasPages.length - 1; i++) {
        pdfDoc.addPage(copiasPages[i]);
    }

    if (fojaFinalRecortada) {
        await generatePdfWithAdjustedWidth(fojaFinalRecortada, pdfDoc, false); // false para la última página (a margen superior)
    } else {
        pdfDoc.addPage(copiasPages[copiasPages.length - 1]);
    }

    // Muestra el documento final en una nueva ventana
    const pdfBytes = await pdfDoc.save();

    // Guardar en base de datos
    const numeroSolicitud = document.getElementById('numeroSolicitud').value;
    const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });
    
    const formData = new FormData();
    formData.append('id_certificado', numeroSolicitud);
    formData.append('pdf', pdfBlob, 'copia.pdf');
    
    try {
        const response = await fetch('guardar_pdf.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if (result.success) {
            console.log('PDF guardado en base de datos');
        } else {
            console.error('Error al guardar PDF:', result.error);
        }
    } catch (error) {
        console.error('Error de conexión:', error);
    }

    window.open(URL.createObjectURL(new Blob([pdfBytes], { type: "application/pdf" })), "_blank");
}

//Genera documento final (certificado y copias)
async function generarDocumentoFinal() {
    // Recuperar las imágenes recortadas desde localStorage al cargar la página
    let fojaInicialRecortada = localStorage.getItem('fojaInicialRecortada');
    let fojaFinalRecortada = localStorage.getItem('fojaFinalRecortada');

    // Genera el PDF de las copias
    const copiasPdfBytes = await generateCopiasPDF();

    if (!copiasPdfBytes) {
        alert("No se han generado las copias.");
        return;
    }

    // Genera el certificado con los datos del formulario
    const registro = document.getElementById("registro").value;
    const nombres = document.getElementById("nombre").value;
    const fojaInicial = document.getElementById("fojaInicial").value;
    const numero = document.getElementById("numero").value;
    const ano = document.getElementById("ano").value;
    const tipoCopia = document.getElementById("copia").value;
    const lugar = document.getElementById("lugar").value;
    const comuna = document.getElementById("comuna").value;
    const canal = document.getElementById("canal").value;
    const tituloDocEspecial = document.getElementById("tituloDocEspecial").value;
    const contenidoDocEspecial = document.getElementById("contenidoDocEspecial").value;

    let certificadoBytes;
    switch (tipoCopia) {
        case "Simple":
            certificadoBytes = await generateCertificadoSimple(registro, nombres, fojaInicial, numero, ano);
            break;
        case "Vigente":
            certificadoBytes = await generateCertificadoVigente(registro, nombres, fojaInicial, numero, ano);
            break;
        case "VigenteParte":
            certificadoBytes = await generateCertificadoVigenteParte(registro, nombres, fojaInicial, numero, ano);
            break;
        case "DominioVigente":
            certificadoBytes = await generateCertificadoDominioVigente(registro, nombres, fojaInicial, numero, ano, lugar, comuna);
            break;
        case "DominioVigenteParte":
            certificadoBytes = await generateCertificadoDominioVigenteParte(registro, nombres, fojaInicial, numero, ano, lugar, comuna);
            break;
        case "DominioVigenteAguas":
            certificadoBytes = await generateCertificadoDominioVigenteAguas(registro, nombres, fojaInicial, numero, ano, canal);
            break;
        case "DominioVigenteAguasParte":
            certificadoBytes = await generateCertificadoDominioVigenteAguasParte(registro, nombres, fojaInicial, numero, ano, canal);
            break;
        case "DocumentoEspecial":
            certificadoBytes = await generateCertificadoDocEspecial(registro, nombres, fojaInicial, numero, ano, tituloDocEspecial, contenidoDocEspecial);
            break;
        default:
            alert("Seleccione un tipo de copia válido.");
            return;
    }

    // Crea un nuevo documento PDF
    const pdfDoc = await PDFLib.PDFDocument.create();

    // Añade las páginas del certificado
    const certificadoPdf = await PDFLib.PDFDocument.load(certificadoBytes);
    const certificadoPages = await pdfDoc.copyPages(certificadoPdf, certificadoPdf.getPageIndices());
    certificadoPages.forEach((page) => pdfDoc.addPage(page));

    // Añade las páginas de las copias
    const copiasPdf = await PDFLib.PDFDocument.load(copiasPdfBytes);
    const copiasPages = await pdfDoc.copyPages(copiasPdf, copiasPdf.getPageIndices());

    // Reemplaza la primera y última página si las imágenes recortadas están disponibles
    if (fojaInicialRecortada) {
        await generatePdfWithAdjustedWidth(fojaInicialRecortada, pdfDoc, true); // true para la primera página (a margen inferior)
    } else {
        pdfDoc.addPage(copiasPages[0]);
    }

    for (let i = 1; i < copiasPages.length - 1; i++) {
        pdfDoc.addPage(copiasPages[i]);
    }

    if (fojaFinalRecortada) {
        await generatePdfWithAdjustedWidth(fojaFinalRecortada, pdfDoc, false); // false para la última página (a margen superior)
    } else {
        pdfDoc.addPage(copiasPages[copiasPages.length - 1]);
    }

    // Muestra el documento final en una nueva ventana
    const pdfBytes = await pdfDoc.save();

    // Guardar en base de datos
    const numeroSolicitud = document.getElementById('numeroSolicitud').value;
    const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });
    
    const formData = new FormData();
    formData.append('id_certificado', numeroSolicitud);
    formData.append('pdf', pdfBlob, 'documento_final.pdf');
    
    try {
        const response = await fetch('guardar_pdf.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if (result.success) {
            console.log('Documento guardado en base de datos');
        } else {
            console.error('Error al guardar documento:', result.error);
        }
    } catch (error) {
        console.error('Error de conexión:', error);
    }

    window.open(URL.createObjectURL(new Blob([pdfBytes], { type: "application/pdf" })), "_blank");
}

//////////////////////////////////////////////////////////////////////////////

async function generatePdfWithAdjustedWidth(imageDataUrl, pdfDoc, alignToBottom = false) {
    const imageBytes = atob(imageDataUrl.split(',')[1]);
    const uint8Array = new Uint8Array(imageBytes.length);
    for (let i = 0; i < imageBytes.length; i++) {
        uint8Array[i] = imageBytes.charCodeAt(i);
    }

    const embeddedImage = await pdfDoc.embedPng(uint8Array.buffer);
    const page = pdfDoc.addPage([612, 936]); // Agrega una nueva página

    const imageWidth = embeddedImage.width;
    const imageHeight = embeddedImage.height;
    const pageWidth = page.getWidth();
    const pageHeight = page.getHeight();

    const scale = pageWidth / imageWidth;
    const scaledImageHeight = imageHeight * scale;
    const margin = 50; // Margen de 50 unidades

    if (scaledImageHeight + margin > pageHeight) {
        const scaleForHeight = (pageHeight - margin) / imageHeight;
        const scaledImageWidth = imageWidth * scaleForHeight;

        page.drawImage(embeddedImage, {
            x: (pageWidth - scaledImageWidth) / 2,
            y: alignToBottom ? margin : 0,
            width: scaledImageWidth,
            height: pageHeight - margin,
        });
    } else {
        const yPosition = alignToBottom ? margin : pageHeight - scaledImageHeight - margin;
        page.drawImage(embeddedImage, {
            x: 0,
            y: yPosition,
            width: pageWidth,
            height: scaledImageHeight,
        });
    }
}

// Asigna el evento del botón "Mostrar Imágenes"
const showImagesButton = document.getElementById("showImagesButton");
showImagesButton.addEventListener("click", (event) => {
    event.preventDefault();
    mostrarImagenes();
});

// Función para abrir la ventana de recorte y cargar la imagen correspondiente a la primera foja del registro
function openCropImage() {
    const tipoRegistro = document.getElementById("registro").value;
    const selectedYear = document.getElementById("ano").value;
    const fojaInicial = convertirFormatoFojas(document.getElementById("fojaInicial").value);

    const imgPath = `upload/${tipoRegistro}/${selectedYear}/${fojaInicial}.jpg`;
    window.open(`recorte.html?imgPath=${encodeURIComponent(imgPath)}`, "_blank");
}

// Asigna el evento del botón "Recortar primera foja"
const cropImageButton = document.getElementById("cropImageButton");
cropImageButton.addEventListener("click", openCropImage);

// Función para abrir la ventana de recorte y cargar la imagen correspondiente a la última foja del registro
function openCropImage2() {
    const tipoRegistro = document.getElementById("registro").value;
    const selectedYear = document.getElementById("ano").value;
    const fojaFinal = convertirFormatoFojas(document.getElementById("fojaFinal").value);

    const imgPath = `upload/${tipoRegistro}/${selectedYear}/${fojaFinal}.jpg`;
    window.open(`recorte2.html?imgPath=${encodeURIComponent(imgPath)}`, "_blank");
}

// Asigna el evento del botón "Recortar última foja"
const cropImageButton2 = document.getElementById("cropImageButton2");
cropImageButton2.addEventListener("click", openCropImage2);

// Función para cargar una imagen
function loadImage(src) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = reject;
        img.src = src;
    });
}

// Event listener para el botón que limpia formulario y recortes
document.getElementById('limpiarDatosButton').addEventListener('click', () => {
    // Limpia el formulario
    document.getElementById('form').reset();
        
    // Recarga la página
    location.reload();
    
    console.log("Formulario, localStorage y lienzo limpiados.");

});

// Evento Limpiar el localStorage al refrescar ventana
window.addEventListener('beforeunload', (event) => {
    localStorage.clear();
});

