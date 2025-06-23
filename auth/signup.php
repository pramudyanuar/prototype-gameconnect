<?php
session_start();

// PHP logic for handling registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_file = __DIR__ . '/../db/gameconnect.sqlite';

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Basic server-side validation
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['register_error'] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $_SESSION['register_error'] = "Password must be at least 8 characters.";
    } else {
        try {
            $pdo = new PDO('sqlite:' . $db_file);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password
            ]);

            $_SESSION['register_success'] = "Registration successful. Please log in.";
            header('Location: signin.php');
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // SQLite unique constraint violation
                $_SESSION['register_error'] = "Username or email already exists.";
            } else {
                $_SESSION['register_error'] = "Database error: " . $e->getMessage();
            }
        }
    }
    // Redirect back to signup page on error
    header('Location: signup.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - GameConnect</title>
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
            <h1>Create Your<br>GameConnect Account</h1>
            <p>Join the ultimate gaming community</p>
        </div>

        <?php if (isset($_SESSION['register_error'])): ?>
            <div class="alert-error">
                <?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="signup.php" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
                <div class="password-strength">
                    <div class="strength-bar">
                        <div id="strength-bar-fill"></div>
                    </div>
                    <span class="strength-text"></span>
                </div>
            </div>
            <button type="submit" class="btn-signin">Sign Up</button>
        </form>

        <div class="signup-link">
            <p>Already have an account? <a href="signin.php">Sign In</a></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const strengthBarFill = document.getElementById('strength-bar-fill');
    const strengthText = document.querySelector('.strength-text');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const result = checkPasswordStrength(password);

        if (password.length === 0) {
            strengthText.textContent = '';
            strengthBarFill.style.width = '0%';
        } else {
            strengthText.textContent = result.text;
            strengthBarFill.style.width = result.width;
            strengthBarFill.style.backgroundColor = result.color;
        }
    });

    function checkPasswordStrength(password) {
        let score = 0;
        let result = {
            width: '0%',
            color: '#2b2e3c',
            text: ''
        };

        if (password.length >= 8) score++;
        if (password.match(/[a-z]/)) score++;
        if (password.match(/[A-Z]/)) score++;
        if (password.match(/[0-9]/)) score++;
        if (password.match(/[^a-zA-Z0-9]/)) score++;

        switch (score) {
            case 0:
            case 1:
            case 2:
                result.width = '25%';
                result.color = '#ff5252'; // Red
                result.text = 'Weak';
                break;
            case 3:
                result.width = '50%';
                result.color = '#ffb74d'; // Orange
                result.text = 'Medium';
                break;
            case 4:
                result.width = '75%';
                result.color = '#aeea00'; // Yellow-Green
                result.text = 'Good';
                break;
            case 5:
                result.width = '100%';
                result.color = '#4caf50'; // Green
                result.text = 'Strong';
                break;
        }

        if (password.length > 0 && password.length < 8) {
            result.text = 'Weak';
            result.width = '25%';
            result.color = '#ff5252';
        }
        
        return result;
    }
});
</script>

</body>
</html>