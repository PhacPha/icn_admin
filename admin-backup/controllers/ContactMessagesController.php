<?php
require_once __DIR__ . '/../config/db_connect.php';

class ContactMessagesController {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function manage() {
        $stmt = $this->pdo->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
        $GLOBALS['contact_messages'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->handleRequests();
        $this->autoDeleteOldMessages();
    }

    private function handleRequests() {
        // ลบข้อความ
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_message') {
            $id = $_GET['id'];
            $stmt = $this->pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: index.php?page=contact_messages");
            exit;
        }

        // อัปเดตสถานะการอ่าน ( ยังไม่ค่อยเวิร์คเท่าไหร่ )
        // if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'mark_read') {
        //     $id = $_GET['id'];
        //     $stmt = $this->pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
        //     $stmt->execute([$id]);
        //     header("Location: index.php?page=contact_messages");
        //     exit;
        // }
    }

    private function autoDeleteOldMessages() {
        $stmt = $this->pdo->prepare("DELETE FROM contact_messages WHERE submitted_at < DATE_SUB(NOW(), INTERVAL 30 SECOND)");
        $stmt->execute();
    }
}