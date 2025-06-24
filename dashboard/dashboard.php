<?php
session_start();

// AKTIFKAN INI SETELAH ANDA MEMILIKI SISTEM LOGIN YANG BERFUNGSI
if (!isset($_SESSION['user_id'])) { 
    header('Location: ../auth/signin.php'); 
    exit(); 
}

// --- PHP ROUTING LOGIC ---
$allowed_pages = ['community_hub', 'notifications', 'messages', 'profile', 'leaderboards', 'mini_games', 'team_up', 'content_upload', 'explore', 'analytics', 'viewer_feedback', 'game_corner', 'game_analytics'];
$page_titles = ['community_hub' => 'Community Hub', 'notifications' => 'Notifications', 'messages' => 'Messages', 'profile' => 'Profile', 'leaderboards' => 'Leaderboards', 'mini_games' => 'Mini Games', 'team_up' => 'Team Up', 'content_upload' => 'Content Upload', 'explore' => 'Explore', 'analytics' => 'Analytics', 'viewer_feedback' => 'Viewer Feedback', 'game_corner' => 'Game Corner', 'game_analytics' => 'Game Analytics'];
$page = $_GET['page'] ?? 'community_hub';
if (!in_array($page, $allowed_pages)) { $page = 'community_hub'; }
$page_file = "pages/{$page}.php";
$current_title = $page_titles[$page];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($current_title); ?> - GameConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
    <?php if ($page === 'community_hub'): ?><link rel="stylesheet" href="style/community-stye.css"><?php endif; ?>
    <?php if ($page === 'notifications'): ?><link rel="stylesheet" href="style/notifications.css"><?php endif; ?>
    <?php if ($page === 'messages'): ?><link rel="stylesheet" href="style/messages.css"><?php endif; ?>
</head>
</head>
<body>
<div class="dashboard-container">
    <aside class="sidebar">
        <div class="sidebar-header"><a href="dashboard.php" class="logo">GameConnect</a></div>
        <nav class="sidebar-nav">
            <ul class="nav-list"><li class="nav-item"><a href="?page=community_hub" class="nav-link <?php if ($page === 'community_hub') echo 'active'; ?>"><i class="fa-solid fa-users"></i><span class="link-text">Community Hub</span></a></li><li class="nav-item"><a href="?page=notifications" class="nav-link <?php if ($page === 'notifications') echo 'active'; ?>"><i class="fa-solid fa-bell"></i><span class="link-text">Notifications</span></a></li><li class="nav-item"><a href="?page=messages" class="nav-link <?php if ($page === 'messages') echo 'active'; ?>"><i class="fa-solid fa-envelope"></i><span class="link-text">Messages</span></a></li><li class="nav-item"><a href="?page=profile" class="nav-link <?php if ($page === 'profile') echo 'active'; ?>"><i class="fa-solid fa-user"></i><span class="link-text">Profile</span></a></li></ul>
            <div class="nav-section"><h3 class="nav-section-title">Game</h3><ul class="nav-list"><li class="nav-item"><a href="?page=leaderboards" class="nav-link <?php if ($page === 'leaderboards') echo 'active'; ?>"><i class="fa-solid fa-trophy"></i><span class="link-text">Leaderboards</span></a></li><li class="nav-item"><a href="?page=mini_games" class="nav-link <?php if ($page === 'mini_games') echo 'active'; ?>"><i class="fa-solid fa-gamepad"></i><span class="link-text">Mini Games</span></a></li><li class="nav-item"><a href="?page=team_up" class="nav-link <?php if ($page === 'team_up') echo 'active'; ?>"><i class="fa-solid fa-people-group"></i><span class="link-text">Team Up</span></a></li></ul></div>
            <div class="nav-section"><h3 class="nav-section-title">Creative</h3><ul class="nav-list"><li class="nav-item"><a href="?page=content_upload" class="nav-link <?php if ($page === 'content_upload') echo 'active'; ?>"><i class="fa-solid fa-arrow-up-from-bracket"></i><span class="link-text">Content Upload</span></a></li><li class="nav-item"><a href="?page=explore" class="nav-link <?php if ($page === 'explore') echo 'active'; ?>"><i class="fa-solid fa-compass"></i><span class="link-text">Explore</span></a></li><li class="nav-item"><a href="?page=analytics" class="nav-link <?php if ($page === 'analytics') echo 'active'; ?>"><i class="fa-solid fa-chart-line"></i><span class="link-text">Analytics</span></a></li><li class="nav-item"><a href="?page=viewer_feedback" class="nav-link <?php if ($page === 'viewer_feedback') echo 'active'; ?>"><i class="fa-solid fa-comments"></i><span class="link-text">Viewer Feedback</span></a></li></ul></div>
            <div class="nav-section"><h3 class="nav-section-title">Develop</h3><ul class="nav-list"><li class="nav-item"><a href="?page=game_corner" class="nav-link <?php if ($page === 'game_corner') echo 'active'; ?>"><i class="fa-brands fa-discord"></i><span class="link-text">Game Corner</span></a></li><li class="nav-item"><a href="?page=game_analytics" class="nav-link <?php if ($page === 'game_analytics') echo 'active'; ?>"><i class="fa-solid fa-chart-pie"></i><span class="link-text">Game Analytics</span></a></li></ul></div>
        </nav>
        <div class="sidebar-footer"><a href="../auth/logout.php" class="nav-link logout"><i class="fa-solid fa-right-from-bracket"></i><span class="link-text">Logout</span></a></div>
    </aside>
    <main class="main-content">
        <header class="content-header"><div class="header-left"><button class="menu-toggle" id="menu-toggle"><i class="fa-solid fa-bars"></i></button><h1><?php echo htmlspecialchars($current_title); ?></h1></div><div class="header-right"></div></header>
        <div class="content-body">
            <?php if (file_exists($page_file)) { include $page_file; } else { echo "<div class='page-placeholder'><h1>Halaman tidak ditemukan</h1></div>"; } ?>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // --- BAGIAN 1: LOGIKA UNTUK SIDEBAR UTAMA ---
    const menuToggle = document.getElementById('menu-toggle');
    const mainSidebar = document.querySelector('.sidebar');
    if (menuToggle && mainSidebar) {
        menuToggle.addEventListener('click', () => {
            mainSidebar.classList.toggle('is-open');
        });
    }

    async function fetchAPI(url) {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                const errorText = await response.text();
                console.error(`HTTP error! Status: ${response.status}`, errorText);
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error("Fetch API Error:", error);
            throw error; // Lemparkan error agar bisa ditangkap oleh fungsi pemanggil
        }
    }

    // --- BAGIAN 2: LOGIKA UNTUK COMMUNITY HUB ---
    // Cek dulu apakah kita berada di halaman Community Hub
    if (document.querySelector('.hub-container')) {
        
        // -- A. Deklarasi Variabel & Elemen DOM --
        let currentChannelId = 1; // Channel default
        const channelsToggleBtn = document.getElementById('channels-toggle-btn');
        const infoToggleBtn = document.getElementById('info-toggle-btn');
        const channelsPanel = document.getElementById('channels-panel');
        const infoPanel = document.getElementById('info-panel');
        const hubBackdrop = document.getElementById('hub-backdrop');
        const channelsList = document.getElementById('channels-list');
        const messageForm = document.getElementById('message-form');

        // -- B. Definisi Fungsi Helper (Render HTML) --
        const renderChannels = (channels) => {
            if (!channelsList) return;
            channelsList.innerHTML = '';
            channels.forEach(channel => {
                const li = document.createElement('li');
                li.innerHTML = `<a href="#" class="channel-link" data-id="${channel.id}"><i class="${channel.icon}"></i> ${channel.name}</a>`;
                channelsList.appendChild(li);
            });
        };
        const renderMessage = (msg) => {
            const avatarUrl = `https://i.pravatar.cc/40?u=${encodeURIComponent(msg.username)}`;
            const formattedTime = new Date(msg.timestamp).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            const sanitizedContent = msg.content.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            return `<div class="message"><img src="${avatarUrl}" alt="Avatar" class="avatar"><div class="message-content"><div class="message-header"><span class="username">${sanitizedContent}</span><span class="timestamp">${formattedTime}</span></div><p>${sanitizedContent}</p></div></div>`;
        };
        const renderMembers = (members) => {
            const membersList = document.getElementById('members-list');
            if (!membersList) return;
            membersList.innerHTML = '';
            members.forEach(member => {
                const li = document.createElement('li');
                li.innerHTML = `<img src="https://i.pravatar.cc/32?u=${encodeURIComponent(member.username)}" alt="Avatar"><span class="name">${member.username}</span><span class="status online"></span>`;
                membersList.appendChild(li);
            });
        };
        const closeAllPanels = () => {
            if(channelsPanel) channelsPanel.classList.remove('is-open');
            if(infoPanel) infoPanel.classList.remove('is-open');
            if(hubBackdrop) hubBackdrop.classList.remove('is-active');
        };

        // -- C. Definisi Fungsi Utama (API & Event) --
        async function fetchAPI(url) {
            const response = await fetch(url);
            if (!response.ok) {
                const errorText = await response.text();
                console.error(`HTTP error! Status: ${response.status}`, errorText);
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return await response.json();
        }

        async function fetchChannels() {
            try {
                const channels = await fetchAPI('../api/get_data.php?action=get_channels');
                if (channels && !channels.error) {
                    renderChannels(channels);
                } else {
                    channelsList.innerHTML = `<li class="loading error">${channels.error || 'Data channel tidak valid.'}</li>`;
                }
            } catch (error) {
                console.error('Gagal total dalam fetchChannels:', error);
                if (channelsList) channelsList.innerHTML = '<li class="loading error">Gagal memuat channel.</li>';
            }
        }

        async function loadChannelContent(channelId) {
            currentChannelId = channelId;
            try {
                const data = await fetchAPI(`../api/get_data.php?action=get_content&channel_id=${channelId}`);
                if (data.error) throw new Error(data.error);
                
                const chatMessages = document.getElementById('chat-messages');
                chatMessages.innerHTML = data.messages.length > 0 ? data.messages.map(renderMessage).join('') : '<div class="loading">Belum ada pesan di channel ini.</div>';
                chatMessages.scrollTop = chatMessages.scrollHeight;

                renderMembers(data.members);
                
                document.querySelectorAll('.channel-link').forEach(l => l.classList.remove('active'));
                const activeChannelLink = document.querySelector(`.channel-link[data-id='${channelId}']`);
                if (activeChannelLink) {
                    activeChannelLink.classList.add('active');
                    document.getElementById('channel-name').textContent = activeChannelLink.textContent.trim();
                    document.getElementById('message-input').placeholder = `Message #${activeChannelLink.textContent.trim()}...`;
                }
                document.getElementById('channel-member-count').textContent = `${data.members.length} members`;
            } catch (error) {
                console.error(`Error loading content for channel ${channelId}:`, error);
            }
        }
        
        async function sendMessage(e) {
            e.preventDefault();
            const messageInput = document.getElementById('message-input');
            const content = messageInput.value.trim();
            if (content === '') return;
            const originalValue = content;
            messageInput.value = '';

            try {
                const response = await fetch('../api/send_message.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ channel_id: currentChannelId, content: originalValue })
                });
                const result = await response.json();
                if (result.success) {
                    const chatMessages = document.getElementById('chat-messages');
                    chatMessages.innerHTML += renderMessage(result.message);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                } else {
                    console.error('Gagal mengirim pesan:', result.error);
                    messageInput.value = originalValue; // Kembalikan teks jika gagal
                }
            } catch (error) {
                console.error('Error saat mengirim pesan:', error);
                messageInput.value = originalValue; // Kembalikan teks jika gagal
            }
        }

        // -- D. Pendaftaran Event Listener & Inisialisasi --
        if (channelsToggleBtn) channelsToggleBtn.addEventListener('click', () => { channelsPanel.classList.add('is-open'); hubBackdrop.classList.add('is-active'); });
        if (infoToggleBtn) infoToggleBtn.addEventListener('click', () => { infoPanel.classList.add('is-open'); hubBackdrop.classList.add('is-active'); });
        if (hubBackdrop) hubBackdrop.addEventListener('click', closeAllPanels);
        if (messageForm) messageForm.addEventListener('submit', sendMessage);
        
        if (channelsList) {
            channelsList.addEventListener('click', (e) => {
                const link = e.target.closest('.channel-link');
                if (link) {
                    e.preventDefault();
                    const channelId = link.dataset.id;
                    if(channelId !== currentChannelId) {
                        loadChannelContent(channelId);
                    }
                    closeAllPanels();
                }
            });
        }
        
        // Inisialisasi: Ambil daftar channel, setelah itu baru muat konten channel pertama.
        fetchChannels().then(() => {
            loadChannelContent(currentChannelId);
        });
    }

    if (document.querySelector('.notifications-page')) {
        const notificationsList = document.getElementById('notifications-list');
        const emptyState = document.getElementById('empty-state');

        function getIconForType(type) {
            switch(type) {
                case 'reply': return 'fa-solid fa-reply';
                case 'team_invite': return 'fa-solid fa-people-group';
                case 'like': return 'fa-solid fa-heart';
                case 'event_reminder': return 'fa-solid fa-calendar-check';
                default: return 'fa-solid fa-bell';
            }
        }

        function renderNotifications(notifications) {
            if (!notificationsList || !emptyState) return;

            if (notifications.length === 0) {
                notificationsList.style.display = 'none';
                emptyState.style.display = 'block';
                return;
            }

            notificationsList.style.display = 'block';
            emptyState.style.display = 'none';
            notificationsList.innerHTML = ''; // Kosongkan daftar

            const unreadNotifs = notifications.filter(n => n.is_read == 0);
            const readNotifs = notifications.filter(n => n.is_read == 1);

            let html = '';
            if (unreadNotifs.length > 0) {
                html += '<div class="notification-group"><h3 class="notification-group-title">Baru</h3>';
                unreadNotifs.forEach(n => {
                    html += `
                        <div class="notification-item unread" data-id="${n.id}">
                            <i class="icon ${getIconForType(n.type)}"></i>
                            <div class="content">${n.content}</div>
                            <div class="timestamp">${new Date(n.created_at).toLocaleDateString('id-ID')}</div>
                        </div>`;
                });
                html += '</div>';
            }

            if (readNotifs.length > 0) {
                html += '<div class="notification-group"><h3 class="notification-group-title">Sebelumnya</h3>';
                readNotifs.forEach(n => {
                    html += `
                        <div class="notification-item" data-id="${n.id}">
                            <i class="icon ${getIconForType(n.type)}"></i>
                            <div class="content">${n.content}</div>
                            <div class="timestamp">${new Date(n.created_at).toLocaleDateString('id-ID')}</div>
                        </div>`;
                });
                html += '</div>';
            }
            
            notificationsList.innerHTML = html;
        }

        async function loadNotifications() {
            try {
                const response = await fetch('../api/get_data.php?action=get_notifications');
                const notifications = await response.json();
                if (notifications && !notifications.error) {
                    renderNotifications(notifications);
                }
            } catch (error) {
                console.error('Gagal memuat notifikasi:', error);
            }
        }

        // Inisialisasi
        loadNotifications();
    }
    // --- BAGIAN 4: LOGIKA HALAMAN PESAN PRIBADI ---
    if (document.querySelector('.messages-container')) {
        let currentRecipientId = null;
        const conversationsList = document.getElementById('conversations-list');
        const dmChatView = document.getElementById('dm-chat-view');
        const dmWelcomeScreen = document.getElementById('dm-welcome-screen');
        const dmChatHeader = document.getElementById('dm-chat-header');
        const dmChatMessages = document.getElementById('dm-chat-messages');
        const messageForm = document.getElementById('dm-message-form');
        const messageInput = document.getElementById('dm-message-input');
        
        // Fungsi untuk merender daftar percakapan di kiri
        const renderConversations = (conversations) => {
            conversationsList.innerHTML = '';
            conversations.forEach(convo => {
                const li = document.createElement('li');
                li.className = 'conversation-item';
                li.dataset.userId = convo.id;
                li.dataset.username = convo.username;
                li.innerHTML = `<img src="https://i.pravatar.cc/40?u=${convo.username}" alt="Avatar"><span class="name">${convo.username}</span>`;
                conversationsList.appendChild(li);
            });
        };

        // Fungsi untuk merender pesan di jendela chat
        const renderDirectMessages = (messages) => {
            dmChatMessages.innerHTML = '';
            messages.forEach(msg => {
                // Asumsikan kita punya ID user saat ini (perlu didapat dari sesi PHP)
                const currentUserId = <?php echo json_encode($_SESSION['user_id']); ?>;
                const messageClass = msg.sender_id == currentUserId ? 'sent' : 'received';
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `dm-message ${messageClass}`;
                if (messageClass === 'received') {
                    messageDiv.innerHTML = `<img src="https://i.pravatar.cc/36?u=${dmChatHeader.dataset.username}" alt="Avatar" class="avatar"><div class="content">${msg.content}</div>`;
                } else {
                    messageDiv.innerHTML = `<div class="content">${msg.content}</div>`;
                }
                dmChatMessages.appendChild(messageDiv);
            });
            dmChatMessages.scrollTop = dmChatMessages.scrollHeight;
        };
        
        // Fungsi untuk memuat percakapan
        async function loadConversation(userId, username) {
            currentRecipientId = userId;
            document.querySelectorAll('.conversation-item').forEach(item => item.classList.remove('active'));
            document.querySelector(`.conversation-item[data-user-id='${userId}']`).classList.add('active');

            dmWelcomeScreen.style.display = 'none';
            dmChatView.style.display = 'flex';

            dmChatHeader.dataset.username = username;
            dmChatHeader.innerHTML = `<img src="https://i.pravatar.cc/40?u=${username}" alt="Avatar"><div class="user-info"><div class="name">${username}</div><div class="status">last seen today at 10:21</div></div>`;
            messageInput.placeholder = `Message ${username}...`;

            try {
                const messages = await fetchAPI(`../api/get_data.php?action=get_direct_messages&user_id=${userId}`);
                renderDirectMessages(messages);
            } catch (error) {
                console.error("Gagal memuat pesan:", error);
            }
        }
        
        // Event listener untuk memilih percakapan
        conversationsList.addEventListener('click', (e) => {
            const item = e.target.closest('.conversation-item');
            if (item) {
                loadConversation(item.dataset.userId, item.dataset.username);
            }
        });

        // Event listener untuk mengirim pesan
        messageForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const content = messageInput.value.trim();
            if (content === '' || !currentRecipientId) return;
            
            messageInput.value = '';
            try {
                await fetch('../api/send_direct_message.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({recipient_id: currentRecipientId, content: content})
                });
                // Muat ulang pesan setelah mengirim
                loadConversation(currentRecipientId, dmChatHeader.dataset.username);
            } catch (error) {
                console.error("Gagal mengirim pesan:", error);
            }
        });

        // Inisialisasi: muat daftar percakapan saat halaman dibuka
        async function initMessagesPage() {
            try {
                const conversations = await fetchAPI('../api/get_data.php?action=get_conversations');
                renderConversations(conversations);
            } catch (error) {
                console.error("Gagal memuat percakapan:", error);
            }
        }
        initMessagesPage();
    }

    if (document.querySelector('.profile-page')) {
        const profileUsername = document.getElementById('profile-username');
        const profileEmail = document.getElementById('profile-email');
        const profileJoinDate = document.getElementById('profile-joindate');
        const formUsername = document.getElementById('username');
        const formEmail = document.getElementById('email');

        async function loadProfileData() {
            try {
                const data = await fetchAPI('../api/get_data.php?action=get_profile_data');
                if (data && !data.error) {
                    profileUsername.textContent = data.username;
                    profileEmail.textContent = data.email;
                    profileJoinDate.textContent = new Date(data.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
                    formUsername.value = data.username;
                    formEmail.value = data.email;
                    // Update avatar dengan username
                    document.getElementById('profile-avatar').src = `https://i.pravatar.cc/120?u=${encodeURIComponent(data.username)}`;
                }
            } catch (error) {
                console.error("Gagal memuat data profil:", error);
            }
        }
        
        function showFormMessage(elementId, message, isSuccess) {
            const el = document.getElementById(elementId);
            el.textContent = message;
            el.className = `form-message ${isSuccess ? 'success' : 'error'}`;
            el.style.display = 'block';
            setTimeout(() => { el.style.display = 'none'; }, 5000);
        }

        // Event listener untuk form update profil
        document.getElementById('update-profile-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const response = await fetch('../api/update_profile.php', { method: 'POST', body: formData });
            const result = await response.json();
            showFormMessage('profile-message', result.message || result.error, result.success);
            if(result.success) {
                loadProfileData(); // Muat ulang data untuk menampilkan perubahan
            }
        });
        
        // Event listener untuk form ganti password
        document.getElementById('change-password-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const response = await fetch('../api/update_profile.php', { method: 'POST', body: formData });
            const result = await response.json();
            showFormMessage('password-message', result.message || result.error, result.success);
            if(result.success) {
                this.reset(); // Kosongkan form jika berhasil
            }
        });

        // Inisialisasi
        loadProfileData();
    }
});
</script>
</body>
</html>