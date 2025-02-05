<?php
session_start();
require_once '../model/model.php';  // Incluye el modelo que maneja las consultas a la base de datos
include_once '../controlador/controlador.php';
require_once '../database/connexio.php';

// Inicializar variable para mensajes
$missatges = [];

// Comprobar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los datos enviados por el formulario
    $usuari = $_POST['usuariPerfil'] ?? null;
    $correu = $_POST['correuPerfil'] ?? null;
    $fotoPerfil = $_POST['imagen'] ?? null; // Foto de perfil proporcionada por el formulario

    // Verificar que el usuario y correo son válidos
    if ($usuari && $correu) {
        // Comprobar si el usuario o correo han cambiado y realizar las actualizaciones necesarias
        $actualitzarUsuari = false;
        $actualitzarCorreu = false;
        $actualitzarFoto = false;

        // Verificar si el usuario ha cambiado
        if ($usuari != $_SESSION['usuari']) {
            if(verificarUsuari($usuari, $connexio)) {
                $missatges[] = "El usuario ya existe"; // El usuario ya está registrado
            } else {
                $actualitzarUsuari = true;  // El usuario no existe, se puede proceder con la actualización
            }
        }

        // Verificar si el correo ha cambiado
        if ($correu != $_SESSION['correu']) {
            if(verificarCorreu($correu, $connexio)){
                $missatges[] = "El correo electrónico ya existe en el sistema";
            } else {
                $actualitzarCorreu = true;
            }
        }

        // Verificar si la imagen ha cambiado (y es válida)
        if ($fotoPerfil && $fotoPerfil != $_SESSION['fotoPerfil']) {
            if(verificarImatge($fotoPerfil)){
                $actualitzarFoto = true;
            } else {
                $missatges[] = "La imagen no es válida.";
            }
        } else {
            // Si no hay nueva imagen, no actualices la foto de perfil
            $fotoPerfil = $_SESSION['fotoPerfil'];  // Mantener la foto actual si no se proporciona una nueva
        }

        // Solo intentar actualizar si algún campo ha cambiado
        if ($actualitzarUsuari || $actualitzarCorreu || $actualitzarFoto) {
            // Intentar actualizar el usuario
            if (actualitzarUsuari($connexio, $usuari, $correu, $_SESSION['correu'], $fotoPerfil)) {
                // Actualizar datos en la sesión
                $_SESSION['usuari'] = $usuari ?: $_SESSION['usuari'];
                $_SESSION['correu'] = $correu ?: $_SESSION['correu'];
                $_SESSION['fotoPerfil'] = $fotoPerfil; // Mantener la foto actualizada

                // Si la cookie existe, actualizarla también
                if (isset($_COOKIE['cookie_user'])) {
                    setcookie('cookie_user', $usuari, time() + (86400 * 30 * 30 * 24), "/");  // 30 días de validez
                }

                // Mensaje de éxito
                $missatges[] = "S'ha actualitzat correctament!";
            } else {
                // Mensaje de error si no se pudo actualizar
                $missatges[] = "No s'ha pogut actualitzar el perfil.";
            }
        } else {
            // Si no hubo cambios
            $missatges[] = "No s'han realitzat canvis.";
        }
    } else {
        // Si faltan datos
        $missatges[] = "Datos inválidos o incompletos.";
    }

    include_once '../vista/profile.php';
    // Mostrar los mensajes
    mostrarMissatges($missatges);
    
    // Redirigir a la página de perfil después de procesar el formulario
    // header("Location: ../vista/profile.php");
    exit;  // Asegúrate de que el script se detenga aquí después de la redirección
}

function verificarImatge($imatge){
    if(!filter_var($imatge, FILTER_VALIDATE_URL)){
        return false;
    } else {
        return true;
    }
}
