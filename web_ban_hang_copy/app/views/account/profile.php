<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="profile-card">
                <div class="profile-header">
                    <h1 class="profile-title">Thông tin tài khoản</h1>
                </div>
                <div class="profile-body">
                    <div class="profile-avatar-section text-center mb-4">
                        <div class="avatar-wrapper">
                            <img src="/web_ban_hang_copy/<?php echo htmlspecialchars($user['avatar']); ?>" 
                                 alt="Avatar" 
                                 class="profile-avatar"
                                 id="avatar-preview">
                            <div class="avatar-overlay">
                                <label for="avatar-upload" class="avatar-upload-label">
                                    <i class="fas fa-camera"></i>
                                </label>
                            </div>
                        </div>
                        <form id="avatar-form" class="mt-2" enctype="multipart/form-data">
                            <input type="file" id="avatar-upload" name="avatar" accept="image/*" style="display: none;">
                            <small class="text-muted d-block">Click vào ảnh để thay đổi avatar</small>
                        </form>
                    </div>
                    
                    <div class="profile-info">
                        <div class="info-group">
                            <label>Tên đăng nhập</label>
                            <p><?php echo htmlspecialchars($user['username']); ?></p>
                        </div>
                        <div class="info-group">
                            <label>Email</label>
                            <p><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                        <div class="info-group">
                            <label>Vai trò</label>
                            <p><?php echo $user['role'] === 'admin' ? 'Quản trị viên' : 'Người dùng'; ?></p>
                        </div>
                        <div class="info-group">
                            <label>Số dư tài khoản</label>
                            <p class="balance-amount">
                                <?php echo number_format($user['balance'], 0, ',', '.'); ?> USD
                            </p>
                        </div>
                        <div class="info-group">
                            <label>Ngày tham gia</label>
                            <p><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
                        </div>
                        <div class="info-group">
                            <label>Lần đăng nhập cuối</label>
                            <p><?php echo $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Chưa có'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .profile-header {
        background-color: rgb(85, 92, 99);
        padding: 25px 30px;
        color: white;
    }

    .profile-title {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .profile-body {
        padding: 30px;
    }

    .profile-info {
        display: grid;
        gap: 20px;
    }

    .info-group {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    .info-group:last-child {
        border-bottom: none;
    }

    .info-group label {
        display: block;
        color: #666;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .info-group p {
        color: #333;
        font-size: 16px;
        font-weight: 500;
        margin: 0;
    }

    .profile-avatar-section {
        position: relative;
        margin: -50px auto 30px;
    }

    .avatar-wrapper {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        cursor: pointer;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }

    .avatar-upload-label {
        color: white;
        font-size: 24px;
        cursor: pointer;
    }

    .balance-amount {
        color: #28a745;
        font-size: 18px;
        font-weight: 600;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarUpload = document.getElementById('avatar-upload');
    const avatarPreview = document.getElementById('avatar-preview');
    const avatarForm = document.getElementById('avatar-form');
    const avatarWrapper = document.querySelector('.avatar-wrapper');

    avatarWrapper.addEventListener('click', () => avatarUpload.click());

    avatarUpload.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const formData = new FormData(avatarForm);
            
            fetch('/web_ban_hang_copy/account/updateAvatar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    avatarPreview.src = '/web_ban_hang_copy/' + data.avatar;
                    alert('Avatar đã được cập nhật thành công!');
                } else {
                    alert(data.message || 'Có lỗi xảy ra khi cập nhật avatar');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật avatar');
            });
        }
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
