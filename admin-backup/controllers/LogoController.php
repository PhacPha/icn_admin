<?php
class LogoController
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;

        // ตรวจสอบและสร้างโฟลเดอร์ uploads หากยังไม่มี
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    }

    public function manage()
    {
        // ดึงข้อมูลโลโก้ทั้งหมด
        $stmt = $this->pdo->query("SELECT * FROM logos");
        $logos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $GLOBALS['logos'] = $logos;

        // จัดการการเพิ่มโลโก้
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_logo') {
            $alt_text = $_POST['alt_text'];
            $image_url = $this->handleImageUpload('image', $_POST['image_url']);

            if ($image_url) {
                $stmt = $this->pdo->prepare("INSERT INTO logos (image_url, alt_text) VALUES (?, ?)");
                $stmt->execute([$image_url, $alt_text]);
                header("Location: index.php?page=home");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
            }
        }

        // จัดการการแก้ไขโลโก้
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_logo') {
            $id = $_POST['id'];
            $alt_text = $_POST['alt_text'];
            $image_url = $this->handleImageUpload('image', $_POST['image_url']);

            // ดึงข้อมูลโลโก้เดิมเพื่อลบรูปภาพเก่า
            $stmt = $this->pdo->prepare("SELECT image_url FROM logos WHERE id = ?");
            $stmt->execute([$id]);
            $old_logo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($image_url) {
                // ลบรูปภาพเก่าถ้ามี
                if ($old_logo['image_url'] && file_exists(__DIR__ . '/../../' . $old_logo['image_url'])) {
                    unlink(__DIR__ . '/../../' . $old_logo['image_url']);
                }

                $stmt = $this->pdo->prepare("UPDATE logos SET image_url = ?, alt_text = ? WHERE id = ?");
                $stmt->execute([$image_url, $alt_text, $id]);
                header("Location: index.php?page=home");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
            }
        }

        // จัดการการลบโลโก้
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_logo') {
            $id = $_GET['id'];

            // ดึงข้อมูลโลโก้เพื่อลบรูปภาพ
            $stmt = $this->pdo->prepare("SELECT image_url FROM logos WHERE id = ?");
            $stmt->execute([$id]);
            $logo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($logo['image_url'] && file_exists(__DIR__ . '/../../' . $logo['image_url'])) {
                unlink(__DIR__ . '/../../' . $logo['image_url']);
            }

            $stmt = $this->pdo->prepare("DELETE FROM logos WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: index.php?page=home");
            exit;
        }
    }

    private function handleImageUpload($fileInputName, $urlInput)
    {
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
                return '/uploads/' . $fileName; // คืนค่า path ของไฟล์ที่อัปโหลด
            } else {
                return false;
            }
        }

        return false; // ถ้าไม่มีทั้ง URL และไฟล์
    }
}