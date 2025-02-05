<?php
// Usar la clase QRCode de chillerlan
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//DAVID ROMERO
//Funcio per insertar l'article a la base de dades. També mostra l'ID.
function insertar($model, $nom, $preu, $correu, $connexio)
{
    try {
        $insertarArticle = $connexio->prepare("INSERT INTO articles (model, nom, preu, correu) VALUES(:model, :nom, :preu, :correu)");
        $insertarArticle->bindParam(":model", $model);
        $insertarArticle->bindParam(":nom", $nom);
        $insertarArticle->bindParam(":preu", $preu);
        $insertarArticle->bindParam(":correu", $correu);
        $insertarArticle->execute();

        $ultimID = $connexio->lastInsertId();
        echo "Inserit correctament! ID: $ultimID";
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

//Verifica si l'article que vols inserir no existeixi a la base de dades
function verificarInsertar($model, $nom, $preu, $connexio)
{
    try {
        $verificar = false;
        $verificarInsertar = $connexio->prepare("SELECT * FROM articles WHERE model = :model AND nom = :nom AND preu = :preu");
        $verificarInsertar->bindParam(":model", $model);
        $verificarInsertar->bindParam(":nom", $nom);
        $verificarInsertar->bindParam(":preu", $preu);
        $verificarInsertar->execute();

        if ($verificarInsertar->rowCount() != 0) {
            $verificar = true;
        }

        return $verificar;
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

//Funcio per modificar un article (en cas de ser el seu)
function modificar($model, $nom, $preu, $id, $correu, $connexio)
{
    try {
        if (!empty($model) && !empty($nom) && !empty($preu)) {
            if ($correu != $_SESSION['correu']) {
                //En cas de no tenir el mateix correu que l'article, no et deixa modificar.
                echo "No pots modificar aquest article perquè no ets el seu propietari";
            } else {
                $modificarDades = $connexio->prepare("UPDATE articles SET model = :model, nom = :nom, preu = :preu WHERE id = $id AND correu = :correu");
                $modificarDades->bindParam(':model', $model);
                $modificarDades->bindParam(':correu', $correu);
                $modificarDades->bindParam(':nom', $nom);
                $modificarDades->bindParam(':preu', $preu);
                $modificarDades->execute();
                include_once '../vista/modificar.php';
                echo "<br>Article amb ID: $id editat correctament";
            }

            //Aqui son comprobacions varies en funcio del que estigui omplert o no, ja que a l'hora de modificar, no has de modificar tot si no vols.
        } else if (!empty($model) && !empty($nom) && empty($preu)) {
            if ($correu != $_SESSION['correu']) {
                //En cas de no tenir el mateix correu que l'article, no et deixa modificar.
                echo "No pots modificar aquest article perquè no ets el seu propietari";
            } else {
                $modificarDades = $connexio->prepare("UPDATE articles SET model = :model, nom = :nom WHERE id = $id AND correu = :correu");
                $modificarDades->bindParam(':model', $model);
                $modificarDades->bindParam(':correu', $correu);
                $modificarDades->bindParam(':nom', $nom);
                $modificarDades->execute();
                include_once '../vista/modificar.php';
                echo "<br>Article amb ID: $id editat correctament";
            }
        } else if (!empty($model) && !empty($preu) && empty($nom)) {
            if ($correu != $_SESSION['correu']) {
                //En cas de no tenir el mateix correu que l'article, no et deixa modificar.
                echo "No pots modificar aquest article perquè no ets el seu propietari";
            } else {
                $modificarDades = $connexio->prepare("UPDATE articles SET model = :model, preu = :preu WHERE id = $id AND correu = :correu");
                $modificarDades->bindParam(':model', $model);
                $modificarDades->bindParam(':correu', $correu);
                $modificarDades->bindParam(':preu', $preu);
                $modificarDades->execute();
                include_once '../vista/modificar.php';
                echo "<br>Article amb ID: $id editat correctament";
            }
        } else if (!empty($nom) && !empty($preu) && empty($model)) {
            if ($correu != $_SESSION['correu']) {
                //En cas de no tenir el mateix correu que l'article, no et deixa modificar.
                echo "No pots modificar aquest article perquè no ets el seu propietari";
            } else {
                $modificarDades = $connexio->prepare("UPDATE articles SET nom = :nom, preu = :preu WHERE id = $id AND correu = :correu");
                $modificarDades->bindParam(':nom', $nom);
                $modificarDades->bindParam(':correu', $correu);
                $modificarDades->bindParam(':preu', $preu);
                $modificarDades->execute();
                include_once '../vista/modificar.php';
                echo "<br>Article amb ID: $id editat correctament";
            }
        } else if (!empty($nom) && empty($preu) && empty($model)) {
            if ($correu != $_SESSION['correu']) {
                //En cas de no tenir el mateix correu que l'article, no et deixa modificar.
                echo "No pots modificar aquest article perquè no ets el seu propietari";
            } else {
                $modificarDades = $connexio->prepare("UPDATE articles SET nom = :nom WHERE id = $id AND correu = :correu");
                $modificarDades->bindParam(':nom', $nom);
                $modificarDades->bindParam(':correu', $correu);
                $modificarDades->execute();
                include_once '../vista/modificar.php';
                echo "<br>Article amb ID: $id editat correctament";
            }
        } else if (!empty($preu) && empty($nom) && empty($model)) {
            if ($correu != $_SESSION['correu']) {
                //En cas de no tenir el mateix correu que l'article, no et deixa modificar.
                echo "No pots modificar aquest article perquè no ets el seu propietari";
            } else {
                $modificarDades = $connexio->prepare("UPDATE articles SET preu = :preu WHERE id = $id AND correu = :correu");
                $modificarDades->bindParam(':preu', $preu);
                $modificarDades->bindParam(':correu', $correu);
                $modificarDades->execute();
                include_once '../vista/modificar.php';
                echo "<br>Article amb ID: $id editat correctament";
            }
        } else if (!empty($model) && empty($nom) && empty($preu)) {
            if ($correu != $_SESSION['correu']) {
                //En cas de no tenir el mateix correu que l'article, no et deixa modificar.
                echo "No pots modificar aquest article perquè no ets el seu propietari";
            } else {
                $modificarDades = $connexio->prepare("UPDATE articles SET model = :model WHERE id = $id AND correu = :correu");
                $modificarDades->bindParam(':model', $model);
                $modificarDades->bindParam(':correu', $correu);
                $modificarDades->execute();
                include_once '../vista/modificar.php';
                echo "<br>Article amb ID: $id editat correctament";
            }
        } else {
            include_once '../vista/modificar.php';
            echo "<br>No s'ha modificat cap dada";
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

//Funcio per eliminar un article segons l'ID es a un altre lloc

//Funcio per verificar previament si existeix l'ID a la base de dades
function verificarID($id, $connexio)
{
    try {
        $verificar = $connexio->prepare("SELECT * FROM articles WHERE id = :id");
        $verificar->bindParam(":id", $id);
        $verificar->execute();

        if ($verificar->rowCount() == 0) {
            return false;
        } else {
            return true;
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

//Funcio per insertar usuari
function insertarUsuari($correu, $usuari, $contrassenyaHash, $profileImg, $connexio)
{
    try {
        $insertarUsuari = $connexio->prepare("INSERT INTO usuaris(correu, usuari, contrassenya, profileImg) VALUES(:correu, :usuari, :contrassenya, :profileImg)");
        $insertarUsuari->bindParam(":correu", $correu);
        $insertarUsuari->bindParam(":usuari", $usuari);
        $insertarUsuari->bindParam(":contrassenya", $contrassenyaHash);
        $insertarUsuari->bindParam(":profileImg", $profileImg);
        $insertarUsuari->execute();
        if ($insertarUsuari) {
            return true;
        }
    } catch (Error $e) {
        echo $e->getMessage();
    }
}

//Funcio per verificar si el correu existeix a l'hora de registrar-se
function verificarCorreu($correu, $connexio)
{
    try {
        $verificarCorreu = $connexio->prepare("SELECT * FROM usuaris WHERE correu = :correu");
        $verificarCorreu->bindParam(":correu", $correu);
        $verificarCorreu->execute();

        if ($verificarCorreu->rowCount() > 0) {
            return true;
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

//Funcio per verificar si l'usuari existeix a l'hora de registarr-se
function verificarUsuari($usuari, $connexio)
{
    try {
        // Preparar la consulta para verificar si el usuario ya existe
        $verificarUsuari = $connexio->prepare("SELECT * FROM usuaris WHERE usuari = :usuari");
        $verificarUsuari->bindParam(":usuari", $usuari);
        $verificarUsuari->execute();

        // Si la consulta devuelve una fila, significa que el usuario ya está en la base de datos
        if ($verificarUsuari->rowCount() > 0) {
            return true;  // El usuario ya existe
        }

        return false;  // El usuario no existe

    } catch (PDOException $e) {
        // Manejo de excepciones en caso de que falle la consulta
        throw new Exception("Error al verificar el usuario: " . $e->getMessage());
    }
}

//Funcio per verificar si la contrassenya i l'usuari coincideix a l'hora de logar-se
function verificarCompte($usuari, $contrassenya, $connexio)
{
    try {
        $verificarContrassenya = $connexio->prepare("SELECT contrassenya FROM usuaris WHERE usuari = :usuari");
        $verificarContrassenya->bindParam(":usuari", $usuari);
        $verificarContrassenya->execute();

        //Agafem la contrassenya
        $resultat = $verificarContrassenya->fetch(PDO::FETCH_ASSOC);

        if ($resultat) {
            //i la guardem a una variable per poder verificar-la
            $hash = $resultat['contrassenya'];

            //Funcio interna del php per poder verificar una contrassenya que sigui encriptada
            //password_verify NOMES FUNCIONA AMB password_hash();

            if (password_verify($contrassenya, $hash)) {
                return true;
            } else {
                return false;
            }
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

//Funcio per veure si el correu coincideix amb la contrassenya
function verificarCompteCorreu($correu, $contrassenya, $connexio)
{
    try {
        $verificarContrassenya = $connexio->prepare("SELECT contrassenya FROM usuaris WHERE correu = :correu");
        $verificarContrassenya->bindParam(":correu", $correu);
        $verificarContrassenya->execute();

        $resultat = $verificarContrassenya->fetch(PDO::FETCH_ASSOC);

        if ($resultat) {
            $hash = $resultat['contrassenya'];

            //Funcio interna del php per poder verificar una contrassenya que sigui encriptada
            //password_verify NOMES FUNCIONA AMB password_hash();
            if (password_verify($contrassenya, $hash)) {
                return true;
            } else {
                return false;
            }
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

//Funcio per seleccionar el correu en questió de l'usuari que estigui logat
function seleccionarCorreu($usuari, $connexio)
{
    try {
        if (verificarUsuari($usuari, $connexio)) {
            $correo = $connexio->prepare("SELECT correu FROM usuaris WHERE usuari = :usuari");
            $correo->bindParam(":usuari", $usuari);
            $correo->execute();

            $resultat = $correo->fetch(PDO::FETCH_ASSOC);

            return $resultat;
        } else {
            echo "Hi ha hagut un problema";
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

//Funcio per reiniciar el password
//Parametres: 
// correu: correu de l'usuari que vols canviar la contrassenya
// contrassenya: contrassenya actual de l'usuari que hem posat
// contrassenyaCanviar: nova contrassenya
function reiniciarPassword($correu, $contrassenya, $contrassenyaCanviar, $connexio)
{
    try {
        $reiniciarPassword = $connexio->prepare("SELECT contrassenya FROM usuaris WHERE correu = :correu");
        $reiniciarPassword->bindParam(":correu", $correu);
        $reiniciarPassword->execute();


        $pswd = $reiniciarPassword->fetch(PDO::FETCH_ASSOC);

        if ($pswd) {
            if (password_verify($contrassenya, $pswd['contrassenya'])) {
                $contrassenyaHash = password_hash($contrassenyaCanviar, PASSWORD_DEFAULT);
                $canviarContrassenya = $connexio->prepare("UPDATE usuaris SET contrassenya = :nuevaContrassenya WHERE correu = :correu");
                $canviarContrassenya->bindParam(":nuevaContrassenya", $contrassenyaHash);
                $canviarContrassenya->bindParam(":correu", $correu);
                $canviarContrassenya->execute();
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

//Aqui verifiquem que la contrassenya cumpleixi diversos valors.
function verificarContrassenya($contrassenya2)
{
    $resultat = false;
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,}$/", $contrassenya2)) {
        $resultat = true;
    }


    return $resultat;
}

function enviarMail($correu, $connexio)
{
    require_once '../lib/PHPMailer/src/Exception.php';
    require_once '../lib/PHPMailer/src/PHPMailer.php';
    require_once '../lib/PHPMailer/src/SMTP.php';

    try {
        $token = bin2hex(random_bytes(16));
        $token_expires = date('Y-m-d H:i:s', time() + 60 * 30);

        $insertarTokenBaseDades = $connexio->prepare("UPDATE usuaris SET token = :token, token_expires = :token_expires WHERE correu = :correu");
        $insertarTokenBaseDades->bindParam(":token", $token);
        $insertarTokenBaseDades->bindParam(":token_expires", $token_expires);
        $insertarTokenBaseDades->bindParam(":correu", $correu);
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }


    if ($insertarTokenBaseDades->execute()) {
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'd.romero@sapalomera.cat';
            $mail->Password = 'ndrfaxgrenbsyczy';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('d.romero@sapalomera.cat', 'admin');
            $mail->addAddress($correu); // Destinatario

            $mail->isHTML(true);
            $mail->Subject = 'Restablecimiento de password';
            $mail->Body = "Haz click en este enlace para reiniciar la contraseña: 
            <a href='http://www.davidromero.cat/vista/resetingPassword.php?token=" . urlencode($token) . "&email=" . urlencode($correu) . "'>Restablecer Contraseña</a>";

            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
}

function getCorreuByID($id, $connexio)
{
    try {
        $getCorreuByID = $connexio->prepare("SELECT correu FROM articles WHERE id = :id");
        $getCorreuByID->bindParam(":id", $id);
        if ($getCorreuByID->execute()) {
            $correu = $getCorreuByID->fetch(PDO::FETCH_ASSOC);
            return $correu['correu'];
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

function getNamebyCorreu($correu, $connexio)
{

    $getNameByCorreu = $connexio->prepare("SELECT usuari FROM usuaris WHERE correu = :correu");
    $getNameByCorreu->bindParam(":correu", $correu);
    $getNameByCorreu->execute();

    $usuari = $getNameByCorreu->fetch(PDO::FETCH_ASSOC);

    if ($usuari) {
        return $usuari['usuari'];
    } else {
        echo "Hi ha hagut un problema...";
    }
}

function verificarToken($token, $correu, $connexio)
{
    try {
        $verificarToken = $connexio->prepare("SELECT token, token_expires FROM usuaris WHERE correu = :correu");
        $verificarToken->bindParam(":correu", $correu);
        $verificarToken->execute();

        if ($verificarToken->rowCount() > 0) {
            $resultat = $verificarToken->fetch(PDO::FETCH_ASSOC);

            if ($resultat['token'] === $token) {
                $expiracioToken = new DateTime($resultat['token_expires']);
                $dataActual = new DateTime();

                if ($expiracioToken < $dataActual) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

function updatePassword($correu, $new_password, $connexio)
{
    try {
        $getPassword = $connexio->prepare("SELECT contrassenya FROM usuaris WHERE correu = :correu");
        $getPassword->bindParam(":correu", $correu);
        $getPassword->execute();

        $resultat = $getPassword->fetch(PDO::FETCH_ASSOC);

        if ($resultat) {
            $contrassenya = password_hash($new_password, PASSWORD_DEFAULT);

            $updatePassword = $connexio->prepare("UPDATE usuaris SET contrassenya = :contrassenya WHERE correu = :correu");
            $updatePassword->bindParam(":contrassenya", $contrassenya);
            $updatePassword->bindParam(":correu", $correu);
            if ($updatePassword->execute()) {
                return true;
            } else {
                return false;
            }
        }
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
}

function obtenerTotalArticulos($connexio)
{
    $query = $connexio->query("SELECT COUNT(*) FROM articles");
    return $query->fetchColumn();
}

function obtenerArticulosPorUsuario($connexio, $start, $articulosPorPagina, $correu, $orderBy)
{
    $orderClause = generarOrdenSQL($orderBy);
    $query = $connexio->prepare("SELECT * FROM articles WHERE correu = :correu ORDER BY $orderClause LIMIT :start, :articulosPorPagina");
    $query->bindValue(':start', $start, PDO::PARAM_INT);
    $query->bindValue(':articulosPorPagina', $articulosPorPagina, PDO::PARAM_INT);
    $query->bindParam(":correu", $correu);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function obtenerArticulos($connexio, $start, $articulosPorPagina, $orderBy)
{
    $orderClause = generarOrdenSQL($orderBy);
    $query = $connexio->prepare("SELECT * FROM articles ORDER BY $orderClause LIMIT :start, :articulosPorPagina");
    $query->bindValue(':start', $start, PDO::PARAM_INT);
    $query->bindValue(':articulosPorPagina', $articulosPorPagina, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function obtenerTotalArticulosPorUsuario($connexio, $correu)
{
    $query = $connexio->prepare("SELECT COUNT(*) FROM articles WHERE correu = :correu");
    $query->bindParam(":correu", $correu);
    $query->execute();
    return $query->fetchColumn();
}


function generarOrdenSQL($orderBy)
{
    $ordenesValidos = [
        'dateAsc' => 'id ASC',
        'dateDesc' => 'id DESC',
        'AlphabeticallyAsc' => 'nom ASC',
        'AlphabeticallyDesc' => 'nom DESC'
    ];
    // Si el valor no es válido, usar 'id ASC' como predeterminado
    return $ordenesValidos[$orderBy] ?? 'id ASC';
}

function actualitzarUsuari($connexio, $usuari, $correu, $correuActual, $fotoPerfil)
{
    try {
        $actualitzarUsuari = $connexio->prepare("UPDATE usuaris SET usuari = :nouUsuari, correu = :nouCorreu, profileImg = :profileImg WHERE correu = :correuActual");
        $actualitzarUsuari->bindParam(':nouUsuari', $usuari);
        $actualitzarUsuari->bindParam(':nouCorreu', $correu);
        $actualitzarUsuari->bindParam(':correuActual', $correuActual);
        $actualitzarUsuari->bindParam(':profileImg', $fotoPerfil);
        if ($actualitzarUsuari->execute()) {
            $actualitzarArticles = $connexio->prepare("UPDATE articles SET correu = :nouCorreu WHERE correu = :correuActual");
            $actualitzarArticles->bindParam(':nouCorreu', $correu);
            $actualitzarArticles->bindParam(':correuActual', $correuActual);
            if ($actualitzarArticles->execute()) {
                return true;
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function getImage($connexio, $correu)
{
    try {
        // Preparamos la consulta para obtener la URL de la imagen de perfil
        $getImage = $connexio->prepare("SELECT profileImg FROM usuaris WHERE correu = :correu");
        $getImage->bindParam(':correu', $correu);
        $getImage->execute();

        $imatge = $getImage->fetchColumn();

        if ($getImage->rowCount() != 0) {
            return $imatge;
        } else {
            return "Hola";
        }
    } catch (PDOException $e) {
        // En caso de error, lo mostramos
        echo $e->getMessage();
        return null; // En caso de error, retornamos null
    }
}

function afegirUsuariOAuth($connexio, $usuari, $correu, $imatgePerfil, $autenticacio)
{
    try {
        $afegirUsuariOAuth = $connexio->prepare("INSERT INTO usuaris VALUES(:correu, :usuari, :profileImg, :autenticacio)");
        $afegirUsuariOAuth->bindParam(':correu', $correu);
        $afegirUsuariOAuth->bindParam(':usuari', $usuari);
        $afegirUsuariOAuth->bindParam(':profileImg', $imatgePerfil);
        $afegirUsuariOAuth->bindParam(':autentiacio', $autenticacio);
        $afegirUsuariOAuth->execute();
    } catch (Error $e) {
        echo $e->getMessage();
    }
}

function getAuth($connexio, $usuari)
{
    return false;

    $getAuth = $connexio->prepare("SELECT autenticacio WHERE usuari = :usuari");
    $getAuth->bindParam(':usuari', $usuari);
    $getAuth->execute();
    $resultat = $getAuth->fetch(PDO::FETCH_ASSOC);

    if ($resultat) {
        return true;
    }
}

function loginSocialProviderUser($connexio, $email, $usuari, $fotoPerfil)
{
    return false;

    // Verificar si el usuario ya existe en el sistema
    $user = getNamebyCorreu($email, $connexio); // Función que busca al usuario por correo electrónico en la base de datos

    if ($user) {
        // Si el usuario existe, iniciar sesión (esto podría implicar iniciar sesión en una base de datos, generar un token, etc.)
        $_SESSION['correu'] = $user['email'];
        $_SESSION['usuari'] = $user['displayName'];
        // Redirigir o mostrar la página principal
    } else {
        // Si el usuario no existe, registrar al nuevo usuario
        if (afegirUsuariOAuth($connexio, $usuari, $email, $fotoPerfil, 'github')) {
            return true;
        }
    }
}
function eliminar($connexio, $id)
{
    try {
        $eliminar = $connexio->prepare("DELETE FROM articles WHERE id = :id");
        $eliminar->bindParam(":id", $id);
        $eliminar->execute();

        if ($eliminar) {
            return true;
        }
    } catch (Error $e) {
        echo $e->getMessage();
    }
}



function searchBar($connexio, $query)
{
    $searchBar = $connexio->prepare("SELECT * FROM articles WHERE nom LIKE :query");
    $searchBar->bindParam(':query', $query);
    $searchBar->execute();

    $resultat = $searchBar->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultat) == 0) {
        return false;
    }

    return $resultat;
}

function verificarAdmin($connexio, $correu)
{
    try {
        $verificarAdmin = $connexio->prepare("SELECT admin FROM usuaris WHERE correu = :correu");
        $verificarAdmin->bindParam(':correu', $correu);
        $verificarAdmin->execute();

        $resultat = $verificarAdmin->fetch(PDO::FETCH_ASSOC);

        if ($resultat['admin'] == 1) {
            return true;
        } else {
            return false;
        }
    } catch (Error $e) {
        echo $e->getMessage();
    }
}

function mostrarDadesUsuaris($connexio)
{
    try {
        $mostrarDadesUsuaris = $connexio->prepare("SELECT profileImg, correu, usuari FROM usuaris");
        $mostrarDadesUsuaris->execute();

        if ($mostrarDadesUsuaris->rowCount() > 0) {
            return $mostrarDadesUsuaris->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Error $e) {
        echo $e->getMessage();
    }
}

function deleteUser($connexio, $correu)
{
    try {
        // Primero eliminamos los registros de articles asociados al correo del usuario
        $deleteArticles = $connexio->prepare("DELETE FROM articles WHERE correu = :correu");
        $deleteArticles->bindParam(':correu', $correu);
        $deleteArticles->execute();

        // Luego eliminamos el usuario de la tabla usuaris
        $deleteUser = $connexio->prepare("DELETE FROM usuaris WHERE correu = :correu");
        $deleteUser->bindParam(':correu', $correu);
        $deleteUser->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function showQR($qr_link)
{
    require_once '../lib/vendor/autoload.php';

    return '<img src="' . (new QRCode)->render($qr_link) . '"alt="QR Code" />';
}


// Generar y añadir a la base de datos un token aleatorio
function generarToken($connexio, $correu)
{
    $token = bin2hex(random_bytes(32));

    try {
        $generarToken = $connexio->prepare('UPDATE usuaris SET API_Token = :token WHERE correu = :correu');
        $generarToken->bindParam(':token', $token);
        $generarToken->bindParam(':correu', $correu);

        $generarToken->execute(); // Ejecutamos la consulta

        if ($generarToken->rowCount() > 0) {
            return $token; // Retornamos el token generado si se actualizó correctamente
        } else {
            return false; // Si no se actualizó ninguna fila, devolvemos false
        }
    } catch (PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage();
        return false;
    }
}


// Verificar si el token es válido
function validarToken($pdo, $token)
{
    $stmt = $pdo->prepare("SELECT * FROM usuaris WHERE API_Token = ?");
    $stmt->execute([$token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);

    // Depuración: Ver si el token existe en la BD
    echo json_encode([
        "debug" => "Validación de token",
        "token_busqueda" => $token,
        "resultado_bd" => $usuario
    ]);
    exit;
}

function api($connexio, $nombre)
{
    try {
        // Cambiar :nom a :nombre para ser consistente con el parámetro
        $sql = "SELECT * FROM articles_api WHERE Nom LIKE :Nom";
        $stmt = $connexio->prepare($sql);

        // Usar el parámetro :nombre con el valor modificado '%$nombre%'
        $stmt->execute(["Nom" => "%$nombre%"]);

        // Obtener los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Enviar la respuesta como JSON
        if ($resultados) {
            echo json_encode(["status" => "success", "data" => $resultados]);
        } else {
            echo json_encode(["status" => "error", "message" => 'There is no objects']);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}


// Función de verificación del reCAPTCHA
function recaptcha($clau_privada)
{
    $recaptcha = false;

    // Obtener el token reCAPTCHA enviado desde el formulario
    $recaptcha_token = $_POST['g-recaptcha-response'] ?? null;

    // Verificar si el token reCAPTCHA está presente
    if (empty($recaptcha_token)) {
        return false;
        exit();
    }

    // URL de la API de Google para verificar el token
    $url = 'https://www.google.com/recaptcha/api/siteverify';

    // Realizar la solicitud POST a Google para verificar el token
    $respuesta = file_get_contents("$url?secret=$clau_privada&response=$recaptcha_token");

    // Decodificar la respuesta JSON
    $json = json_decode($respuesta);

    // Comprobar si la validación fue exitosa
    $success = $json->success;

    if (!$success) {
        // Si la validación de reCAPTCHA falla, redirigir con un error
        header('Location: ../index.php?error=Error en el captcha...');
        die();
    } else {
        $recaptcha = true;
    }

    return $recaptcha;
}
