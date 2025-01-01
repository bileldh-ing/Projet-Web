<?php
abstract class BaseController {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    protected function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../views/layout.php";
    }
}
?>