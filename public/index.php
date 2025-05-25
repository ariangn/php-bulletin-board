<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';

// get all threads with author names
$stmt = $pdo->query("
    SELECT threads.id, threads.title, threads.created_at, users.username
    FROM threads
    JOIN users ON threads.user_id = users.id
    ORDER BY threads.created_at DESC
");
$threads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>ようこそ</h2>

<?php if (is_logged_in()): ?>
    <p>こんにちは、<strong><?= htmlspecialchars($_SESSION['username']) ?></strong> さん！</p>
<?php else: ?>
    <p><a href="login.php">ログイン</a>または<a href="register.php">新規登録</a>してください。</p>
<?php endif; ?>

<hr>

<h3>スレッド一覧</h3>

<?php if (count($threads) === 0): ?>
    <p>まだスレッドがありません。</p>
<?php else: ?>
    <ul>
        <?php foreach ($threads as $thread): ?>
            <li>
                <a href="thread.php?id=<?= htmlspecialchars($thread['id']) ?>">
                    <?= htmlspecialchars($thread['title']) ?>
                </a>
                <br>
                <small>投稿者: <?= htmlspecialchars($thread['username']) ?> / <?= $thread['created_at'] ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
