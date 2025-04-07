<?php
require_once __DIR__ . '/../config/db_connect.php';

class ContactMessagesController {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function manage() {
        // ดึงข้อมูลทั้งหมดจากตาราง contact_messages
        $stmt = $this->pdo->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
        $GLOBALS['contact_messages'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // จัดการคำขอ
        $this->handleRequests();
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

        // อัปเดตสถานะการอ่าน
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'mark_read') {
            $id = $_GET['id'];
            $stmt = $this->pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: index.php?page=contact_messages");
            exit;
        }

        // ตอบกลับข้อความ (ส่งอีเมล)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reply_message') {
            $id = $_POST['id'];
            $reply_message = $_POST['reply_message'];

            $stmt = $this->pdo->prepare("SELECT email, subject FROM contact_messages WHERE id = ?");
            $stmt->execute([$id]);
            $message = $stmt->fetch(PDO::FETCH_ASSOC);

            // ส่งอีเมล (ตัวอย่างการใช้ mail() - ปรับตามระบบจริง)
            $to = $message['email'];
            $subject = "ตอบกลับ: " . $message['subject'];
            $body = "สวัสดีครับ/ค่ะ,\n\n" . $reply_message . "\n\nขอบคุณ,\nทีมงาน Iconnex Thailand";
            $headers = "From: no-reply@iconnexthailand.com";

            if (mail($to, $subject, $body, $headers)) {
                $stmt = $this->pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
                $stmt->execute([$id]);
                header("Location: index.php?page=contact_messages");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการส่งอีเมล');</script>";
            }
        }
    }
}