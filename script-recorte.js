let fojaInicialRecortada = null; // Variable para almacenar la imagen recortada en base64

window.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('fojaInicialCanvas');
    const context = canvas.getContext('2d');
    let image = new Image();
    let startX = 0;
    let startY = 0;
    let endX = 0;
    let endY = 0;
    let isDrawing = false;
    
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const imgPath = decodeURIComponent(urlParams.get('imgPath'));

    image.onload = function () {
        const maxWidth = 1920;
        const maxHeight = 1080;

        let width = image.width;
        let height = image.height;
        if (width > maxWidth || height > maxHeight) {
            if (width / height > maxWidth / maxHeight) {
                height = Math.round((height * maxWidth) / width);
                width = maxWidth;
            } else {
                width = Math.round((width * maxHeight) / height);
                height = maxHeight;
            }
        }

        canvas.width = width;
        canvas.height = height;
        context.drawImage(image, 0, 0, width, height);
    };

    image.src = imgPath;

    canvas.addEventListener('mousedown', (event) => {
        startX = event.offsetX;
        startY = event.offsetY;
        isDrawing = true;
    });

    canvas.addEventListener('mousemove', (event) => {
        if (isDrawing) {
            endX = event.offsetX;
            endY = event.offsetY;
            context.drawImage(image, 0, 0, canvas.width, canvas.height);
            context.strokeStyle = 'silver';
            context.lineWidth = 2;
            context.strokeRect(startX, startY, endX - startX, endY - startY);
        }
    });

    canvas.addEventListener('mouseup', (event) => {
        isDrawing = false;
        endX = Math.min(Math.max(event.offsetX, 0), canvas.width);
        endY = Math.min(Math.max(event.offsetY, 0), canvas.height);
        // Ajustar startX y endX para abarcar toda la imagen en el eje X
        startX = 0;
        endX = canvas.width;
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.drawImage(image, 0, 0, canvas.width, canvas.height);
        context.strokeStyle = 'silver';
        context.lineWidth = 2;
        context.strokeRect(startX, startY, endX - startX, endY - startY);
    });
    
    document.getElementById('saveButton').addEventListener('click', () => {
        const width = endX - startX;
        const height = endY - startY;
        const croppedImage = context.getImageData(startX, startY, width, height);
    
        const tempCanvas = document.createElement('canvas');
        const tempContext = tempCanvas.getContext('2d');
        tempCanvas.width = width;
        tempCanvas.height = height;
        tempContext.putImageData(croppedImage, 0, 0);
    
        tempCanvas.toBlob(function (blob) {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                fojaInicialRecortada = reader.result;  // Actualizar la variable global
                localStorage.setItem('fojaInicialRecortada', fojaInicialRecortada); // Guardar en localStorage
                console.log("Imagen recortada almacenada en fojaInicialRecortada:", fojaInicialRecortada);
                alert("El recorte se guardó correctamente.");
                window.close();  // Cerrar la ventana después de guardar
            }
        }, 'image/png');
      

    });
    
});