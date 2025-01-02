<?php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        try {
            $query = "INSERT INTO users (username, email, password, full_name, phone) 
                     VALUES (:username, :email, :password, :full_name, :phone)";
            
            // Hash the password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':password' => $hashedPassword,
                ':full_name' => $data['full_name'],
                ':phone' => $data['phone']
            ]);

            if (!$result) {
                error_log("Database error: " . print_r($stmt->errorInfo(), true));
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Database error in create(): " . $e->getMessage());
            throw $e;
        }
    }

    public function getAllUsers() {
        try {
            $query = "SELECT id, username, email, full_name, phone, created_at FROM users ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getAllUsers(): " . $e->getMessage());
            return [];
        }
    }

    public function deleteByUsername($username) {
        try {
            $query = "DELETE FROM users WHERE username = :username";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([':username' => $username]);
        } catch (PDOException $e) {
            error_log("Database error in deleteByUsername(): " . $e->getMessage());
            return false;
        }
    }

    public function usernameExists($username) {
        $query = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetchColumn() > 0;
    }

    public function emailExists($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
    public function getFirstUser() {
        $query = "SELECT * FROM users ORDER BY id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getLatestUser() {
        try {
            $stmt = $this->db->query("
                SELECT username, full_name, email 
                FROM users 
                ORDER BY created_at DESC 
                LIMIT 1
            ");
            
            // Add debug information
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                error_log("No users found in database");
                return null;
            }
            
            error_log("Found user: " . print_r($result, true));
            return $result;
            
        } catch(PDOException $e) {
            error_log("Error fetching latest user: " . $e->getMessage());
            return null;
        }
    }
    
}
?>