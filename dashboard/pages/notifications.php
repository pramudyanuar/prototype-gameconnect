<link rel="stylesheet" href="/../dashboard/style/notification.css">

<div class="notifications-page">
    <header class="notifications-header">
        <h1>Notifications</h1>
        <div class="actions">
            <button id="mark-all-read-btn"><i class="fa-solid fa-check-double"></i> Tandai semua telah dibaca</button>
        </div>
    </header>

    <div class="notifications-list" id="notifications-list">
        <p class="loading">Memuat notifikasi...</p>
    </div>

    <div class="empty-state" id="empty-state" style="display: none;">
        <i class="fa-regular fa-bell-slash"></i>
        <h3>Semua sudah dilihat</h3>
        <p>Anda tidak memiliki notifikasi baru saat ini.</p>
    </div>
</div>