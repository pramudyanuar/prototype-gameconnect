<link rel="stylesheet" href="/../dashboard/style/profile.css">
<div class="profile-page">
    <div class="profile-sidebar">
        <div class="profile-card user-identity">
            <img src="https://i.pravatar.cc/120" alt="User Avatar" class="avatar" id="profile-avatar">
            <h2 class="username" id="profile-username">Memuat...</h2>
            <p class="email" id="profile-email">...</p>
            <button class="edit-avatar-btn"><i class="fa-solid fa-camera"></i> Ganti Avatar</button>
        </div>
        <div class="profile-card profile-stats">
            <div class="stat-item">
                <span class="stat-label">Bergabung Sejak</span>
                <span class="stat-value" id="profile-joindate">...</span>
            </div>
            </div>
    </div>

    <div class="profile-main">
        <div class="profile-card form-card">
            <h3>Detail Profil</h3>
            <form id="update-profile-form">
                <input type="hidden" name="action" value="update_details">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-actions">
                    <button type="submit">Simpan Perubahan</button>
                </div>
                <div class="form-message" id="profile-message"></div>
            </form>
        </div>

        <div class="profile-card form-card">
            <h3>Ganti Password</h3>
            <form id="change-password-form">
                <input type="hidden" name="action" value="change_password">
                <div class="form-group">
                    <label for="current_password">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Password Baru</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password Baru</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                 <div class="form-actions">
                    <button type="submit">Ganti Password</button>
                </div>
                <div class="form-message" id="password-message"></div>
            </form>
        </div>
    </div>
</div>