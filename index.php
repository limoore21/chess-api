<?php
require './db.php';
require './handlers/players.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$q = $_GET['q'] ?? '';
$params = explode('/', $q);

$type = $params[0] ?? '';
$id = $params[1] ?? null;

switch ($type) {
    case 'players':
        switch ($method) {
            case 'GET':
                if ($id) {
                    getPlayerById($pdo, $id);
                } else {
                    getAllPlayers($pdo);
                }
                break;
            case 'POST':
                addPlayer($pdo);
                break;
            case 'PUT':
                if ($id) {
                    updatePlayer($pdo, $id);
                }
                break;
            case 'DELETE':
                if ($id) {
                    deletePlayer($pdo, $id);
                }
                break;
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Операция не найдена']);
        break;
}