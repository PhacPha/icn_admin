<?php
class WorkController {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;

        // ตรวจสอบและสร้างโฟลเดอร์ uploads หากยังไม่มี
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    }

    public function manage() {
        // ดึงข้อมูลผลงานทั้งหมด
        $stmt = $this->pdo->query("SELECT * FROM works");
        $works = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $GLOBALS['works'] = $works;

        // จัดการการเพิ่มผลงาน
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_work') {
            $title = $_POST['title'];
            $list_item1 = $_POST['list_item1'];
            $list_item2 = $_POST['list_item2'];
            $list_item3 = $_POST['list_item3'];
            $image_url = $this->handleImageUpload('image', $_POST['image_url']);

            if ($image_url) {
                $stmt = $this->pdo->prepare("INSERT INTO works (image_url, title, list_item1, list_item2, list_item3) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$image_url, $title, $list_item1, $list_item2, $list_item3]);
                header("Location: index.php?page=home");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
            }
        }

        // จัดการการแก้ไขผลงาน
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_work') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $list_item1 = $_POST['list_item1'];
            $list_item2 = $_POST['list_item2'];
            $list_item3 = $_POST['list_item3'];
            $image_url = $this->handleImageUpload('image', $_POST['image_url']);

            // ดึงข้อมูลผลงานเดิมเพื่อลบรูปภาพเก่า
            $stmt = $this->pdo->prepare("SELECT image_url FROM works WHERE id = ?");
            $stmt->execute([$id]);
            $old_work = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($image_url) {
                // ลบรูปภาพเก่าถ้ามี
                if ($old_work['image_url'] && file_exists(__DIR__ . '/../../' . $old_work['image_url'])) {
                    unlink(__DIR__ . '/../../' . $old_work['image_url']);
                }

                $stmt = $this->pdo->prepare("UPDATE works SET image_url = ?, title = ?, list_item1 = ?, list_item2 = ?, list_item3 = ? WHERE id = ?");
                $stmt->execute([$image_url, $title, $list_item1, $list_item2, $list_item3, $id]);
                header("Location: index.php?page=home");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
            }
        }

        // จัดการการลบผลงาน
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_work') {
            $id = $_GET['id'];

            // ดึงข้อมูลผลงานเพื่อลบรูปภาพ
            $stmt = $this->pdo->prepare("SELECT image_url FROM works WHERE id = ?");
            $stmt->execute([$id]);
            $work = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($work['image_url'] && file_exists(__DIR__ . '/../../' . $work['image_url'])) {
                unlink(__DIR__ . '/../../' . $work['image_url']);
            }

            $stmt = $this->pdo->prepare("DELETE FROM works WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: index.php?page=home");
            exit;
        }
    }

    private function handleImageUpload($fileInputName, $urlInput) {
        // ถ้ามี URL ให้ใช้ URL นั้น
        if (!empty($urlInput)) {
            return $urlInput;
        }

        // ถ้ามีการอัปโหลดไฟล์
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES[$fileInputName];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB

            // ตรวจสอบประเภทไฟล์
            if (!in_array($file['type'], $allowedTypes)) {
                return false;
            }

            // ตรวจสอบขนาดไฟล์
            if ($file['size'] > $maxFileSize) {
                return false;
            }

            // สร้างชื่อไฟล์ใหม่
            $fileName = uniqid() . '-' . basename($file['name']);
            $uploadDir = __DIR__ . '/../../uploads/';
            $uploadPath = $uploadDir . $fileName;

            // ย้ายไฟล์ไปยังโฟลเดอร์ uploads
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return '/uploads/' . $fileName;
            } else {
                return false;
            }
        }

        return false;
    }
}