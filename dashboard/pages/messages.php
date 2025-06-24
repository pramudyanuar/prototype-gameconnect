<link rel="stylesheet" href="/../dashboard/style/messages.css">
<div class="messages-container">
    <div class="conversations-panel">
        <div class="panel-header">
            <h2>Friends</h2>
            <button class="icon-btn"><i class="fa-solid fa-plus"></i></button>
        </div>
        <ul class="conversations-list" id="conversations-list">
            <li class="loading">Memuat percakapan...</li>
        </ul>
    </div>

    <div class="dm-chat-panel">
        <div class="dm-welcome-screen" id="dm-welcome-screen">
            <i class="fa-regular fa-comments"></i>
            <h3>Pilih percakapan untuk memulai</h3>
        </div>

        <div class="dm-chat-view" id="dm-chat-view" style="display: none;">
            <header class="dm-chat-header" id="dm-chat-header">
                </header>
            <div class="dm-chat-messages" id="dm-chat-messages">
                </div>
            <form class="dm-message-form" id="dm-message-form">
                <input type="text" id="dm-message-input" placeholder="Kirim pesan..." autocomplete="off" required>
                <button type="submit" class="send-btn"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>