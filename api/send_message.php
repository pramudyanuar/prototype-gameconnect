<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$channel_id = $data['channel_id'] ?? null;
$content = trim($data['content'] ?? '');
$user_id = $_SESSION['user_id'];

if (empty($channel_id) || empty($content)) {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit();
}

try {
    $db_file = __DIR__ . '/../db/gameconnect.sqlite';
    $pdo = new PDO('sqlite:' . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("INSERT INTO messages (channel_id, user_id, content) VALUES (:channel_id, :user_id, :content)");
    $stmt->execute(['channel_id' => $channel_id, 'user_id' => $user_id, 'content' => $content]);
    
    echo json_encode(['success' => true, 'message' => ['content' => $content, 'username' => $_SESSION['username'], 'user_id' => $user_id, 'timestamp' => date('Y-m-d H:i:s')]]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>