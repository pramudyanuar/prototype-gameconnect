<?php
session_start();

// PHP logic remains the same
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_file = __DIR__ . '/../db/gameconnect.sqlite';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Username and password are required.";
    } else {
        try {
            $pdo = new PDO('sqlite:' . $db_file);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /../dashboard/dashboard.php');
                exit();
            } else {
                $_SESSION['login_error'] = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $_SESSION['login_error'] = "Database error: " . $e->getMessage();
        }
    }
    // Redirect back to the login page to show the error
    header('Location: signin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - GameConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>We Have Met Before</h1>
            <p>Sign in and jump back into the action!</p>
        </div>

        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert-error">
                <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="signin.php" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" placeholder="Enter a password" required>
                </div>
                <div class="forgot-password-link">
                    <a href="forgot_password.php">Forgot Password?</a>
                </div>
            </div>
            <button type="submit" class="btn-signin">Sign In</button>
        </form>

        <div class="signup-link">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</div>

</body>
</html>