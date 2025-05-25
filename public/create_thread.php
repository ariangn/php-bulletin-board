<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';
redirect_if_not_logged_in();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uuid = generate_uuid();
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $stmt = $pdo->prepare("INSERT INTO threads (id, user_id, title, content) VALUES (?, ?, ?, ?)");
    $stmt->execute([$uuid, $user_id, $title, $content]);
    header("Location: index.php");
    exit;
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>スレッド作成</h2>
<p style="color: red;"><?= $message ?></p>

<form method="POST">
    <label>タイトル: <input type="text" name="title" required></label><br><br>
    <label>内容:<br>
        <textarea name="content" rows="5" cols="50"></textarea>
    </label><br><br>
    <button type="submit">投稿</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
