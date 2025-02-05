<?php
//DAVID ROMERO

//Funcions internes del php per poder sortir del compte
if(session_start()){
    session_unset();
    session_destroy();
}

header('Location:../vista/login.php');
?>

