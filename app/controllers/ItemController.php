<?php
require_once __DIR__ . '/../models/Item.php';

class ItemController extends BaseController {
    private $itemModel;

    public function __construct() {
        parent::__construct();
        $this->itemModel = new Item();
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debug log
            error_log("Form submitted: " . print_r($_POST, true));
            error_log("Files submitted: " . print_r($_FILES, true));

            // Check upload directory
            if (!file_exists(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0777, true);
                error_log("Created upload directory: " . UPLOAD_DIR);
            }

            $uploadDir = UPLOAD_DIR;
            $imagePath = '';
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                error_log("Attempting to upload file to: " . $uploadFile);
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imagePath = '/public/uploads/' . $fileName;
                    error_log("File uploaded successfully to: " . $imagePath);
                } else {
                    error_log("File upload failed. Upload error: " . $_FILES['image']['error']);
                }
            }

            $itemData = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'description' => $_POST['description'],
                'image_path' => $imagePath,
                'seller_contact' => $_POST['seller_contact']
            ];

            error_log("Attempting to create item with data: " . print_r($itemData, true));

            try {
                if ($this->itemModel->create($itemData)) {
                    error_log("Item created successfully");
                    header('Location: /project/public/index.php?success=1');
                    exit;
                } else {
                    error_log("Failed to create item");
                }
            } catch (Exception $e) {
                error_log("Error creating item: " . $e->getMessage());
            }
        }
        
        $this->render('items/add');
    }
    public function delete() {
        try {
            // Get all items for display
            $items = $this->itemModel->getAllItems();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_name'])) {
                error_log("Attempting to delete item: " . $_POST['item_name']);
                
                if ($this->itemModel->deleteByName($_POST['item_name'])) {
                    error_log("Item deleted successfully");
                    header('Location: /project/public/index.php?action=delete&success=1');
                    exit;
                } else {
                    error_log("Failed to delete item");
                    header('Location: /project/public/index.php?action=delete&error=1');
                    exit;
                }
            }
            
            // Add success/error messages
            $message = '';
            if (isset($_GET['success'])) {
                $message = '<div class="alert alert-success">Item deleted successfully!</div>';
            } else if (isset($_GET['error'])) {
                $message = '<div class="alert alert-danger">Failed to delete item!</div>';
            }
            
            $this->render('items/delete', [
                'items' => $items,
                'message' => $message
            ]);
        } catch (Exception $e) {
            error_log("Error in delete method: " . $e->getMessage());
            die("An error occurred while processing your request.");
        }
}}
?>