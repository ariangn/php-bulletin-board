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

if (!$response) {
    die('レスが見つかりません。');
}

// ownership check
if ($_SESSION['user_id'] !== $response['user_id']) {
    die('このレスを編集する権限がありません。');
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    if ($content) {
        $stmt = $pdo->prepare("UPDATE responses SET content = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$content, $response_id]);
        header("Location: thread.php?id=" . urlencode($response['thread_id']));
        exit;
    } else {
        $message = '内容は必須です。';
    }
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>レス編集</h2>
<p style="color: red;"><?= $message ?></p>

<form method="POST">
    <textarea name="content" rows="5" cols="60" required><?= htmlspecialchars($response['content']) ?></textarea><br><br>
    <button type="submit">更新</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
