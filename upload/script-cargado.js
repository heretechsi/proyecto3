const imageGallery = document.getElementById("imageGallery");
const fojaInput = document.getElementById("foja");
const yearInput = document.getElementById("year");
const retrocederButton = document.getElementById("retrocederButton");
const avanzarButton = document.getElementById("avanzarButton");
const zoomInButton = document.getElementById("zoomInButton");
const zoomOutButton = document.getElementById("zoomOutButton");
const registroSelect = document.getElementById("registro");
const cantidadArchivosCargados = document.getElementById("cantidadArchivosCargados");

let currentFoja = 1;
let currentVersion = ".1";
let currentZoom = 1;

function showImage() {
    const selectedYear = yearInput.value;
    const selectedFoja = parseInt(fojaInput.value);
    const selectedRegistro = registroSelect.value;

    const imageUrl = `${selectedRegistro}/${selectedYear}/${selectedFoja}${currentVersion}.jpg`;
    const imageElement = document.createElement("img");
    imageElement.src = imageUrl;
    imageElement.style.transform = `scale(${currentZoom})`;
    imageElement.onerror = () => {
        alert("No se encontró la imagen.");
    };

    imageGallery.innerHTML = "";
    imageGallery.appendChild(imageElement);
}

function updateFojaInput() {
    fojaInput.value = currentFoja + currentVersion;
}

retrocederButton.addEventListener("click", () => {
    if (currentVersion === ".2") {
        currentVersion = ".1";
    } else {
        currentFoja--;
        currentVersion = ".2";
    }
    updateFojaInput();
    showImage();
});

avanzarButton.addEventListener("click", () => {
    if (currentVersion === ".1") {
        currentVersion = ".2";
    } else {
        currentFoja++;
        currentVersion = ".1";
    }
    updateFojaInput();
    showImage();
});

zoomInButton.addEventListener("click", () => {
    currentZoom += 0.1;
    showImage();
});

zoomOutButton.addEventListener("click", () => {
    if (currentZoom > 0.1) {
        currentZoom -= 0.1;
    }
    showImage();
});

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const anno = urlParams.get('anno');
    const tipoRegistro = urlParams.get('tipoRegistro');
    const fojaInicial = urlParams.get('foja');
    const cantidad = urlParams.get('cantidad');

    yearInput.value = anno;
    registroSelect.value = tipoRegistro;
    fojaInput.value = fojaInicial;
    currentFoja = parseInt(fojaInicial);
    currentVersion = fojaInicial.includes("v") ? ".2" : ".1";
    cantidadArchivosCargados.textContent = `Imágenes cargadas: ${cantidad}`;

    showImage();
});


function cerrar() {
    window.close();
}

document.addEventListener("DOMContentLoaded", function() {
    const cerrarButton = document.getElementById("cerrarButton");
    cerrarButton.addEventListener("click", cerrar);
});