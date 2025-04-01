<?php include 'app/views/shares/header.php'; ?>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white login-card">
                    <div class="card-body p-5">
                        <form id="login-form">
                            <div class="mb-md-4 mt-md-3 pb-4">
                                <h2 class="fw-bold mb-3 text-uppercase text-center">Đăng nhập</h2>
                                <p class="text-white-50 mb-4 text-center">Vui lòng nhập thông tin đăng nhập</p>

                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark text-white border-right-0">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="username"
                                            class="form-control form-control-lg bg-dark text-white border-left-0"
                                            placeholder="Tên đăng nhập" required />
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark text-white border-right-0">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-lg bg-dark text-white border-left-0 border-right-0"
                                            placeholder="Mật khẩu" required />
                                        <div class="input-group-append">
                                            <span
                                                class="input-group-text bg-dark text-white border-left-0 toggle-password"
                                                onclick="togglePassword()">
                                                <i class="far fa-eye" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                        <label class="form-check-label text-white-50" for="remember">Ghi nhớ đăng
                                            nhập</label>
                                    </div>
                                    <a class="text-white-50 forgot-link" href="#!">Quên mật khẩu?</a>
                                </div>

                                <button class="btn btn-outline-light btn-lg w-100 login-btn" type="submit">Đăng
                                    nhập</button>
                                
                                <div id="login-message" class="mt-3 text-center" style="display: none;"></div>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">Chưa có tài khoản? <a href="/web_ban_hang_copy/account/register"
                                        class="text-white-50 fw-bold signup-link">Đăng ký</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>

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

    .forgot-link:hover {
        color: white !important;
        text-decoration: underline;
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

    .social-login {
        position: relative;
        margin: 25px 0 15px;
    }

    .divider {
        position: relative;
        margin-bottom: 20px;
    }

    .divider:before,
    .divider:after {
        content: "";
        position: absolute;
        top: 50%;
        width: 30%;
        height: 1px;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .divider:before {
        left: 0;
    }

    .divider:after {
        right: 0;
    }

    .divider span {
        display: inline-block;
        padding: 0 10px;
    }

    .social-icon {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.3);
        margin: 0 10px;
        transition: all 0.3s;
    }

    .social-icon:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-3px);
    }

    .signup-link {
        transition: color 0.3s;
    }

    .signup-link:hover {
        color: white !important;
        text-decoration: underline;
    }
    
    #login-message {
        padding: 10px;
        border-radius: 5px;
    }
    
    .message-success {
        background-color: rgba(25, 135, 84, 0.2);
        color: #198754;
    }
    
    .message-error {
        background-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
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
    
    // Xử lý đăng nhập với JWT
    document.getElementById('login-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(this);
        const jsonData = {};
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });
        
        // Hiển thị trạng thái đang xử lý
        const loginMessage = document.getElementById('login-message');
        loginMessage.innerHTML = 'Đang xử lý...';
        loginMessage.className = '';
        loginMessage.style.display = 'block';
        
        // Gửi yêu cầu đăng nhập
        fetch('/web_ban_hang_copy/account/checklogin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(jsonData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Đăng nhập thất bại');
            }
            return response.json();
        })
        .then(data => {
            if (data.token) {
                // Lưu JWT token vào localStorage
                localStorage.setItem('jwtToken', data.token);
                
                // Lưu thông tin người dùng nếu có
                if (data.user) {
                    localStorage.setItem('user', JSON.stringify(data.user));
                }
                
                // Hiển thị thông báo thành công
                loginMessage.innerHTML = 'Đăng nhập thành công! Đang chuyển hướng...';
                loginMessage.className = 'message-success';
                
                // Thiết lập token cho tất cả các yêu cầu tiếp theo
                setupAuthHeader(data.token);
                
                // Chuyển hướng sau khi đăng nhập thành công
                setTimeout(() => {
                    window.location.href = '/web_ban_hang_copy/Product';
                }, 1000);
            } else {
                // Hiển thị thông báo lỗi
                loginMessage.innerHTML = 'Đăng nhập thất bại: Thông tin không hợp lệ';
                loginMessage.className = 'message-error';
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            loginMessage.innerHTML = 'Đăng nhập thất bại: ' + error.message;
            loginMessage.className = 'message-error';
        });
    });
    
    // Hàm thiết lập token cho các yêu cầu tiếp theo
    function setupAuthHeader(token) {
        // Thêm token vào tất cả các yêu cầu fetch trong tương lai
        const originalFetch = window.fetch;
        window.fetch = function(url, options = {}) {
            if (!options.headers) {
                options.headers = {};
            }
            
            // Thêm Authorization header với JWT token
            if (token) {
                options.headers['Authorization'] = 'Bearer ' + token;
            }
            
            return originalFetch(url, options);
        };
    }
    
    // Kiểm tra nếu đã có token từ trước
    document.addEventListener('DOMContentLoaded', function() {
        const token = localStorage.getItem('jwtToken');
        if (token) {
            setupAuthHeader(token);
        }
    });
</script>