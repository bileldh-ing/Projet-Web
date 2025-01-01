<?php
// app/controllers/CartController.php

require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../models/User.php';

class CartController extends BaseController {
    private $cartModel;
    private $itemModel;
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->cartModel = new Cart();
        $this->itemModel = new Item();
        $this->userModel = new User();
    }

    public function addToCart() {
        // Get current user from session
        $currentUserId = $_SESSION['user_id'] ?? null;
        
        // Get all users for the dropdown
        $users = $this->userModel->getAllUsers();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $currentUserId ?? $_POST['user_id'];
            $itemId = $_POST['item_id'];
            
            // Debug the POST data
            error_log("POST data: " . print_r($_POST, true));
            
            // Ensure quantity is at least 1 and is an integer
            $quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;
    
            try {
                if (!$userId) {
                    throw new Exception('No user selected');
                }
    
                if (!$itemId) {
                    throw new Exception('No item selected');
                }
    
                // Debug the values being passed
                error_log("Adding to cart - User: $userId, Item: $itemId, Quantity: $quantity");
    
                if ($this->cartModel->addToCart($userId, $itemId, $quantity)) {
                    $_SESSION['message'] = "Item added to cart successfully! Quantity: $quantity";
                    header('Location: /project/public/index.php?action=viewCart');
                    exit;
                } else {
                    $_SESSION['error'] = 'Failed to add item to cart.';
                }
            } catch (Exception $e) {
                error_log("Error adding to cart: " . $e->getMessage());
                $_SESSION['error'] = 'An error occurred while adding to cart.';
            }
        }

        // Get all available items
        $items = $this->itemModel->getAllItems();
        
        // If we have items in cart, get their quantities
        $cartItems = [];
        if ($currentUserId) {
            $cartItems = $this->cartModel->getCartItems($currentUserId);
        }

        $this->render('cart/add', [
            'users' => $users,
            'items' => $items,
            'cartItems' => $cartItems,
            'currentUserId' => $currentUserId,
            'message' => $_SESSION['message'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);

        // Clear session messages
        unset($_SESSION['message'], $_SESSION['error']);
    }

    public function viewCart() {
        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$userId) {
            $_SESSION['error'] = 'Please select a user first.';
            header('Location: /project/public/index.php?action=addToCart');
            exit;
        }

        try {
            $cartItems = $this->cartModel->getCartItems($userId);
            $totalPrice = array_sum(array_column($cartItems, 'total_price'));
            
            $this->render('cart/view', [
                'cartItems' => $cartItems,
                'totalPrice' => $totalPrice,
                'userId' => $userId,
                'message' => $_SESSION['message'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]);

            // Clear session messages
            unset($_SESSION['message'], $_SESSION['error']);
        } catch (Exception $e) {
            error_log("Error viewing cart: " . $e->getMessage());
            $_SESSION['error'] = 'An error occurred while viewing the cart.';
            header('Location: /project/public/index.php');
            exit;
        }
    }

    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'] ?? $_POST['user_id'];
            $itemId = $_POST['item_id'];
            
            try {
                if ($this->cartModel->removeFromCart($userId, $itemId)) {
                    $_SESSION['message'] = 'Item removed from cart successfully!';
                } else {
                    $_SESSION['error'] = 'Failed to remove item from cart.';
                }
            } catch (Exception $e) {
                error_log("Error removing from cart: " . $e->getMessage());
                $_SESSION['error'] = 'An error occurred while removing the item.';
            }
            
            header('Location: /project/public/index.php?action=viewCart');
            exit;
        }
    }

    public function updateQuantity() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'] ?? $_POST['user_id'];
            $itemId = $_POST['item_id'];
            $quantity = (int)$_POST['quantity'];
            
            try {
                if ($quantity <= 0) {
                    // If quantity is 0 or negative, remove the item
                    $this->cartModel->removeFromCart($userId, $itemId);
                    $_SESSION['message'] = 'Item removed from cart.';
                } else {
                    if ($this->cartModel->updateQuantity($userId, $itemId, $quantity)) {
                        $_SESSION['message'] = 'Quantity updated successfully!';
                    } else {
                        $_SESSION['error'] = 'Failed to update quantity.';
                    }
                }
            } catch (Exception $e) {
                error_log("Error updating quantity: " . $e->getMessage());
                $_SESSION['error'] = 'An error occurred while updating the quantity.';
            }
            
            header('Location: /project/public/index.php?action=viewCart');
            exit;
        }
    }

    public function clearCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'] ?? $_POST['user_id'];
            
            try {
                if ($this->cartModel->clearCart($userId)) {
                    $_SESSION['message'] = 'Cart cleared successfully!';
                } else {
                    $_SESSION['error'] = 'Failed to clear cart.';
                }
            } catch (Exception $e) {
                error_log("Error clearing cart: " . $e->getMessage());
                $_SESSION['error'] = 'An error occurred while clearing the cart.';
            }
            
            header('Location: /project/public/index.php?action=viewCart');
            exit;
        }
    }

    public function getCartCount($userId) {
        try {
            return $this->cartModel->getCartItemCount($userId);
        } catch (Exception $e) {
            error_log("Error getting cart count: " . $e->getMessage());
            return 0;
        }
    }
}