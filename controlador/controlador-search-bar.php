<?php
require_once __DIR__ . '/../database/env.php';
require_once BASE_PATH . 'database/connexio.php';
require_once '../model/model.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $query = $_POST['search-input'];

    $resultados = searchBar($connexio, $query);

    if (!empty($resultados)) {
        echo "<div class='card-container'>";
        foreach ($resultados as $entrada) {
            echo "<div class='card' id='card-{$entrada['id']}'>
                <h3>ID: {$entrada['id']}</h3>
                <p>Modelo: {$entrada['model']}</p>
                <p>Nombre: {$entrada['nom']}</p>
                <p>Precio: {$entrada['preu']}</p>
                <p>Correo: {$entrada['correu']}</p>
            </div>";
        }
        echo "</div>";
    } else {
        echo "<p>No se encontraron resultados para '<b>" . htmlspecialchars($query) . "</b>'</p>";
    }
}
