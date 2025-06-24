<?php
// api/send_direct_message.php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$recipient_id = $data['recipient_id'] ?? null;
$content = trim($data['content'] ?? '');
$sender_id = $_SESSION['user_id'];

if (empty($recipient_id) || empty($content)) {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit();
}

try {
    $db_file = __DIR__ . '/../db/gameconnect.sqlite';
    $pdo = new PDO('sqlite:' . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("INSERT INTO direct_messages (sender_id, recipient_id, content) VALUES (:sender_id, :recipient_id, :content)");
    $stmt->execute(['sender_id' => $sender_id, 'recipient_id' => $recipient_id, 'content' => $content]);
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>