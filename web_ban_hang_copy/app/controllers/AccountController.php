<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/utils/JWTHandler.php');

class AccountController {
    private $accountModel;
    private $jwtHandler;

    public function __construct() {
        $this->accountModel = new AccountModel();
        $this->jwtHandler = new JWTHandler();
    }

    public function login() {
        require 'app/views/account/login.php';
    }

    public function register() {
        require 'app/views/account/register.php';
    }

    public function checkLogin() {
        // Kiểm tra xem dữ liệu có phải là JSON hay form data
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        
        if ($contentType === 'application/json') {
            $data = json_decode(file_get_contents('php://input'), true);
        } else {
            $data = $_POST;
        }
        
        // Kiểm tra dữ liệu đầu vào
        if (empty($data['username']) || empty($data['password'])) {
            if ($contentType === 'application/json') {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
                return;
            } else {
                header('Location: /web_ban_hang_copy/account/login');
                return;
            }
        }

        $username = $data['username'];
        $password = $data['password'];

        $user = $this->accountModel->findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            $token = $this->jwtHandler->encode([
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ]);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            if ($contentType === 'application/json') {
                echo json_encode(['success' => true, 'token' => $token]);
            } else {
                header('Location: /web_ban_hang_copy/Product');
            }
        } else {
            if ($contentType === 'application/json') {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
            } else {
                header('Location: /web_ban_hang_copy/account/login');
            }
        }
    }

    public function processRegister() {
        try {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Kiểm tra dữ liệu đầu vào
            if (empty($data['username']) || empty($data['password']) || empty($data['email'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin']);
                return;
            }

            // Kiểm tra username tồn tại
            if ($this->accountModel->findByUsername($data['username'])) {
                echo json_encode(['success' => false, 'message' => 'Tên đăng nhập đã tồn tại']);
                return;
            }

            // Kiểm tra email tồn tại 
            if ($this->accountModel->findByEmail($data['email'])) {
                echo json_encode(['success' => false, 'message' => 'Email đã được sử dụng']);
                return;
            }

            // Mã hóa mật khẩu và tạo tài khoản
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $result = $this->accountModel->create([
                'username' => $data['username'],
                'password' => $hashedPassword,
                'email' => $data['email'],
                'role' => 'user'
            ]);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Đăng ký thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Đăng ký thất bại, vui lòng thử lại']);
            }

        } catch (Exception $e) {
            // Ghi log lỗi
            error_log("Register Error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /web_ban_hang_copy/account/login');
    }

    public function profile() {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /web_ban_hang_copy/account/login');
            return;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->accountModel->getUserById($userId);

        if (!$user) {
            header('Location: /web_ban_hang_copy/account/login');
            return;
        }

        include 'app/views/account/profile.php';
    }

    public function updateAvatar() {
        if (!SessionHelper::isLoggedIn()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded']);
            return;
        }

        $file = $_FILES['avatar'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type']);
            return;
        }

        $uploadDir = 'public/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = uniqid() . '_' . $file['name'];
        $uploadPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            if ($this->accountModel->updateAvatar($_SESSION['user_id'], $uploadPath)) {
                echo json_encode(['success' => true, 'avatar' => $uploadPath]);
            } else {
                unlink($uploadPath);
                echo json_encode(['success' => false, 'message' => 'Database update failed']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'File upload failed']);
        }
    }
}
?>