<?php
session_start();

// Jika pengguna tidak login, tendang kembali ke halaman index di root
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css"> 
</head>
<body>
    <div class="container text-center" style="padding-top: 20vh;">
        <div class="form-container" style="max-width: 600px; margin: auto;">
            <h1>Welcome to GameConnect, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>You have successfully logged in.</p>
            <a href="../auth/logout.php" class="btn btn-danger mt-3">Logout</a>
        </div>
    </div>
</body>
</html>