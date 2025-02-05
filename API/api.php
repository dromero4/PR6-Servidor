<?php
session_start();
header("Content-Type: application/json");

require_once '../database/connexio-api.php';
require_once '../database/connexio.php';
require_once '../model/model.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener el token de los encabezados HTTP
    $headers = getallheaders();
    $token = isset($headers["Authorization"]) ? trim(str_replace("Bearer ", "", $headers["Authorization"])) : '';
    if (!$token) {
        $token = isset($_GET["token"]) ? trim($_GET["token"]) : '';
    }
    // Validar el token
    $usuario = validarToken($connexio, $token);

    if (!$usuario) {
        echo json_encode(["status" => "error", "message" => "Token inválido o no proporcionado"]);
        http_response_code(401); // No autorizado
        exit;
    }

    // Obtener parámetro 'nom'
    $nombre = isset($_GET["Nom"]) ? $_GET["Nom"] : '';

    api($connexio1, $nombre);
}
