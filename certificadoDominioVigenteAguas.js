async function generateCertificadoDominioVigenteAguas(registro, nombre, fojaInicial, numero, ano, canal) {
    
    //////OBTENER FECHA ACTUAL//////
    const date = new Date();
    const options = { day: 'numeric', month: 'long', year: 'numeric' };

    // Obtener la fecha formateada
    const formattedDate = date.toLocaleDateString('es-ES', options);

    ////////////////////////////////

    // Obtener el estado del checkbox 'noMembrete'
    const noMembrete = document.getElementById('noMembrete').checked;
    
    const titulo1 = `DOMINIO VIGENTE`;
    const tituloRegistro = `Registro de ${registro}`;

    const formattedFojaInicial = fojaInicial.endsWith('v') ? `${fojaInicial.slice(0, -1)} vta` : fojaInicial;
    const detalleCompleto = `El Conservador de Bienes Raíces de Llay-Llay y Catemu certifica: que la inscripción de fojas ${formattedFojaInicial}  No. ${numero} del Registro de ${registro} del año ${ano}, adjunta al presente documento, está conforme con su original y se encuentra vigente al día ${formattedDate}.`;
    
    const detalleNombre = `Nombre: ${nombre}`;
    const detalleCanal = `Canal: ${canal}`;    
   
    const pdf = new jsPDF('p', 'pt', [612, 936]);

    // Solo agregar la imagen de fondo si noMembrete está desmarcado
    if (!noMembrete) {
        const image = await loadImage("background.jpg");
        pdf.addImage(image, 'PNG', 0, 0, 612, 936);
    }

    const ciudadFecha = `Llay-Llay, ${formattedDate}`;
    pdf.setFontSize(12);
    pdf.text(ciudadFecha, 92, 540);
    
    // Mostrar título
    pdf.setFontSize(18);
    pdf.text(titulo1, 92, 195);
    pdf.text(tituloRegistro, 92, 220);

    // Ajustar el detalle completo dentro de los márgenes
    const marginLeft = 92;
    const marginRight = 540; // Ajusta esto según sea necesario
    const maxWidth = marginRight - marginLeft;

    // Dividir el detalle en líneas
    pdf.setFontSize(12);
    const detalleLines = pdf.splitTextToSize(detalleCompleto, maxWidth);

    // Dibujar el detalle en el PDF
    let yPosition = 320;
    detalleLines.forEach((line, index) => {
        pdf.text(line, marginLeft, yPosition + (index * 20));
    });

    // Mostrar información asociada a Dominio Vigente Aguas
    pdf.setFontSize(12);
    pdf.setFont('helvetica', 'bold');
    pdf.text(detalleNombre, 92, 440);
    pdf.text(detalleCanal, 92, 460);
    
    return pdf.output("arraybuffer"); // Devuelve los bytes del PDF
}
