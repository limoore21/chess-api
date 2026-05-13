<?php

function getAllPlayers($pdo) {
    $sql = 'SELECT * FROM players ORDER BY id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($players) {
        echo json_encode($players);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Игрок не найден']);
    }
}

function getPlayerById($pdo, $id) {
    $sql = 'SELECT * FROM players WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $player = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($player) {
        echo json_encode($player);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Игрок не найден']);
    }
}

function addPlayer($pdo) {
    $data = $_POST;

    if (empty($data['nickname'])) {
        http_response_code(422);
        echo json_encode(['error' => 'Требуется псевдоним']);
        return;
    }

    $sql = "INSERT INTO players (nickname) VALUES (:nickname)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['nickname' => $data['nickname']])) {
        http_response_code(201);
        echo json_encode([
            'status' => true,
            'message' => 'Игрок успешно добавлен',
            'id' => $pdo->lastInsertId()
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Ошибка при добавлении игрока']);
    }
}

function updatePlayer($pdo, $id) {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['nickname'])) {
        http_response_code(422);
        echo json_encode(['error' => 'ТребуетсЯ псевдоним']);
        return;
    }

    $sql = "UPDATE players SET nickname = :nickname WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['nickname' => $data['nickname'], 'id' => $id])) {
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'status' => true,
                'message' => 'Плеер успешно обновлен'
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Игрок не найден']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Ошибка при обновлении игрока']);
    }
}

function deletePlayer($pdo, $id) {
    $sql = "DELETE FROM players WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['id' => $id])) {
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'status' => true,
                'message' => 'Игрок успешно удален'
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Плеер не найде']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Ошибка при удалении игрока']);
    }
}