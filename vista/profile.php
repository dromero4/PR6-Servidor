<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'navbar.view.php';
include_once '../controlador/controlador.php';
require_once '../database/connexio.php';

$imageUrl = getImage($connexio, $_SESSION['correu']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile-styles.css">
    <script defer src="../JavaScript/profile-js.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="profile-box">
        <form id="profileForm" action="<?php echo htmlspecialchars(dirname($_SERVER['PHP_SELF']) . '/../controlador/controlador-profile.php'); ?>" method="POST" enctype="multipart/form-data">
            <h2 class="text-center">Hola, <?php echo $_SESSION['usuari']; ?></h2><br>

            <hr style="border: 1px solid black;"><br>
            
            <!-- Imagen de perfil -->
            <div class="input-group">
                <?php
                    if ($imageUrl) {
                        // Mostramos la imagen usando la URL obtenida
                        echo '<img id="fotoPerfilActual" src="' . htmlspecialchars($imageUrl) . '" alt="Foto de perfil" width="150px" style="border-radius: 60%;">';

                    } else {
                        // Si no hay imagen, mostramos una imagen predeterminada o un placeholder
                        echo '<img id="fotoPerfilActual" src="../imagenes/fotoPredeterminada.webp" width="150px">';
                    }
                    ?>
                </div>
            

            <div class="input-group">
                <label for="usuariPerfil">Usuari:
                    <input type="text" id="usuariPerfil" name="usuariPerfil" value="<?php echo $_SESSION['usuari']; ?>" disabled>
                </label>
            </div>

            <div class="input-group">
                <label for="correuPerfil">Correu:
                    <input type="text" id="correuPerfil" name="correuPerfil" value="<?php echo $_SESSION['correu']; ?>" disabled>
                </label>
            </div>

            <div class="input-group">
                <label for="imatge">Imatge: 
                <input type="text" id="botonSubirImagen" name="imagen" placeholder="URL de la imatge" disabled>
                </label>
            </label>
            </div>
            

            <button type="button" id="botoEditarFotoPerfil">&#9998; Editar</button>
            <button type="submit" id="guardarCanvis" name="guardarCanvis" style="display: none">Guardar canvis</button>
        </form>
    </div>
</body>
</html>

