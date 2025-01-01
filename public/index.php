<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/controllers/BaseController.php';
require_once __DIR__ . '/../app/controllers/ItemController.php';
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/controllers/CartController.php';
require_once __DIR__ . '/../app/models/Cart.php';

session_start();

// Initialize current user if not set
if (!isset($_SESSION['user_id']) && !isset($_GET['action'])) {
    $userController = new UserController();
    $firstUser = $userController->getFirstUser();
    if ($firstUser) {
        $_SESSION['user_id'] = $firstUser['id'];
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : 'add';
$userId = $_SESSION['user_id'] ?? null;

try {
    // Get cart count for the navigation
    if ($userId) {
        $cartModel = new Cart();
        $cartCount = $cartModel->getCartItemCount($userId);
    }

    // Get all users for the user switcher
    $userController = new UserController();
    $users = $userController->getAllUsers();

    switch($action) {
        case 'add':
            $controller = new ItemController();
            $controller->add();
            break;
            
        case 'delete':
            $controller = new ItemController();
            $controller->delete();
            break;
            
        case 'addUser':
            $controller = new UserController();
            $controller->add();
            break;
            
        case 'deleteUser':
            $controller = new UserController();
            $controller->delete();
            break;
            
        case 'addToCart':
            $controller = new CartController();
            $controller->addToCart();
            break;
            
        case 'viewCart':
            $controller = new CartController();
            $controller->viewCart();
            break;
            
        case 'removeFromCart':
            $controller = new CartController();
            $controller->removeFromCart();
            break;
            
        case 'updateQuantity':
            $controller = new CartController();
            $controller->updateQuantity();
            break;
            
        case 'clearCart':
            $controller = new CartController();
            $controller->clearCart();
            break;
            
        case 'switchUser':
            if (isset($_GET['user_id'])) {
                $_SESSION['user_id'] = $_GET['user_id'];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            break;
            
        default:
            header("HTTP/1.0 404 Not Found");
            echo "Page not found";
            exit();
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    die("An error occurred while processing your request.");
}

// Add data needed by layout
$view_data['userId'] = $userId;
$view_data['users'] = $users;
$view_data['cartCount'] = $cartCount ?? 0;
?>