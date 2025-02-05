<!-- David Romero -->

<?php
require_once 'env-api.php';

$direccio2 = DB_VAR2['DB_HOST2'];
$nomBBDD2 = DB_VAR2['DB_NAME2'];
$usuaris2 = DB_VAR2['DB_USER2'];
$contrasenya2 = DB_VAR2['DB_PASSWORD2'];

//  fitxer per a la connexio a la base de dades
try {
    $connexio1 = new PDO("mysql:host=$direccio2;dbname=$nomBBDD2;charset=utf8", $usuaris2, $contrasenya2);
    $connexio1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "No s'ha pogut connectar a la base de dades..." . $e->getMessage();
}

?>