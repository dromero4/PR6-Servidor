<?php
include_once 'controlador.php';
include_once '../vista/forgotPassword.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($correu)){
        if(verificarCorreu($correu, $connexio)){
            if(enviarMail($correu, $connexio)){
                $missatges[] = "Verifica el teu correu ($correu), t'hem enviat un ellaç perquè puguis reestablir la teva contrassenya...";
            } else {
                $missatges[] = "Error al enviar el correu";
            }
            
        } else {
            $missatges[] = "El correu no existeix";
        }
    } else {
        $missatges[] = "Has d'omplir el correu";
    }
    
    mostrarMissatges($missatges);
} else {
    echo "Hi ha hagut un error";
}

?>