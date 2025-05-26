<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';
redirect_if_not_logged_in();

$thread_id = $_GET['id'] ?? null;
if (!$thread_id) {
    die('スレッドIDが指定されていません。');
}

// verify ownership
$stmt = $pdo->prepare("SELECT user_id FROM threads WHERE id = ?");
$stmt->execute([$thread_id]);
$thread = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$thread || $_SESSION['user_id'] !== $thread['user_id']) {
    die('このスレッドを削除する権限がありません。');
}

// delete thread
$stmt = $pdo->prepare("DELETE FROM threads WHERE id = ?");
$stmt->execute([$thread_id]);

header("Location: index.php");
exit;
