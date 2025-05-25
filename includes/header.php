<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板アプリ</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
    <h1><a href="index.php">掲示板</a></h1>
    <nav>
        <?php if (is_logged_in()): ?>
            <a href="create_thread.php">スレッド作成</a> |
            <a href="logout.php">ログアウト</a>
        <?php else: ?>
            <a href="register.php">ユーザー登録</a> |
            <a href="login.php">ログイン</a>
        <?php endif; ?>
    </nav>
</header>
<hr>
