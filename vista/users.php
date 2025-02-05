<?php 
session_start();
include_once 'navbar.view.php';
require_once '../model/model.php';
require_once __DIR__ . '/../database/env.php';
require_once BASE_PATH . '/database/connexio.php';

$usuarios = mostrarDadesUsuaris($connexio);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuaris</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="h3 text-light m-5">Usuaris</div>
    <table class="table table-hover mt-5 mb-5 w-25 mx-auto">
        <thead>
            <tr>
                <th class="text-center">Imatge</th>
                <th class="text-center">Correu</th>
                <th class="text-center">Usuari</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($usuarios as $index => $user): ?>
            <tr>
                <td class="text-center m-2">
                    <img src="<?= !empty($user['profileImg']) ? htmlspecialchars($user['profileImg']) : '../imagenes/fotoPredeterminada.webp'; ?>" 
                    alt="Foto de perfil" style="width: 45px; height: 45px;">
                </td>

                <td class="text-center m-2"><?= htmlspecialchars($user["correu"]) ?? "Correu no disponible"; ?></td>
                <td class="text-center m-2"><?= htmlspecialchars($user["usuari"]) ?? "Usuari no disponible"; ?></td>

                <!-- Solo funciona si el usuario se llama admin (se tiene que llamar asi si o si asi que no hay problema) -->
                <td class="text-center m-3">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#eliminarUsuari<?= $index; ?>" <?= ($user['usuari'] == 'admin') ? 'disabled' : ''; ?>>
                        <img src="../imagenes/icones/trash.svg">
                    </button>
                   
                    <!-- Modal -->
                    <div class='modal fade' id='eliminarUsuari<?= $index; ?>'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h3 class='modal-title'>Esborrar usuari</h3>
                                </div>
                                <div class='modal-body'>
                                    Estas segur que vols eliminar aquest usuari?
                                </div>
                                <div class='modal-footer'>
                                    <form action='../controlador/controlador-cards.php' method='post' class='cards-form'>
                                        <input type="hidden" name="article-button-mail" value="<?= htmlspecialchars($user['correu']); ?>">
                                        <button type='submit' data-bs-dismiss='modal' name='article-button' value='deleteUser'>Si</button>
                                        <button type='button' data-bs-dismiss='modal'>No</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <tbody>
    </table>
</body>
</html>