<?php
session_start();

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard/dashboard.php');
    exit();
}

// Jika belum login, arahkan ke halaman signin
header('Location: auth/signin.php');
exit();
