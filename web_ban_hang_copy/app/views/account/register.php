<?php include 'app/views/shares/header.php'; ?>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white login-card">
                    <div class="card-body p-5">
                        <form id="register-form">
                            <div class="mb-md-4 mt-md-3 pb-4">
                                <h2 class="fw-bold mb-3 text-uppercase text-center">Đăng ký</h2>
                                <p class="text-white-50 mb-4 text-center">Vui lòng nhập thông tin đăng ký</p>

                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark text-white border-right-0">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="username" class="form-control form-control-lg bg-dark text-white border-left-0" placeholder="Tên đăng nhập" required />
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark text-white border-right-0">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </div>
                                        <input type="email" name="email" class="form-control form-control-lg bg-dark text-white border-left-0" placeholder="Email" required />
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark text-white border-right-0">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" name="password" id="password" class="form-control form-control-lg bg-dark text-white border-left-0 border-right-0" placeholder="Mật khẩu" required />
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-dark text-white border-left-0 toggle-password" onclick="togglePassword()">
                                                <i class="far fa-eye" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-outline-light btn-lg w-100 login-btn" type="submit">Đăng ký</button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">Đã có tài khoản? <a href="/web_ban_hang_copy/account/login" class="text-white-50 fw-bold">Đăng nhập</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .gradient-custom {
        background-color: #ffffff;
    }

    .login-card {
        border-radius: 1rem;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    .form-control:focus {
        background-color: #212529;
        border-color: #6c757d;
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
    }

    .input-group-text {
        border-color: #6c757d;
    }

    .toggle-password {
        cursor: pointer;
    }

    .login-btn {
        transition: all 0.3s;
        border-radius: 2rem;
        padding: 10px 20px;
        font-weight: 600;
    }

    .login-btn:hover {
        background-color: #ffffff;
        color: #212529;
        transform: translateY(-2px);
    }
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

document.getElementById('register-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const jsonData = {};
    formData.forEach((value, key) => { jsonData[key] = value; });

    fetch('/web_ban_hang_copy/account/processRegister', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Đăng ký thành công!');
            window.location.href = '/web_ban_hang_copy/account/login';
        } else {
            // Hiển thị thông báo lỗi cụ thể từ server
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Log lỗi chi tiết vào console để debug
        console.log('Detailed error:', error);
        alert('Có lỗi xảy ra khi đăng ký! Vui lòng thử lại sau.');
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>