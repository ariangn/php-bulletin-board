<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>ようこそ</h2>

<?php if (is_logged_in()): ?>
    <p>こんにちは、<strong><?= htmlspecialchars($_SESSION['username']) ?></strong> さん！</p>
<?php else: ?>
    <p><a href="login.php">ログイン</a>または<a href="register.php">新規登録</a>してください。</p>
<?php endif; ?>

<hr>

<p>ここにスレッドを表示します。</p>

<?php include __DIR__ . '/../includes/footer.php'; ?>
