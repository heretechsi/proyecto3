const imageGallery = document.getElementById("imageGallery");
const fojaInput = document.getElementById("foja");
const yearInput = document.getElementById("year");
const retrocederButton = document.getElementById("retrocederButton");
const avanzarButton = document.getElementById("avanzarButton");
const zoomInButton = document.getElementById("zoomInButton");
const zoomOutButton = document.getElementById("zoomOutButton");
const registroSelect = document.getElementById("registro");

let currentImageIndex = 0;
let imageList = [];
let currentZoom = 1;

const suffixToVersion = {
    "": ".1",
    "v": ".2",
    "bis": ".3",
    "bisv": ".4",
    "bis2": ".5",
    "bis2v": ".6",
    "bis3": ".7",
    "bis3v": ".8",
};

const versionToSuffix = { // Mapeo inverso para mostrar en el input
    ".1": "",
    ".2": "v",
    ".3": "bis",
    ".4": "bisv",
    ".5": "bis2",
    ".6": "bis2v",
    ".7": "bis3",
    ".8": "bis3v",
};

function getImageList(callback) {
    const selectedYear = yearInput.value;
    const selectedRegistro = registroSelect.value;
    const folderPath = `upload/${selectedRegistro}/${selectedYear}/`;

    fetch(`listImages.php?folder=${encodeURIComponent(folderPath)}`)
        .then(response => response.json())
        .then(data => {
            imageList = (data.images || []).sort((a, b) => {
                const aFoja = parseInt(a.split("/").pop().replace(".jpg", "").split(".")[0]);
                const bFoja = parseInt(b.split("/").pop().replace(".jpg", "").split(".")[0]);
                return aFoja - bFoja;
            });
            callback();
        })
        .catch(error => {
            console.error("Error al obtener la lista de imágenes:", error);
            imageList = [];
            callback();
        });
}

function showCurrentImage() {
    if (imageList.length === 0) {
        showDefaultImage();
        return;
    }

    const imgPath = imageList[currentImageIndex];
    const imgElement = document.createElement("img");
    imgElement.src = imgPath;

    imageGallery.innerHTML = "";
    imageGallery.appendChild(imgElement);

    // Actualizar el campo "foja" con el formato correcto
    const fileName = imgPath.split("/").pop().replace(".jpg", "");
    const baseFoja = fileName.split(".")[0];
    const version = "." + fileName.split(".")[1];
    const suffix = versionToSuffix[version] || ""; // Obtener el sufijo
    fojaInput.value = baseFoja + suffix; // Mostrar en el input con el formato X, Xv, Xbis, etc.

    updateZoom();
    updateButtons(); // Actualizar botones
}

function showDefaultImage() {
    const imgElement = document.createElement("img");
    imgElement.src = "images/defaultImage.jpg";
    imageGallery.innerHTML = "";
    imageGallery.appendChild(imgElement);
    fojaInput.value = "";
    updateZoom();
    updateButtons(); // Actualizar botones
}

function avanzar() {
    if (currentImageIndex < imageList.length - 1) {
        currentImageIndex++;
        showCurrentImage();
    }
}

function retroceder() {
    if (currentImageIndex > 0) {
        currentImageIndex--;
        showCurrentImage();
    }
}

function buscarFoja() {
    const inputFoja = fojaInput.value.toLowerCase();
    const suffix = inputFoja.replace(/[0-9]/g, "");
    const baseFoja = parseInt(inputFoja);

    if (!isNaN(baseFoja)) {
        const version = suffixToVersion[suffix] || ".1";
        const imageName = `${baseFoja}${version}.jpg`;
        const imagePath = `upload/${registroSelect.value}/${yearInput.value}/${imageName}`;

        const index = imageList.indexOf(imagePath);
        if (index !== -1) {
            currentImageIndex = index;
            showCurrentImage();
        } else {
            showDefaultImage();
        }
    }
}

function zoomIn() {
    currentZoom += 0.1;
    updateZoom();
}

function zoomOut() {
    currentZoom -= 0.1;
    updateZoom();
}

function updateZoom() {
    const img = document.querySelector("#imageGallery img");
    if (img) {
        img.style.transform = `scale(${currentZoom})`;
        img.style.transformOrigin = 'top left';
        adjustScrollPosition();
    }
}

function adjustScrollPosition() {
    const img = document.querySelector("#imageGallery img");
    if (img) {
        const imageGalleryRect = imageGallery.getBoundingClientRect();
        const imgRect = img.getBoundingClientRect();
        const offsetTop = imgRect.top - imageGalleryRect.top;
        imageGallery.scrollTop += offsetTop;
    }
}

function updateButtons() {
    retrocederButton.disabled = currentImageIndex <= 0;
    avanzarButton.disabled = currentImageIndex >= imageList.length - 1;
}


yearInput.addEventListener("input", () => getImageList(showCurrentImage));
fojaInput.addEventListener("input", buscarFoja);
retrocederButton.addEventListener("click", retroceder);
avanzarButton.addEventListener("click", avanzar);
zoomInButton.addEventListener("click", zoomIn);
zoomOutButton.addEventListener("click", zoomOut);
registroSelect.addEventListener("change", () => getImageList(showCurrentImage));

getImageList(showCurrentImage);

// Abre una nueva ventana con la sección de cargar registros
function openImageUploadPage() {
    window.open("./upload", "_blank");
}

// Abre una nueva ventana con la sección de preparar copia
function openCopiaPage() {
    window.open("./prepararcopia.php", "_blank");
}

// Capturar eventos del teclado para navegar con flechas y evitar desplazamiento lateral
document.addEventListener("keydown", function(event) {
    if (event.key === "ArrowRight" || event.key === "ArrowLeft") {
        event.preventDefault(); // Bloquea el desplazamiento horizontal
        if (event.key === "ArrowRight") {
            avanzar();
        } else if (event.key === "ArrowLeft") {
            retroceder();
        }
    }
});
