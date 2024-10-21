<?php
session_start();
$dsn = "mysql:host=localhost;dbname=uts_group_5";
$pdo = new PDO($dsn, "root", "");

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id']; // Simpan ID pengguna di sesi
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = 'Invalid username or password.';
        header("Location: index.php");
        exit();
    }
}
?>
