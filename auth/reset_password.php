<?php
session_start();

if (!isset($_SESSION['reset_email'])) {
    header('Location: forgot_password.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];
    $email    = $_SESSION['reset_email'];
    $db_file  = __DIR__ . '/../db/gameconnect.sqlite';

    if (empty($password) || empty($confirm)) {
        $_SESSION['reset_error'] = "All fields are required.";
    } elseif ($password !== $confirm) {
        $_SESSION['reset_error'] = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $_SESSION['reset_error'] = "Password must be at least 8 characters.";
    } else {
        try {
            $pdo = new PDO('sqlite:' . $db_file);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $hashed = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
            $stmt->execute(['password' => $hashed, 'email' => $email]);

            unset($_SESSION['reset_email']);
            $_SESSION['reset_success'] = "Password updated successfully. Please log in.";
            header('Location: signin.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['reset_error'] = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <h2 class="text-center mb-4">Reset Password</h2>

        <?php if (isset($_SESSION['reset_error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['reset_error']; unset($_SESSION['reset_error']); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="confirm" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Change Password</button>
        </form>

        <p class="mt-3 text-center"><a href="signin.php">Back to Login</a></p>
    </div>
</div>
</body>
</html>
