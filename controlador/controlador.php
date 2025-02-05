<?php
//DAVID ROMERO
include_once '../model/model.php'; //Crida al fitxer model per poder accedir a les funcions del mateix.
require_once '../database/connexio.php';

$crudSubmit = $_POST['Enviar'] ?? null; //Funcio per seleccionar depenent del que hagi triat l'usuari (ediar, inserir...)
//Variables dels articles
$id = $_POST['id'] ?? null;
$model = $_POST['model'] ?? null;
$nom = $_POST['nom'] ?? null;
$preu = $_POST['preu'] ?? null;

//Variables dels usuaris



//variable del login
$login = $_POST['login'] ?? null;

//Variable per verificar la contrassenya al signup

$contrassenyaCanviar = $_POST['contrassenyaCanviar'] ?? null; //Variable per la nova contrassenya en cas de voler canviar-la

$contrassenyaReiniciada = $_POST['contrassenyaReiniciada1'] ?? null; //Link contrassenya despres del correu
$botoContrassenyaReiniciada = $_POST['contrassenyaReiniciada'] ?? null;
$missatges = []; //Gestió de missatges / errors.


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($login) {
        case 'Sign up':
            $imatgePerfil = $_POST['imagenPerfil'] ?? null;
            require_once 'controlador-signup.php';
            break;
    }

    //A l'hora de l'usuari (un cop logat) vol fer qualsevol cosa, aqui la controlem.
    switch ($crudSubmit) {
        case 'Insertar': //En cas d'insertar
            include_once '../vista/insertar.php';
            if (verificarInsertar($model, $nom, $preu, $connexio) == true) { //Aqui verifiquem si el model que hem inserit ja existeix a la base de dades
                $missatges[] = "Aquest producte ja existeix";
            } else {
                if (!empty($model) && !empty($nom) && !empty($preu)) {
                    insertar($model, $nom, $preu, $_SESSION['correu'], $connexio); //Amb el correu de la persona logada que l'hagi inserit
                } else {
                    $missatges[] = "Has d'omplir tots els camps";
                }
            }

            mostrarMissatges($missatges);
            break;
            //En cas de voler modificar
        case 'Modificar':
            include_once '../vista/modificar.php';
            if ($id) {
                if (verificarID($id, $connexio)) { //verifiquem que l'id de l'article que vol verificar no sigui buit
                    if (isset($_SESSION['usuari'])) { //En cas d'estar logat, només deixarà modificar l'article creat per aquest mateix usuari
                        modificar($model, $nom, $preu, $id, getCorreuByID($id, $connexio), $connexio);
                    }
                } else {
                    $missatges[] = "No s'ha trobat l'ID $id";
                }
            } else {
                $missatges[] = "Has d'inserir l'ID";
            }

            mostrarMissatges($missatges);
            break;
        case 'Eliminar':
            include_once '../vista/eliminar.php';
            //pel cas d'eliminar
            if ($id) { //si l'id no es buit
                if (verificarID($id, $connexio)) { //verifiquem que l'id existeixi
                    if (eliminar($connexio, $id)) { //i si existeix, l'elimina
                        $missatges[] = "Eliminat correctament ID: $id";
                    } else {
                        $missatges[] = "No s'ha pogut eliminar...";
                    }
                } else {
                    //En cas de no haver trobat l'id
                    $missatges[] = "No s'ha trobat l'ID $id";
                }
            }

            mostrarMissatges($missatges);
            break;
    }
}

function mostrarMissatges($missatges)
{
    foreach ($missatges as $missatge) {
        echo '<div class="feedback">' . htmlspecialchars($missatge) . '</div>';
    }
}
