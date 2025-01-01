<?php
// app/models/Cart.php
class Cart {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addToCart($userId, $itemId, $quantity = 1) {
        // First check if item exists in cart
        $checkQuery = "SELECT quantity FROM cart_items WHERE user_id = :user_id AND item_id = :item_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->execute([
            ':user_id' => $userId,
            ':item_id' => $itemId
        ]);
        $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
        if ($existing) {
            // Update existing item
            $query = "UPDATE cart_items SET quantity = quantity + :quantity 
                     WHERE user_id = :user_id AND item_id = :item_id";
        } else {
            // Insert new item
            $query = "INSERT INTO cart_items (user_id, item_id, quantity) 
                     VALUES (:user_id, :item_id, :quantity)";
        }
    
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':user_id' => $userId,
            ':item_id' => $itemId,
            ':quantity' => $quantity
        ]);
    }

    public function getCartItems($userId) {
        $query = "SELECT i.*, ci.quantity, (i.price * ci.quantity) as total_price 
                 FROM cart_items ci 
                 JOIN items i ON ci.item_id = i.id 
                 WHERE ci.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeFromCart($userId, $itemId) {
        $query = "DELETE FROM cart_items WHERE user_id = :user_id AND item_id = :item_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':user_id' => $userId,
            ':item_id' => $itemId
        ]);
    }

    public function updateQuantity($userId, $itemId, $quantity) {
        $query = "UPDATE cart_items 
                 SET quantity = :quantity 
                 WHERE user_id = :user_id 
                 AND item_id = :item_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':user_id' => $userId,
            ':item_id' => $itemId,
            ':quantity' => $quantity
        ]);
    }

    public function clearCart($userId) {
        $query = "DELETE FROM cart_items WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':user_id' => $userId]);
    }
    public function getCartItemCount($userId) {
        $query = "SELECT SUM(quantity) as count FROM cart_items WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
}
