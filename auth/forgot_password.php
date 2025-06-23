<?php
session_start();

// Database file path
$db_file = __DIR__ . '/../db/gameconnect.sqlite';

// Logic to handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // === STAGE 1: Handle Email Submission ===
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['forgot_error'] = "A valid email is required.";
        } else {
            try {
                $pdo = new PDO('sqlite:' . $db_file);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Email found, proceed to the next stage
                    $_SESSION['reset_email'] = $email;
                    $_SESSION['reset_stage'] = 'enter_password'; // Set session to show password form
                } else {
                    $_SESSION['forgot_error'] = "Email not found in our records.";
                }
            } catch (PDOException $e) {
                $_SESSION['forgot_error'] = "Database error: " . $e->getMessage();
            }
        }
    }

    // === STAGE 2: Handle New Password Submission ===
    elseif (isset($_POST['password']) && isset($_SESSION['reset_stage']) && $_SESSION['reset_stage'] === 'enter_password') {
        $password = $_POST['password'];
        $confirm  = $_POST['confirm_password'];
        $email    = $_SESSION['reset_email'];

        if (empty($password) || empty($confirm)) {
            $_SESSION['reset_error'] = "All password fields are required.";
        } elseif ($password !== $confirm) {
            $_SESSION['reset_error'] = "Passwords do not match.";
        } elseif (strlen($password) < 8) {
            $_SESSION['reset_error'] = "Password must be at least 8 characters.";
        } else {
            try {
                $pdo = new PDO('sqlite:' . $db_file);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
                $stmt->execute(['password' => $hashed_password, 'email' => $email]);

                // Cleanup session and redirect to login with success message
                unset($_SESSION['reset_email']);
                unset($_SESSION['reset_stage']);
                $_SESSION['login_success'] = "Password updated successfully. Please log in."; // Using login_success to show on signin page
                header('Location: signin.php');
                exit();
            } catch (PDOException $e) {
                $_SESSION['reset_error'] = "Database error: " . $e->getMessage();
            }
        }
    }
    
    // Redirect to self to show updated state or errors
    header('Location: forgot_password.php');
    exit();
}

// Check which stage we are in to display the correct form
$stage = $_SESSION['reset_stage'] ?? 'enter_email';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover Account - GameConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">

        <?php if ($stage === 'enter_password'): ?>
            <div class="login-header">
                <h1>Set a New Password</h1>
                <p>Create a new, strong password for your account.</p>
            </div>

            <?php if (isset($_SESSION['reset_error'])): ?>
                <div class="alert-error"><?php echo $_SESSION['reset_error']; unset($_SESSION['reset_error']); ?></div>
            <?php endif; ?>

            <form method="POST" action="forgot_password.php" class="login-form">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Enter new password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                    </div>
                </div>
                <button type="submit" class="btn-signin">Change Password</button>
            </form>

        <?php else: ?>
            <div class="login-header">
                <h1>Forgot your password?</h1>
                <p>Fear not, hero. Recover it and return to battle!</p>
            </div>

            <?php if (isset($_SESSION['forgot_error'])): ?>
                <div class="alert-error"><?php echo $_SESSION['forgot_error']; unset($_SESSION['forgot_error']); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="forgot_password.php" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>
                <button type="submit" class="btn-signin">Send Verification Email</button>
            </form>

            <div class="signup-link">
                <a href="signin.php">Back to login</a>
            </div>
            
        <?php endif; ?>

    </div>
</div>

</body>
</html>