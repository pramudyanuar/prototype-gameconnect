<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_file = __DIR__ . '/db/gameconnect.sqlite';

    // Ambil data dari form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi dasar
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['register_error'] = "All fields are required.";
        header('Location: index.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email format.";
        header('Location: index.php');
        exit();
    }

    if (strlen($password) < 8) {
        $_SESSION['register_error'] = "Password must be at least 8 characters long.";
        header('Location: index.php');
        exit();
    }

    // Hash password untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $pdo = new PDO('sqlite:' . $db_file);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Siapkan statement untuk memasukkan data
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        $stmt->execute();
        
        $_SESSION['register_success'] = "Registration successful! You can now log in.";

    } catch (PDOException $e) {
        // Cek jika error karena duplikat (kode error 19 untuk SQLite)
        if ($e->getCode() == '23000' || strpos($e->getMessage(), 'UNIQUE constraint failed')) {
            $_SESSION['register_error'] = "Username or email already exists.";
        } else {
            $_SESSION['register_error'] = "An error occurred during registration. " . $e->getMessage();
        }
    }
    
    // Kembali ke halaman utama
    header('Location: index.php');
    exit();

} else {
    // Jika diakses langsung, redirect
    header('Location: index.php');
    exit();
}
?>