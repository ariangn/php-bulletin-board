<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';
redirect_if_not_logged_in();

$response_id = $_GET['id'] ?? null;
if (!$response_id) {
    die('レスIDが指定されていません。');
}

// fetch response
$stmt = $pdo->prepare("SELECT * FROM responses WHERE id = ?");
$stmt->execute([$response_id]);
$response = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$response || $_SESSION['user_id'] !== $response['user_id']) {
    die('このレスを削除する権限がありません。');
}

// delete
$stmt = $pdo->prepare("DELETE FROM responses WHERE id = ?");
$stmt->execute([$response_id]);

header("Location: thread.php?id=" . urlencode($response['thread_id']));
exit;
