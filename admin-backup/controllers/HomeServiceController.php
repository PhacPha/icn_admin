<?php
class HomeServiceController {
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
        // ดึงข้อมูลบริการทั้งหมด
        $stmt = $this->pdo->query("SELECT * FROM services");
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $GLOBALS['services'] = $services;

        // จัดการการเพิ่มบริการ
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_service') {
            $title = $_POST['title'];
            $list_item1 = $_POST['list_item1'];
            $list_item2 = $_POST['list_item2'];
            $list_item3 = $_POST['list_item3'];
            $icon_url = $this->handleImageUpload('icon', $_POST['icon_url']);

            if ($icon_url) {
                $stmt = $this->pdo->prepare("INSERT INTO services (icon_url, title, list_item1, list_item2, list_item3) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$icon_url, $title, $list_item1, $list_item2, $list_item3]);
                header("Location: index.php?page=home");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไอคอน');</script>";
            }
        }

        // จัดการการแก้ไขบริการ
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_service') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $list_item1 = $_POST['list_item1'];
            $list_item2 = $_POST['list_item2'];
            $list_item3 = $_POST['list_item3'];
            $icon_url = $this->handleImageUpload('icon', $_POST['icon_url']);

            // ดึงข้อมูลบริการเดิมเพื่อลบไอคอนเก่า
            $stmt = $this->pdo->prepare("SELECT icon_url FROM services WHERE id = ?");
            $stmt->execute([$id]);
            $old_service = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($icon_url) {
                // ลบไอคอนเก่าถ้ามี
                if ($old_service['icon_url'] && file_exists(__DIR__ . '/../../' . $old_service['icon_url'])) {
                    unlink(__DIR__ . '/../../' . $old_service['icon_url']);
                }

                $stmt = $this->pdo->prepare("UPDATE services SET icon_url = ?, title = ?, list_item1 = ?, list_item2 = ?, list_item3 = ? WHERE id = ?");
                $stmt->execute([$icon_url, $title, $list_item1, $list_item2, $list_item3, $id]);
                header("Location: index.php?page=home");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไอคอน');</script>";
            }
        }

        // จัดการการลบบริการ
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_service') {
            $id = $_GET['id'];

            // ดึงข้อมูลบริการเพื่อลบไอคอน
            $stmt = $this->pdo->prepare("SELECT icon_url FROM services WHERE id = ?");
            $stmt->execute([$id]);
            $service = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($service['icon_url'] && file_exists(__DIR__ . '/../../' . $service['icon_url'])) {
                unlink(__DIR__ . '/../../' . $service['icon_url']);
            }

            $stmt = $this->pdo->prepare("DELETE FROM services WHERE id = ?");
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