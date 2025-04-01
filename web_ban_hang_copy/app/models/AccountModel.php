<?php
require_once('app/config/database.php');

class AccountModel {
    private $db;
    private $table = 'accounts'; // Đảm bảo tên bảng là 'accounts'

    public function __construct() {
        $this->db = new Database();
    }

    public function findByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";
        $this->db->query($sql);
        $this->db->bind(':username', $username);
        return $this->db->single();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $this->db->query($sql);
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (username, password, email, role) 
                VALUES (:username, :password, :email, :role)";
        
        $this->db->query($sql);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role', $data['role']);
        
        return $this->db->execute();
    }

    public function validate($data) {
        $errors = [];
        
        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        } elseif (strlen($data['username']) < 3) {
            $errors['username'] = 'Username must be at least 3 characters';
        }
        
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }
        
        return $errors;
    }

    public function updateLastLogin($userId) {
        $sql = "UPDATE {$this->table} SET last_login = CURRENT_TIMESTAMP WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateAvatar($userId, $avatarPath) {
        $sql = "UPDATE {$this->table} SET avatar = :avatar WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':avatar', $avatarPath);
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function updateBalance($userId, $amount) {
        $sql = "UPDATE {$this->table} SET balance = balance + :amount WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }

    public function getBalance($userId) {
        $sql = "SELECT balance FROM {$this->table} WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $userId);
        $result = $this->db->single();
        return $result ? $result['balance'] : 0;
    }
}
?>