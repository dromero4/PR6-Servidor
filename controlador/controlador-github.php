<?php 
if(isset($_SESSION['usuari'])){
    Header('Location: ../index.php');
    exit();
}

require_once '../composer/vendor/autoload.php';
require_once '../model/model.php';

session_start();

use Hybridauth\Hybridauth;

try {

    
    // Configuración de HybridAuth para GitHub
    $hybridauth = new Hybridauth([
        'callback' => 'http://' . $_SERVER['HTTP_HOST'] . '/Servidor/PR4-NEW/controlador/controlador-github.php',  // Cambia la URL si es necesario
        'providers' => [
            'GitHub' => [
                'enabled' => true,
                'keys' => [
                    'id' => 'Ov23limoEPaAyXRPkHGW', 
                    'secret' => '2f04495f356c9fb7e1ab86fedf77e3d8f56e75fe',
                ], 
                'scope' => 'user:email',            
            ]
        ]
    ]);

    

    // Si no hay un código, autenticamos al usuario
    if (!isset($_GET['code'])) {
        $hybridauth->authenticate('GitHub');
        exit();  // Importante: esto asegura que la autenticación ocurra solo una vez
    }

    

    // Si el código ya está presente, obtenemos el perfil del usuario de GitHub
    $github = $hybridauth->getAdapter('GitHub');
    $code = $_GET['code'];
    $state = $_GET['state'];
    
    $token = $github->getAccessToken();
    
    $userProfile = $github->getUserProfile();

    if (isset($_GET['state']) && $_GET['state'] === $_SESSION['oauth_state']) {
        // Redirigimos al usuario a la página principal
        header('Location: index.php');
        exit();
    } else {
        die('El valor de state no es válido o no coincide.');
    }

    // Llamamos a la función para registrar o autenticar al usuario en nuestro sistema
    loginSocialProviderUser($connexio, $userProfile->email, $userProfile->displayName, $userProfile->photoURL);
    
    // Guardamos los detalles del usuario en variables de sesión
    $_SESSION['usuari'] = $userProfile->displayName;
    $_SESSION['fotoPerfil'] = $userProfile->photoURL;
    $_SESSION['correu'] = $userProfile->email;

    header('Location: ../index.php');

    

} catch (Exception $e) {
    die("No se pudo conectar con GitHub: {$e->getMessage()}");
}

?>
