<?php
// initialize_db.php
ini_set('display_errors', 1); error_reporting(E_ALL);
$db_path = __DIR__ . '/../db/gameconnect.sqlite';

try {
    $pdo = new PDO('sqlite:' . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Koneksi ke database berhasil.<br>";

    echo "Membuat tabel...<br>";
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE, email TEXT NOT NULL UNIQUE, password TEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    echo " - Tabel 'users' OK.<br>";
    $pdo->exec("CREATE TABLE IF NOT EXISTS channels (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL UNIQUE, icon TEXT DEFAULT 'fa-solid fa-hashtag')");
    echo " - Tabel 'channels' OK.<br>";
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (id INTEGER PRIMARY KEY AUTOINCREMENT, channel_id INTEGER NOT NULL, user_id INTEGER NOT NULL, content TEXT NOT NULL, timestamp DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (channel_id) REFERENCES channels(id) ON DELETE CASCADE, FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE)");
    echo " - Tabel 'messages' OK.<br>";
    $pdo->exec("CREATE TABLE IF NOT EXISTS notifications (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER NOT NULL, actor_id INTEGER, type TEXT NOT NULL, content TEXT NOT NULL, link_url TEXT, is_read INTEGER DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY (actor_id) REFERENCES users(id) ON DELETE CASCADE)");
    echo " - Tabel 'notifications' OK.<br>";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS direct_messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            sender_id INTEGER NOT NULL,
            recipient_id INTEGER NOT NULL,
            content TEXT NOT NULL,
            is_read INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (recipient_id) REFERENCES users(id) ON DELETE CASCADE
        )
    ");
    echo " - Tabel 'direct_messages' OK.<br>";

    echo "Memasukkan data dummy...<br>";
    $users = [['username' => 'JordanLee', 'email' => 'jordan@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT)], ['username' => 'MorganYu', 'email' => 'morgan@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT)], ['username' => 'EvelynStone', 'email' => 'evelyn@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT)]];
    $stmt_user = $pdo->prepare("INSERT OR IGNORE INTO users (username, email, password) VALUES (:username, :email, :password)");
    foreach ($users as $user) { $stmt_user->execute($user); }
    echo " - Data pengguna dummy OK.<br>";

    $channels = [['id' => 1, 'name' => 'general', 'icon' => 'fa-solid fa-hashtag'], ['id' => 2, 'name' => 'gaming', 'icon' => 'fa-solid fa-gamepad'], ['id' => 3, 'name' => 'dev-talk', 'icon' => 'fa-solid fa-laptop-code']];
    $stmt_channel = $pdo->prepare("INSERT OR IGNORE INTO channels (id, name, icon) VALUES (:id, :name, :icon)");
    foreach ($channels as $channel) { $stmt_channel->execute($channel); }
    echo " - Data channel dummy OK.<br>";
    
    $pdo->exec("DELETE FROM messages; DELETE FROM notifications;");
    $messages = [['channel_id' => 1, 'user_id' => 1, 'content' => 'Selamat datang di GameConnect! 👋'], ['channel_id' => 2, 'user_id' => 2, 'content' => 'Ada yang mau main Apex Legends malam ini?']];
    $stmt_message = $pdo->prepare("INSERT INTO messages (channel_id, user_id, content) VALUES (:channel_id, :user_id, :content)");
    foreach ($messages as $message) { $stmt_message->execute($message); }
    echo " - Data pesan dummy OK.<br>";
    
    $notifications = [['user_id' => 1, 'actor_id' => 2, 'type' => 'reply', 'content' => '<strong>MorganYu</strong> membalas pesan Anda di <strong>#general</strong>.'], ['user_id' => 1, 'actor_id' => 3, 'type' => 'team_invite', 'content' => '<strong>EvelynStone</strong> mengundang Anda untuk bergabung dengan tim <strong>"Apex Predators"</strong>.'], ['user_id' => 1, 'actor_id' => null, 'type' => 'event_reminder', 'content' => 'Event <strong>Apex Tournament</strong> akan dimulai dalam 1 jam.'], ['user_id' => 1, 'actor_id' => 2, 'type' => 'like', 'content' => '<strong>MorganYu</strong> menyukai postingan Anda.', 'is_read' => 1]];
    $stmt_notif = $pdo->prepare("INSERT INTO notifications (user_id, actor_id, type, content, is_read) VALUES (:user_id, :actor_id, :type, :content, :is_read)");
    foreach ($notifications as $notif) { $stmt_notif->execute([':user_id' => $notif['user_id'], ':actor_id' => $notif['actor_id'], ':type' => $notif['type'], ':content' => $notif['content'], ':is_read' => $notif['is_read'] ?? 0]); }
    echo " - Data notifikasi dummy OK.<br>";

    $dms = [
        ['sender_id' => 1, 'recipient_id' => 2, 'content' => 'Hey Morgan, apa kabar?'],
        ['sender_id' => 2, 'recipient_id' => 1, 'content' => 'Baik, Jordan! Kamu sendiri?'],
        ['sender_id' => 1, 'recipient_id' => 2, 'content' => 'do you ready to lose?']
    ];
    $stmt_dm = $pdo->prepare("INSERT INTO direct_messages (sender_id, recipient_id, content) VALUES (:sender_id, :recipient_id, :content)");
    foreach ($dms as $dm) {
        $stmt_dm->execute($dm);
    }
    echo " - Data pesan pribadi dummy OK.<br>";

    echo "<hr><strong>Inisialisasi Database Selesai!</strong>";
    echo "<br><strong style='color:red;'>PENTING: Hapus atau amankan file ini dari server Anda sekarang.</strong>";
} catch (PDOException $e) {
    die("Error: Gagal menginisialisasi database. Pesan: " . $e->getMessage());
}
?>