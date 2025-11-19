// Genera copia sin certificado
async function generarPDFUnaFoja() {
    // Recuperar las imágen recortada desde localStorage al cargar la página
    let fojaInicialRecortada = localStorage.getItem('fojaInicialRecortada');

    // Genera el PDF de la copia
    const copiasPdfBytes = await generateCopiasPDF();
    
    if (!copiasPdfBytes) {
        alert("No se han generado la copia.");
        return;
    }

    const pdfDoc = await PDFLib.PDFDocument.create();
    
    // Añade las página de la copia
    const copiasPdf = await PDFLib.PDFDocument.load(copiasPdfBytes);
    const copiasPages = await pdfDoc.copyPages(copiasPdf, copiasPdf.getPageIndices());

    // Reemplaza la primera página si la imagen recortada está disponible
    if (fojaInicialRecortada) {
        await generatePdfWithAdjustedWidth(fojaInicialRecortada, pdfDoc, false); 
    } else {
        pdfDoc.addPage(copiasPages[0]);
    }

    // Muestra el documento final en una nueva ventana
    const pdfBytes = await pdfDoc.save();

    // Guardar en base de datos
    const numeroSolicitud = document.getElementById('numeroSolicitud').value;
    const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });
    
    const formData = new FormData();
    formData.append('id_certificado', numeroSolicitud);
    formData.append('pdf', pdfBlob, 'copia_unica.pdf');
    
    try {
        const response = await fetch('guardar_pdf.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if (result.success) {
            console.log('Copia guardada en base de datos');
        } else {
            console.error('Error al guardar copia:', result.error);
        }
    } catch (error) {
        console.error('Error de conexión:', error);
    }

    window.open(URL.createObjectURL(new Blob([pdfBytes], { type: "application/pdf" })), "_blank");
}

// Asigna el evento del botón "Generar copia"
const generarPdfUnaFojaButton = document.getElementById("generarPdfUnaFojaButton");
generarPdfUnaFojaButton.addEventListener("click", (event) => {
    event.preventDefault();
    generarPDFUnaFoja();
    localStorage.clear();
});

// Genera documento final (certificado y copia)
async function generarDocumentoFinal1() {
    // Recuperar la imagen recortada desde localStorage al cargar la página
    let fojaInicialRecortada = localStorage.getItem('fojaInicialRecortada');

    // Genera el PDF de la copia
    const copiasPdfBytes = await generateCopiasPDF();

    if (!copiasPdfBytes) {
        alert("No se han generado la copia.");
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

    // Añade la primera página de la copia si la imagen recortada está disponible
    if (fojaInicialRecortada) {
        await generatePdfWithAdjustedWidth(fojaInicialRecortada, pdfDoc, false); 
    } else {
        const copiasPdf = await PDFLib.PDFDocument.load(copiasPdfBytes);
        const copiasPages = await pdfDoc.copyPages(copiasPdf, [0]);
        pdfDoc.addPage(copiasPages[0]);
    }

    // Muestra el documento final en una nueva ventana
    const pdfBytes = await pdfDoc.save();

    // Guardar en base de datos
    const numeroSolicitud = document.getElementById('numeroSolicitud').value;
    const pdfBlob = new Blob([pdfBytes], { type: 'application/pdf' });
    
    const formData = new FormData();
    formData.append('id_certificado', numeroSolicitud);
    formData.append('pdf', pdfBlob, 'documento_final_unico.pdf');
    
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

// Función para ajustar el ancho de la imagen y añadirla al PDF
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
        // const yPosition = (pageHeight - scaledImageHeight) / 2; // Centramos la imagen recortada horizontalmente
        const yPosition = alignToBottom ? margin : pageHeight - scaledImageHeight - margin;
        page.drawImage(embeddedImage, {
            x: 0,
            y: yPosition,
            width: pageWidth,
            height: scaledImageHeight,
        });
    }
}

// Asigna el evento del botón "Documento Final"
const generarPdfFinalUnaFojaButton = document.getElementById("generarPdfFinalUnaFojaButton");
generarPdfFinalUnaFojaButton.addEventListener("click", (event) => {
    event.preventDefault();
    generarDocumentoFinal1();
    localStorage.clear();
});
