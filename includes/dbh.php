<?php

$DB_HOST = 'localhost';
$DB_NAME = 'message_board';
$DB_USER = 'root';
$DB_PASS = 'root';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;port=8889;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
