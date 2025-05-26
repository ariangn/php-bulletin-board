<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uuid = generate_uuid();
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$username || !$password) {
        $message = 'ユーザー名とパスワードは必須です。';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT); // built-in func
        try {
            $stmt = $pdo->prepare("INSERT INTO users (id, username, password_hash, email) VALUES (?, ?, ?, ?)");
            $stmt->execute([$uuid, $username, $hash, $email]);
            $message = '登録が完了しました。<a href="login.php">ログインはこちら</a>。';
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $message = 'そのユーザー名は既に使われています。';
            } else {
                $message = 'エラーが発生しました: ' . $e->getMessage();
            }
        }
    }
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
    <h2>ユーザー登録</h2>
    <p style="color: red;"><?= $message ?></p>
        <form method="POST">
            <label>ユーザー名: <input type="text" name="username" required></label><br><br>
            <label>メールアドレス: <input type="email" name="email"></label><br><br>
            <label>パスワード: <input type="password" name="password" required></label><br><br>
            <button type="submit">登録</button>
        </form>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
