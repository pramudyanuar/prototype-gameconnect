<?php
session_start();

// Redirect jika sudah login
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard/dashboard.php'); // Path ke dashboard diperbarui
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameConnect - Login & Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-lg-5 col-md-6 mb-4">
            <div class="form-container">
                <h2 class="text-center mb-1">We Have Met Before</h2>
                <p class="text-center mb-4">Sign-in and jump back into the action!</p>
                
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                    </div>
                <?php endif; ?>

                <form action="auth/signin.php" method="POST">
                    <div class="mb-3">
                        <label for="login-username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" id="login-username" name="username" placeholder="Enter your username" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="login-password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter a password" required>
                        </div>
                        <div class="text-end mt-1"><a href="#" class="form-text">Forgot Password?</a></div>
                    </div>
                    <button type="submit" class="btn btn-custom">Sign In</button>
                </form>
                <p class="bottom-link">Don't have an account? <a href="#">Sign Up</a></p>
            </div>
        </div>

        <div class="col-lg-5 col-md-6 mb-4">
            <div class="form-container">
                <h2 class="text-center mb-1">Create Your GameConnect Account</h2>
                <p class="text-center mb-4">Join the ultimate gaming community</p>

                <?php if (isset($_SESSION['register_error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['register_success'])): ?>
                     <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['register_success']; unset($_SESSION['register_success']); ?>
                    </div>
                <?php endif; ?>
                
                <form action="auth/signup.php" method="POST">
                    <div class="mb-3">
                        <label for="reg-username" class="form-label">Username</label>
                        <div class="input-group">
                           <span class="input-group-text"><i class="fa fa-user"></i></span>
                           <input type="text" class="form-control" id="reg-username" name="username" placeholder="Enter your username" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reg-email" class="form-label">Email</label>
                        <div class="input-group">
                           <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                           <input type="email" class="form-control" id="reg-email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reg-password" class="form-label">Password</label>
                        <div class="input-group">
                           <span class="input-group-text"><i class="fa fa-lock"></i></span>
                           <input type="password" class="form-control" id="reg-password" name="password" placeholder="Create a password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-custom">Sign Up</button>
                </form>
                 <p class="bottom-link">Already have an account? <a href="#">Sign in</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>