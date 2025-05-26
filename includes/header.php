<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>komoread</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" href="assets/komoread-icon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kiwi Maru', sans-serif;
        }
    </style>

</head>
<body>
<header>
    <h1><a href="index.php" class="title">komoread</a></h1>
    <small style="display:block; color:#ffe;">森のなかの小さな読書会</small>
    <nav>
        <?php if (is_logged_in()): ?>
            <a href="create_thread.php">本を新規登録</a> |
            <a href="logout.php">ログアウト</a>
        <?php else: ?>
            <a href="register.php">ユーザー登録</a> |
            <a href="login.php">ログイン</a>
        <?php endif; ?>
    </nav>
</header>
<hr>
