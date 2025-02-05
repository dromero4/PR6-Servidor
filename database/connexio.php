<!-- David Romero -->

<?php
require_once 'env.php';

$direccio = DB_VAR1['DB_HOST1'];
$nomBBDD = DB_VAR1['DB_NAME1'];
$usuaris = DB_VAR1['DB_USER1'];
$contrasenya = DB_VAR1['DB_PASSWORD1'];

//  fitxer per a la connexio a la base de dades
try {
    $connexio = new PDO("mysql:host=$direccio;dbname=$nomBBDD;charset=utf8", $usuaris, $contrasenya);
    $connexio->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "No s'ha pogut connectar a la base de dades..." . $e->getMessage();
}

?>