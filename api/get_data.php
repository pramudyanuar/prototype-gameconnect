<?php
session_start();
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// PENTING: Untuk production, hapus komentar di bawah ini
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Akses ditolak. Anda harus login.']);
    exit();
}

$db_file = __DIR__ . '/../db/gameconnect.sqlite';
$action = $_GET['action'] ?? '';

try {
    if (!file_exists($db_file)) { throw new PDOException("File database tidak ditemukan."); }
    $pdo = new PDO('sqlite:' . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($action === 'get_channels') {
        $stmt = $pdo->query("SELECT id, name, icon FROM channels ORDER BY id");
        $channels = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($channels);
    } elseif ($action === 'get_content' && isset($_GET['channel_id'])) {
        $channel_id = (int)$_GET['channel_id'];
        $stmt_messages = $pdo->prepare("SELECT m.content, m.timestamp, u.username, u.id as user_id FROM messages m JOIN users u ON m.user_id = u.id WHERE m.channel_id = :channel_id ORDER BY m.timestamp ASC LIMIT 50");
        $stmt_messages->execute(['channel_id' => $channel_id]);
        $messages = $stmt_messages->fetchAll(PDO::FETCH_ASSOC);
        $stmt_members = $pdo->query("SELECT id, username FROM users LIMIT 10");
        $members = $stmt_members->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['messages' => $messages, 'members' => $members]);
    } elseif ($action === 'get_notifications') {
      $user_id = $_SESSION['user_id'];
  
      $stmt = $pdo->prepare("
          SELECT n.id, n.type, n.content, n.is_read, n.created_at, u.username as actor_name
          FROM notifications n
          LEFT JOIN users u ON n.actor_id = u.id
          WHERE n.user_id = :user_id
          ORDER BY n.created_at DESC
      ");
      $stmt->execute(['user_id' => $user_id]);
      $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
      echo json_encode($notifications);
      exit();
    } elseif ($action === 'get_conversations') {
        $current_user_id = $_SESSION['user_id'];
        // Query ini sedikit kompleks: mengambil semua user unik yang pernah berinteraksi dengan user saat ini
        $stmt = $pdo->prepare("
            SELECT DISTINCT u.id, u.username
            FROM users u
            JOIN direct_messages dm ON u.id = dm.sender_id OR u.id = dm.recipient_id
            WHERE (dm.sender_id = :current_user_id OR dm.recipient_id = :current_user_id)
              AND u.id != :current_user_id
        ");
        $stmt->execute(['current_user_id' => $current_user_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit();
    }
    elseif ($action === 'get_direct_messages' && isset($_GET['user_id'])) {
        $current_user_id = $_SESSION['user_id'];
        $other_user_id = (int)$_GET['user_id'];
        // Mengambil semua pesan antara DUA pengguna
        $stmt = $pdo->prepare("
            SELECT * FROM direct_messages
            WHERE (sender_id = :current_user AND recipient_id = :other_user)
               OR (sender_id = :other_user AND recipient_id = :current_user)
            ORDER BY created_at ASC
        ");
        $stmt->execute(['current_user' => $current_user_id, 'other_user' => $other_user_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit();
    } elseif ($action === 'get_profile_data') {
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("SELECT username, email, created_at FROM users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
        exit();
    } else {
        throw new Exception("Action tidak valid.");
    }
} catch (PDOException | Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error.', 'message' => $e->getMessage()]);
}
?>