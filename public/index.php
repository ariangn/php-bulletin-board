<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';

function getRandomColor() {
    $colors = ['#7b9e89', '#d99c73', '#90c0e8', '#ffc857', '#ffc857', '#3a5a40', '#588187', '#718355', '#90a955', '#adc178', '#7EB77F', '#14453D', '#12664F'];
    return $colors[array_rand($colors)];
}

// get all threads with author names
$stmt = $pdo->query("
    SELECT threads.id, threads.title, threads.author, threads.created_at, users.username
    FROM threads
    JOIN users ON threads.user_id = users.id
    ORDER BY threads.updated_at DESC
");
$threads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main>

    <h2>ようこそ、森の読書会へ</h2>

    <?php if (is_logged_in()): ?>
        <p>こんにちは、<strong><?= htmlspecialchars($_SESSION['username']) ?></strong> さん！</p>
    <?php else: ?>
        <p><a href="login.php">ログイン</a>または<a href="register.php">新規登録</a>してください。</p>
    <?php endif; ?>

    <p>
        この掲示板は、本を愛する人たちのための静かな集いの場所です。<br>
        各スレッドは一冊の本をテーマにしており、感想、考察、好きな一文を語り合えます。<br>
        木漏れ日のようにやさしい時間を、ここで一緒に過ごしましょう。
    </p>

    <hr>

    <h3>読書スレッド一覧</h3>
    <p>以下は本ごとの読書スレッドです。気になる本をクリックして感想を共有しましょう。</p>

    <?php if (count($threads) === 0): ?>
        <p>まだスレッドがありません。</p>
    <?php else: ?>
        <div class="book-grid">
            <?php foreach ($threads as $thread): ?>
                <a href="thread.php?id=<?= htmlspecialchars($thread['id']) ?>"
                class="book-cover"
                style="background-color: <?= getRandomColor() ?>;">
                    <?= htmlspecialchars($thread['title']) ?><br>
                    <small style="font-size: 0.8em;">by <?= htmlspecialchars($thread['author']) ?></small>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
