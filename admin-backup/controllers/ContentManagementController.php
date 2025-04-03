<?php
require_once __DIR__ . '/../config.php'; // รวม config.php เพื่อใช้ IMAGE_UPLOAD_DIR และ PDO

class ContentManagementController {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function manage() {
        // ดึงข้อมูลทั้งหมดจากตาราง blocks
        $stmt = $this->pdo->query("SELECT * FROM blocks");
        $GLOBALS['blocks'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // จัดการ Blocks
        $this->handleBlocks();
    }

    private function handleBlocks() {
        // เพิ่ม Block
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_block') {
            $image_url = $this->handleImageUpload('image', $_POST['image_url']);
            $title = $_POST['title'];
            $detail1 = $_POST['detail1'];
            $detail2 = $_POST['detail2'];
            $detail3 = $_POST['detail3'];
            $description = $_POST['description'];

            if ($image_url) {
                $stmt = $this->pdo->prepare("INSERT INTO blocks (image_url, title, detail1, detail2, detail3, description) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$image_url, $title, $detail1, $detail2, $detail3, $description]);
                header("Location: index.php?page=content_management");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
            }
        }

        // แก้ไข Block
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_block') {
            $id = $_POST['id'];
            $image_url = $this->handleImageUpload('image', $_POST['image_url']);
            $title = $_POST['title'];
            $detail1 = $_POST['detail1'];
            $detail2 = $_POST['detail2'];
            $detail3 = $_POST['detail3'];
            $description = $_POST['description'];

            $stmt = $this->pdo->prepare("SELECT image_url FROM blocks WHERE id = ?");
            $stmt->execute([$id]);
            $old_block = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($image_url) {
                if ($old_block['image_url'] && file_exists(IMAGE_UPLOAD_DIR . basename($old_block['image_url']))) {
                    unlink(IMAGE_UPLOAD_DIR . basename($old_block['image_url']));
                }
                $stmt = $this->pdo->prepare("UPDATE blocks SET image_url = ?, title = ?, detail1 = ?, detail2 = ?, detail3 = ?, description = ? WHERE id = ?");
                $stmt->execute([$image_url, $title, $detail1, $detail2, $detail3, $description, $id]);
                header("Location: index.php?page=content_management");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
            }
        }

        // ลบ Block
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_block') {
            $id = $_GET['id'];
            $stmt = $this->pdo->prepare("SELECT image_url FROM blocks WHERE id = ?");
            $stmt->execute([$id]);
            $block = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($block['image_url'] && file_exists(IMAGE_UPLOAD_DIR . basename($block['image_url']))) {
                unlink(IMAGE_UPLOAD_DIR . basename($block['image_url']));
            }
            $stmt = $this->pdo->prepare("DELETE FROM blocks WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: index.php?page=content_management");
            exit;
        }
    }

    private function handleImageUpload($fileInputName, $urlInput) {
        if (!empty($urlInput)) {
            return $urlInput;
        }

        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES[$fileInputName];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxFileSize = 5 * 1024 * 1024;

            if (!in_array($file['type'], $allowedTypes) || $file['size'] > $maxFileSize) {
                return false;
            }

            $fileName = uniqid() . '-' . basename($file['name']);
            $uploadPath = IMAGE_UPLOAD_DIR . $fileName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return IMAGE_UPLOAD_PATH . $fileName;
            }
        }
        return false;
    }
}