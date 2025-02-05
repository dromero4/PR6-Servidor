<?php
session_start();
require_once '../lib/vendor/autoload.php';

use Zxing\QrReader;

require_once '../model/model.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_qr = htmlspecialchars($_GET['id']);
    $model_qr = htmlspecialchars($_GET['model']);
    $nom_qr = htmlspecialchars($_GET['nom']);
    $preu_qr = htmlspecialchars($_GET['preu']);
    $correu_qr = htmlspecialchars($_GET['correu']);

    $qr_link = "https://www.davidromero.cat/vista/vista-qr.php?id=$id_qr&model=$model_qr&nom=$nom_qr&preu=$preu_qr&correu=$correu_qr";

    $show_qr = showQR($qr_link);
    include_once '../vista/vista-qr.php';
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Ruta temporal del archivo subido
    $imagePath = $_FILES['qrFileRead']['tmp_name'];

    // Asegúrate de que el archivo es una imagen válida
    $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
    if (!in_array($_FILES['qrFileRead']['type'], $allowedTypes)) {
        echo 'Por favor, sube una imagen válida (PNG o JPG).';
        exit;
    }


    // Crear el lector QR y leer la imagen
    $qrReader = new QrReader($imagePath);

    // Obtener el texto del QR
    $text = $qrReader->text();

    // Mostrar el resultado
    if ($text !== false) {
        header('Location: ' . $text);
    } else {
        echo 'No se pudo decodificar el QR.';
    }
} else {
    echo 'Por favor, selecciona un archivo QR para subir.';
}
