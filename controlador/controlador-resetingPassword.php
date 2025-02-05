<?php
require_once '../model/model.php';
include_once 'controlador.php';
include_once '../vista/resetingPassword.php';
require_once __DIR__ . '/../database/env.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['token'])) {
        $correu = $_POST['email'];
        $token = $_POST['token'];
        $new_contrassenya = $_POST['contrassenyaReiniciada1'];
        $new_contrassenya2 = $_POST['contrassenyaReiniciada2'];

        if(verificarToken($token, $correu, $connexio)){
            if(verificarContrassenya($new_contrassenya) && verificarContrassenya($new_contrassenya2)){
                if($new_contrassenya == $new_contrassenya2){
                    if(updatePassword($correu, $new_contrassenya, $connexio)){
                        $missatges[] = "Contrassenya canviada correctament.";
                                                
                    } else {
                        $missatges[] = "La contrassenya no s'ha pogut recuperar...";
                    }
                } else {
                    $missatges[] = "Les contrassenyes no coincideixen.";
                }
            } else {
                $missatges[] = "<br>La contrassenya ha de tenir:
                    <br>- Al menys 5 caràcters.
                    <br>- Al menys una lletra majuscula.
                    <br>- Al menys una lletra minúscula.
                    <br>- Al menys un numero.
                    <br>- Al menys un caràcter especial.";
            }
        } else {
            $missatges[] = "Token no vàlid";
        }

        
    }

    mostrarMissatges($missatges);
}
?>
