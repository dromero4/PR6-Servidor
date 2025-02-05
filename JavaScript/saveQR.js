"use strict";

document.getElementById("save").addEventListener("click", function () {
    // Construir el nombre del archivo utilizando las variables de PHP
    const filename = `${qrData.model}_${qrData.name}_${qrData.id}.jpeg`;

    // Obtener el elemento del código QR
    const qrImageElement = document.querySelector("#qrImage img");
    if (!qrImageElement) {
        console.error("No se encontró la imagen del QR.");
        return;
    }

    // Crear un canvas para convertir la imagen del QR en formato descargable
    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");

    // Cargar la imagen en un objeto Image
    const qrImage = new Image();
    qrImage.crossOrigin = "anonymous"; // Asegurar que no haya problemas de CORS
    qrImage.src = qrImageElement.src;

    qrImage.onload = function () {
        // Ajustar las dimensiones del canvas al tamaño de la imagen
        canvas.width = qrImage.width;
        canvas.height = qrImage.height;

        // Dibujar la imagen en el canvas
        ctx.drawImage(qrImage, 0, 0);

        // Descargar la imagen usando la función `download`
        download(filename, canvas);
    };

    qrImage.onerror = function () {
        console.error("No se pudo cargar la imagen del QR.");
    };
});

function download(filename, canvas) {
    // Crear un link "fantasma" (no se añade realmente al documento)
    const a = document.createElement("a");

    // Establecer la URL como la imagen del canvas en formato base64
    a.href = canvas.toDataURL("image/jpeg", 0.95);

    // Indicar el nombre del archivo a descargar
    a.download = filename;

    // Simular un clic en el enlace
    a.click();

    // Liberar la URL generada
    URL.revokeObjectURL(a.href);
}
