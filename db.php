<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=chess_tournament;charset=utf8mb4', 'root', '1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    die(json_encode(['error' => 'Database connection failed: ' . $error->getMessage()]));
}