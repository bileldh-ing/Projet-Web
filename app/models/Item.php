<?php
class Item {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        try {
            $query = "INSERT INTO items (name, price, description, image_path, seller_contact) 
                     VALUES (:name, :price, :description, :image_path, :seller_contact)";
            
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([
                ':name' => $data['name'],
                ':price' => $data['price'],
                ':description' => $data['description'],
                ':image_path' => $data['image_path'],
                ':seller_contact' => $data['seller_contact']
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
    public function getAllItems() {
        $query = "SELECT * FROM items ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getItems() {
        try {
            $query = "SELECT id, name, price, description, image_path, seller_contact 
                     FROM items 
                     ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching items: " . $e->getMessage());
            return [];
        }
    }
   
public function deleteByName($name) {
    try {
        // First, get the image path before deleting
        $query = "SELECT image_path FROM items WHERE name = :name";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':name' => $name]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Delete the record
        $query = "DELETE FROM items WHERE name = :name";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute([':name' => $name]);
        
        // If deletion was successful and there was an image, delete it
        if ($result && $item && $item['image_path']) {
            $fullPath = $_SERVER['DOCUMENT_ROOT'] . $item['image_path'];
            if (file_exists($fullPath)) {
                unlink($fullPath);
                error_log("Deleted image file: " . $fullPath);
            }
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Database error in deleteByName(): " . $e->getMessage());
        return false;
    }
}
}
?>