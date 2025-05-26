<?php
require_once __DIR__ . '/../includes/dbh.php';
require_once __DIR__ . '/../includes/functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php"); // redirect to homepage
        exit;
    } else {
        $message = 'ユーザー名またはパスワードが間違っています。';
    }
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main>

    <h2>ログイン</h2>
    <p style="color: red;"><?= $message ?></p>

    <form method="POST">
        <label>ユーザー名: <input type="text" name="username" required></label><br><br>
        <label>パスワード: <input type="password" name="password" required></label><br><br>
        <button type="submit">ログイン</button>
    </form>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
