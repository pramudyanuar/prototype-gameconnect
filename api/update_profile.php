<?php
// api/update_profile.php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit();
}

$db_file = __DIR__ . '/../db/gameconnect.sqlite';
$pdo = new PDO('sqlite:' . $db_file);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$current_user_id = $_SESSION['user_id'];

$action = $_POST['action'] ?? '';

if ($action === 'update_details') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    if (empty($username) || empty($email)) {
        echo json_encode(['success' => false, 'error' => 'Username and email are required.']);
        exit();
    }
    
    // Cek jika username sudah digunakan oleh user lain
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username AND id != :id");
    $stmt->execute(['username' => $username, 'id' => $current_user_id]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'error' => 'Username already taken.']);
        exit();
    }

    $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
    $stmt->execute(['username' => $username, 'email' => $email, 'id' => $current_user_id]);
    
    $_SESSION['username'] = $username; // Update session
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully!']);

} elseif ($action === 'change_password') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        echo json_encode(['success' => false, 'error' => 'All password fields are required.']);
        exit();
    }
    if ($new_password !== $confirm_password) {
        echo json_encode(['success' => false, 'error' => 'New passwords do not match.']);
        exit();
    }
    if (strlen($new_password) < 8) {
        echo json_encode(['success' => false, 'error' => 'Password must be at least 8 characters.']);
        exit();
    }

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
    $stmt->execute(['id' => $current_user_id]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($current_password, $user['password'])) {
        echo json_encode(['success' => false, 'error' => 'Incorrect current password.']);
        exit();
    }
    
    $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
    $stmt->execute(['password' => $new_hashed_password, 'id' => $current_user_id]);

    echo json_encode(['success' => true, 'message' => 'Password changed successfully!']);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid action.']);
}
?>