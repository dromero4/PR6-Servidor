<?php
//En cas de ser totes les variables omplertes
if (!empty($usuari) && !empty($contrassenya) && !empty($correu)) {
    //encriptem la contrassenya a hash per així ja tenir la contrassenya encriptada
    $contrassenyaHash = password_hash($contrassenya, PASSWORD_DEFAULT);

    // include_once '../vista/signup.php';
    //Verifiquem si el correu es més llarg de 40 caràcters
    if (strlen($correu) > 40) {
        $missatges[] = "El correu ha de tenir menys de 40 caràcters...";
    } else if (verificarCorreu($correu, $connexio)) { //Verifiquem si ja existeix el correu
        $missatges[] = "El correu ja existeix";
    } else {
        if (strlen($usuari) > 20) { //verifiquem que no sigui massa llarg el nom d'usuari
            $missatges[] = "El nom d'usuari ha de tenir menys de 20 caràcters...";
        } else if (verificarUsuari($usuari, $connexio)) { //I verifiquem que no existeixi previament
            $missatges[] = "El nom d'usuari ja existeix";
        } else {
            if ($contrassenya == $contrassenya2) { //Al cas de confirmar la contrassenya
                if (verificarContrassenya($contrassenya)) { //Verifiquem que la contrassenya compleixi certs valors.
                    $missatges[] = 'La contrassenya ha de tenir: Al menys 5 caràcters, al menys una lletra majuscula, 
                una lletra minuscula, un numero i un caràcter especial';
                } else {
                    if (insertarUsuari($correu, $usuari, $contrassenyaHash, $imatgePerfil, $connexio)) { //En cas de ser tot correcte, inserim l'usuari a la base de dades amb la contrassenya encriptada
                        $missatges[] =  "Usuari creat correctament";
                    } else {
                        //En cas d'haver algun error
                        $missatges[] =  "No s'ha pogut crear l'usuari";
                    }
                }
            } else {
                //En cas de no ser les contrassenyes de registre iguals
                $missatges[] = "Les contrassenyes han de ser iguals...";
            }
        }
    }
} else {
    //En cas de no haver omplert les dades
    $missatges[] = "<br>Has d'introduïr les dades...";
}
include_once '../vista/signup.php';
mostrarMissatges($missatges);
?>
<a href="../vista/login.php"><button>Fes login</button></a>