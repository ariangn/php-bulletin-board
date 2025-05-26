<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';
redirect_if_not_logged_in();

$thread_id = $_GET['id'] ?? null;
if (!$thread_id) {
    die('スレッドIDが指定されていません。');
}

// fetch thread
$stmt = $pdo->prepare("SELECT * FROM threads WHERE id = ?");
$stmt->execute([$thread_id]);
$thread = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$thread) {
    die('スレッドが見つかりません。');
}

// only the owner can edit
if ($_SESSION['user_id'] !== $thread['user_id']) {
    die('このスレッドを編集する権限がありません。');
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    
    $stmt = $pdo->prepare("UPDATE threads SET title = ?, content = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$title, $content, $thread_id]);
    header("Location: thread.php?id=" . urlencode($thread_id));
    exit;
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>スレッド編集</h2>
<p style="color: red;"><?= $message ?></p>

<form method="POST">
    <label>タイトル: <input type="text" name="title" value="<?= htmlspecialchars($thread['title']) ?>" required></label><br><br>
    <label>内容:<br>
        <textarea name="content" rows="5" cols="50"><?= htmlspecialchars($thread['content']) ?></textarea>
    </label><br><br>
    <button type="submit">更新</button>
</form>

<?php include __DIR__ . '/../includes/footer'; ?>
