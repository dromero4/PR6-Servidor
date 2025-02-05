<?php
include_once '../vista/navbar.view.php';
include_once '../vista/reiniciarPassword.php';
include_once '../model/model.php';
require_once '../controlador/controlador.php';

if(!empty($contrassenya) && !empty($contrassenyaCanviar)){
    if(verificarCompteCorreu($_SESSION['correu'], $contrassenya, $connexio)){
        if(verificarContrassenya($contrassenyaCanviar)){
            if(reiniciarPassword($_SESSION['correu'], $contrassenya, $contrassenyaCanviar, $connexio)){
                $missatges[] = "Password canviada correctament";
            } else {
                $missatges[] = "No s'ha pogut canviar la contrassenya";
            }
        } else {
            $missatges[] = 'La contrassenya no és vàlida<br>
                            Ha de tenir com a minim:<br>
                                - 5 caràcters<br>
                                - Una lletra majuscula<br>
                                - Una lletra minuscula<br>
                                - Un numero<br>
                                - Un caràcter especial';
        }
    } else {
        $missatges[] = "Contrassenya incorrecte";
    }
} else {
    $missatges[] = "Has d'omplir els camps";
}


mostrarMissatges($missatges);
?>