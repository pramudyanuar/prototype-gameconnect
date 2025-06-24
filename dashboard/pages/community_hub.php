<link rel="stylesheet" href="/../dashboard/style/community-stye.css">
<div class="hub-container">
    <div class="hub-backdrop" id="hub-backdrop"></div>
    <div class="channels-panel" id="channels-panel">
        <div class="panel-header"><h2>Channels</h2><div class="header-actions"><i class="fa-solid fa-search"></i><i class="fa-solid fa-plus"></i></div></div>
        <ul class="channels-list" id="channels-list">
            <li class="loading">Memuat channels...</li>
        </ul>
        <button class="new-community-btn"><i class="fa-solid fa-plus"></i> New Community</button>
    </div>
    <div class="chat-panel">
        <div class="panel-header chat-header">
            <div class="channel-title" id="channel-title-header">
                <button class="header-icon-btn" id="channels-toggle-btn"><i class="fa-solid fa-bars"></i></button>
                <i class="fa-solid fa-hashtag desktop-icon"></i>
                <h3 id="channel-name">general</h3>
            </div>
            <div class="channel-info">
                <span class="desktop-info" id="channel-member-count"></span>
                <button class="header-icon-btn" id="info-toggle-btn"><i class="fa-solid fa-users"></i></button>
            </div>
        </div>
        <div class="chat-messages" id="chat-messages">
            </div>
        <form class="chat-input-box" id="message-form">
            <img src="https://i.pravatar.cc/40?u=currentuser" alt="Your Avatar" class="avatar">
            <input type="text" id="message-input" placeholder="Message #general..." autocomplete="off" required>
            <button type="submit" class="send-btn"><i class="fa-solid fa-paper-plane"></i></button>
        </form>
    </div>
    <div class="info-panel" id="info-panel">
        <div class="info-section">
            <div class="section-header"><h3>Members</h3><i class="fa-solid fa-user-plus"></i></div>
            <ul class="members-list" id="members-list">
                </ul>
        </div>
        </div>
</div>