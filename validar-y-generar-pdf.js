// ============================================================================
// VALIDAR SOLICITUD ANTES DE GENERAR PDF
// ============================================================================

/**
 * Función que valida si el numeroSolicitud existe en la base de datos
 * @param {number} numeroSolicitud - El número de solicitud a validar
 * @returns {Promise<boolean>} - true si existe, false si no
 */
async function validarSolicitud(numeroSolicitud) {
    try {
        const formData = new FormData();
        formData.append('numeroSolicitud', numeroSolicitud);

        const response = await fetch('validar_solicitud.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        return data.existe;
    } catch (error) {
        console.error('Error validando solicitud:', error);
        return false;
    }
}

/**
 * Función que obtiene el número de solicitud del formulario
 * @returns {string} - El valor del campo numeroSolicitud
 */
function obtenerNumeroSolicitud() {
    return document.getElementById('numeroSolicitud').value.trim();
}

/**
 * Función que valida que el campo numeroSolicitud no esté vacío
 * @returns {boolean}
 */
function validarCampoVacio() {
    const numeroSolicitud = obtenerNumeroSolicitud();
    
    if (!numeroSolicitud) {
        alert('Por favor, ingrese el número de solicitud.');
        document.getElementById('numeroSolicitud').focus();
        return false;
    }
    
    // Validar que sea un número
    if (isNaN(numeroSolicitud)) {
        alert('El número de solicitud debe ser un número válido.');
        document.getElementById('numeroSolicitud').focus();
        return false;
    }
    
    return true;
}

/**
 * Función que maneja la generación de copias (cuando fojaInicial === fojaFinal)
 */
async function generarCopiasConValidacion() {
    // Validar que el campo no esté vacío
    if (!validarCampoVacio()) {
        return;
    }

    const numeroSolicitud = obtenerNumeroSolicitud();
    
    // Mostrar mensaje mientras valida
    const botón = document.getElementById('generarPdfCopiasButton');
    const textoOriginal = botón.textContent;
    botón.textContent = 'Validando...';
    botón.disabled = true;

    try {
        // Validar en la base de datos
        const existe = await validarSolicitud(numeroSolicitud);

        if (!existe) {
            alert(`La solicitud número ${numeroSolicitud} no existe.\nPor favor, verifique la información suministrada e intente nuevamente.`);
            document.getElementById('numeroSolicitud').focus();
            return;
        }

        // Si existe, proceder con la generación de copias
        const fojaInicial = document.getElementById('fojaInicial').value;
        const fojaFinal = document.getElementById('fojaFinal').value;

        if (fojaInicial === fojaFinal) {
            generarPDFUnaFoja();
        } else {
            generarCopiasOnly();
        }
        
        localStorage.clear();
    } catch (error) {
        console.error('Error:', error);
        alert('Ocurrió un error al validar la solicitud. Intente nuevamente.');
    } finally {
        botón.textContent = textoOriginal;
        botón.disabled = false;
    }
}

/**
 * Función que maneja la generación del documento final (cuando fojaInicial === fojaFinal)
 */
async function generarDocumentoFinalConValidacion() {
    // Validar que el campo no esté vacío
    if (!validarCampoVacio()) {
        return;
    }

    const numeroSolicitud = obtenerNumeroSolicitud();
    
    // Mostrar mensaje mientras valida
    const botón = document.getElementById('generatePdfFinalButton');
    const textoOriginal = botón.textContent;
    botón.textContent = 'Validando...';
    botón.disabled = true;

    try {
        // Validar en la base de datos
        const existe = await validarSolicitud(numeroSolicitud);

        if (!existe) {
            alert(`La solicitud número ${numeroSolicitud} no existe.\nPor favor, verifique la información suministrada e intente nuevamente.`);
            document.getElementById('numeroSolicitud').focus();
            return;
        }

        // Si existe, proceder con la generación del documento final
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
    } catch (error) {
        console.error('Error:', error);
        alert('Ocurrió un error al validar la solicitud. Intente nuevamente.');
    } finally {
        botón.textContent = textoOriginal;
        botón.disabled = false;
    }
}

// Cuando el DOM esté cargado, asignar los nuevos listeners
document.addEventListener('DOMContentLoaded', () => {
    const generarPdfCopiasButton = document.getElementById('generarPdfCopiasButton');
    const generatePdfFinalButton = document.getElementById('generatePdfFinalButton');

    if (generarPdfCopiasButton) {
        // Remover el listener antiguo
        generarPdfCopiasButton.replaceWith(generarPdfCopiasButton.cloneNode(true));
        // Agregar el nuevo listener
        document.getElementById('generarPdfCopiasButton').addEventListener('click', (event) => {
            event.preventDefault();
            generarCopiasConValidacion();
        });
    }

    if (generatePdfFinalButton) {
        // Remover el listener antiguo
        generatePdfFinalButton.replaceWith(generatePdfFinalButton.cloneNode(true));
        // Agregar el nuevo listener
        document.getElementById('generatePdfFinalButton').addEventListener('click', (event) => {
            event.preventDefault();
            generarDocumentoFinalConValidacion();
        });
    }
});
