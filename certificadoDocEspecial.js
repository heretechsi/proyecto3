async function generateCertificadoDocEspecial(registro, nombres, fojaInicial, numero, ano, tituloDocEspecial, contenidoDocEspecial) {
    
    //////OBTENER FECHA ACTUAL//////
    const date = new Date();
    const options = { day: 'numeric', month: 'long', year: 'numeric' };

    // Obtener la fecha formateada
    const formattedDate = date.toLocaleDateString('es-ES', options);

    ////////////////////////////////

    // Obtener el estado del checkbox 'noMembrete'
    const noMembrete = document.getElementById('noMembrete').checked;
    
    const titulo1 = `${tituloDocEspecial}`;
    const tituloRegistro = `Registro de ${registro}`;

    const formattedFojaInicial = fojaInicial.endsWith('v') ? `${fojaInicial.slice(0, -1)} vta` : fojaInicial;
    const detalleContenido = `El Conservador de Bienes Raíces de Llay-Llay y Catemu certifica: que la inscripción de fojas ${formattedFojaInicial}  No. ${numero} del Registro de ${registro} del año ${ano}, adjunta al presente documento, está conforme con su original.`;
    
    const contenidoAdicional = `${contenidoDocEspecial}`;
     
    const pdf = new jsPDF('p', 'pt', [612, 936]);

    // Solo agregar la imagen de fondo si noMembrete está desmarcado
    if (!noMembrete) {
        const image = await loadImage("background.jpg");
        pdf.addImage(image, 'PNG', 0, 0, 612, 936);
    }
    
    const ciudadFecha = `Llay-Llay, ${formattedDate}`;
    pdf.setFontSize(12);
    pdf.text(ciudadFecha, 92, 680);
    
    // Mostrar título
    pdf.setFontSize(18);
    pdf.text(titulo1, 92, 195);
    pdf.text(tituloRegistro, 92, 220);

    // Ajustar dentro de los márgenes
    const marginLeft = 92;
    const marginRight = 540; // Ajusta esto según sea necesario
    const maxWidth = marginRight - marginLeft;

    // Dividir el detalleContenido en líneas
    pdf.setFontSize(12);
    const detalleLines = pdf.splitTextToSize(detalleContenido, maxWidth);

    // Dibujar el detalleContenido en el PDF
    let yPosition = 320;
    detalleLines.forEach((line, index) => {
        pdf.text(line, marginLeft, yPosition + (index * 20));
    });


    // Dividir el contenidoAdicional en líneas
    pdf.setFontSize(12);
    const detalleLines2 = pdf.splitTextToSize(contenidoAdicional, maxWidth);

    // Dibujar el contenidoAdicional en el PDF
    let yPosition2 = 400;
    detalleLines2.forEach((line, index) => {
        pdf.text(line, marginLeft, yPosition2 + (index * 20));
    });


    return pdf.output("arraybuffer"); // Devuelve los bytes del PDF
}
