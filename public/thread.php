<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';

$thread_id = $_GET['id'] ?? null;
if (!$thread_id) {
    die('スレッドIDが指定されていません。');
}

// fetch thread info
$stmt = $pdo->prepare("
    SELECT threads.*, users.username 
    FROM threads 
    JOIN users ON threads.user_id = users.id 
    WHERE threads.id = ?
");
$stmt->execute([$thread_id]);
$thread = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$thread) {
    die('スレッドが見つかりません。');
} 

// handle new response POST
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_logged_in()) {
    $uuid = generate_uuid();
    $user_id = $_SESSION['user_id'];
    $content = trim($_POST['content']);

    if ($content) {
        $stmt = $pdo->prepare("INSERT INTO responses (id, thread_id, user_id, content) VALUES (?, ?, ?, ?)");
        $stmt->execute([$uuid, $thread_id, $user_id, $content]);
        header("Location: thread.php?id=" . urlencode($thread_id)); // prevent resubmission
        exit;
    } else {
        $message = '内容は必須です。';
    }
}

// fetch responses
$stmt = $pdo->prepare("
    SELECT responses.*, users.username 
    FROM responses 
    JOIN users ON responses.user_id = users.id 
    WHERE responses.thread_id = ?
    ORDER BY responses.created_at ASC
");
$stmt->execute([$thread_id]);
$responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<h2><?= htmlspecialchars($thread['title']) ?></h2>
<p><?= nl2br(htmlspecialchars($thread['content'])) ?></p>
<p><small>投稿者: <?= htmlspecialchars($thread['username']) ?> / <?= $thread['created_at'] ?></small></p>

<?php if (is_logged_in() && $_SESSION['user_id'] === $thread['user_id']): ?>
    <p>
        <a href="edit_thread.php?id=<?= htmlspecialchars($thread['id']) ?>">[編集]</a>
        <a href="delete_thread.php?id=<?= htmlspecialchars($thread['id']) ?>" onclick="return confirm('本当に削除しますか？');">[削除]</a>
    </p>
<?php endif; ?>

<hr>

<h3>レス一覧</h3>

<?php if (count($responses) === 0): ?>
    <p>まだレスがありません。</p>
<?php else: ?>
    <ul>
    <?php foreach ($responses as $res): ?>
        <li>
            <?= nl2br(htmlspecialchars($res['content'])) ?><br>
            <small>投稿者: <?= htmlspecialchars($res['username']) ?> / <?= $res['created_at'] ?></small>

            <?php if (is_logged_in() && $_SESSION['user_id'] === $res['user_id']): ?>
                <div>
                    <a href="edit_response.php?id=<?= htmlspecialchars($res['id']) ?>">[編集]</a>
                    <a href="delete_response.php?id=<?= htmlspecialchars($res['id']) ?>" onclick="return confirm('本当に削除しますか？');">[削除]</a>
                </div>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>

    </ul>
<?php endif; ?>

<hr>

<?php if (is_logged_in()): ?>
    <h3>レスを投稿する</h3>
    <p style="color: red;"><?= $message ?></p>
    <form method="POST">
        <textarea name="content" rows="4" cols="60" required></textarea><br><br>
        <button type="submit">投稿</button>
    </form>
<?php else: ?>
    <p><a href="login.php">ログイン</a>してレスを投稿してください。</p>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
