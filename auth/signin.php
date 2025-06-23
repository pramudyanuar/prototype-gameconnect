<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Path database disesuaikan
    $db_file = dirname(__DIR__) . '/db/gameconnect.sqlite';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Username and password are required.";
        header('Location: ../index.php'); // Redirect ke root
        exit();
    }

    try {
        $pdo = new PDO('sqlite:' . $db_file);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // Redirect ke folder dashboard
            header('Location: ../dashboard/dashboard.php'); 
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid username or password.";
            header('Location: ../index.php'); // Redirect ke root
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['login_error'] = "Database error: " . $e->getMessage();
        header('Location: ../index.php'); // Redirect ke root
        exit();
    }
}
header('Location: ../index.php'); // Redirect ke root
exit();
?>