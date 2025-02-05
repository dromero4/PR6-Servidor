<?php
require_once '../model/model.php';
require_once '../database/env.php';
require_once BASE_PATH . 'database/connexio.php';
include_once '../controlador/controlador.php';

$opcio = $_POST['article-button'] ?? null;

switch ($opcio){
    case 'delete':
        $id = $_POST['id'] ?? null;
        if($id){ //si l'id no es buit
            if(eliminar($connexio, $id)){ //i si existeix, l'elimina
                $missatges[] = "Eliminat correctament ID: $id";
            } else {
                $missatges[] = "No s'ha pogut eliminar...";
            }
        }
        header('Location: ../index.php');
        break;

    case 'deleteUser':
        $correu = $_POST['article-button-mail'];
        deleteUser($connexio, $correu);

        header('Location: ../vista/users.php');
        break;
}
?>