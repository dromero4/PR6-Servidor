<?php
session_start();
include_once '../vista/navbar.view.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear article per QR</title>
    <link rel="stylesheet" href="../css/qr-styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <h2 class="h2 mt-5 text-light">QR READER</h2>
    <form action="../controlador/controlador-qr.php" method="post" enctype="multipart/form-data">
        <input type="file" name="qrFileRead" accept="image/*">
        <input type="submit" class="mt-3" value="Leer QR">
    </form>

</body>

</html>