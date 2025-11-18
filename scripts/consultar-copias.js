$(document).ready(function() {
    $('#buscarCopiasButton').click(function() {
        const registro = $('#registro').val();
        const numero = $('#numero').val();
        const ano = $('#ano').val();

        if (registro && numero && ano) {
            // Formato del nombre del archivo
            const fileName = `CPA-${registro}-${ano}-${numero}.pdf`;
            const filePath = `./copias/${fileName}`;

            // Cargar el PDF en el iframe
            $('#pdfViewer').attr('src', filePath);
        } else {
            alert('Por favor, complete todos los campos requeridos.');
        }
    });
});
