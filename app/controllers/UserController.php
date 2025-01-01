<?php
require_once __DIR__ . '/../models/User.php';

class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function add() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input
            if (empty($_POST['username'])) {
                $errors[] = "Username is required";
            } elseif ($this->userModel->usernameExists($_POST['username'])) {
                $errors[] = "Username already exists";
            }

            if (empty($_POST['email'])) {
                $errors[] = "Email is required";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            } elseif ($this->userModel->emailExists($_POST['email'])) {
                $errors[] = "Email already exists";
            }

            if (empty($_POST['password'])) {
                $errors[] = "Password is required";
            } elseif (strlen($_POST['password']) < 6) {
                $errors[] = "Password must be at least 6 characters";
            }

            if (empty($_POST['full_name'])) {
                $errors[] = "Full name is required";
            }

            if (empty($errors)) {
                $userData = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'full_name' => $_POST['full_name'],
                    'phone' => $_POST['phone'] ?? ''
                ];

                try {
                    if ($this->userModel->create($userData)) {
                        header('Location: /project/public/index.php?action=addUser&success=1');
                        exit;
                    } else {
                        $errors[] = "Failed to create user";
                    }
                } catch (Exception $e) {
                    error_log("Error creating user: " . $e->getMessage());
                    $errors[] = "An error occurred while creating the user";
                }
            }
        }
        
        $this->render('users/add', ['errors' => $errors]);
    }

    public function delete() {
        try {
            $users = $this->userModel->getAllUsers();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
                if ($this->userModel->deleteByUsername($_POST['username'])) {
                    header('Location: /project/public/index.php?action=deleteUser&success=1');
                    exit;
                } else {
                    header('Location: /project/public/index.php?action=deleteUser&error=1');
                    exit;
                }
            }
            
            $message = '';
            if (isset($_GET['success'])) {
                $message = '<div class="alert alert-success">User deleted successfully!</div>';
            } else if (isset($_GET['error'])) {
                $message = '<div class="alert alert-danger">Failed to delete user!</div>';
            }
            
            $this->render('users/delete', [
                'users' => $users,
                'message' => $message
            ]);
        } catch (Exception $e) {
            error_log("Error in delete method: " . $e->getMessage());
            die("An error occurred while processing your request.");
        }
    }
    public function getFirstUser() {
        return $this->userModel->getFirstUser();
    }
    
    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }
}
?>