<?php
class TestimonialController {
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
        // ดึงข้อมูลคอมเมนต์ทั้งหมด
        $stmt = $this->pdo->query("SELECT * FROM testimonials");
        $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $GLOBALS['testimonials'] = $testimonials;

        // จัดการการเพิ่มคอมเมนต์
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_testimonial') {
            $quote = $_POST['quote'];
            $text = $_POST['text'];
            $author_name = $_POST['author_name'];
            $author_location = $_POST['author_location'];
            $avatar_url = $this->handleImageUpload('avatar', $_POST['avatar_url']);

            if ($avatar_url) {
                $stmt = $this->pdo->prepare("INSERT INTO testimonials (quote, text, author_name, author_location, avatar_url) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$quote, $text, $author_name, $author_location, $avatar_url]);
                $GLOBALS['testimonial_message'] = "เพิ่มคอมเมนต์สำเร็จ!";
                header("Location: index.php?page=home");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
            }
        }

        // จัดการการแก้ไขคอมเมนต์
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_testimonial') {
            $id = $_POST['id'];
            $quote = $_POST['quote'];
            $text = $_POST['text'];
            $author_name = $_POST['author_name'];
            $author_location = $_POST['author_location'];
            $avatar_url = $this->handleImageUpload('avatar', $_POST['avatar_url']);

            // ดึงข้อมูลคอมเมนต์เดิมเพื่อลบรูปภาพเก่า
            $stmt = $this->pdo->prepare("SELECT avatar_url FROM testimonials WHERE id = ?");
            $stmt->execute([$id]);
            $old_testimonial = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($avatar_url) {
                // ลบรูปภาพเก่าถ้ามี
                if ($old_testimonial['avatar_url'] && file_exists(__DIR__ . '/../../' . $old_testimonial['avatar_url'])) {
                    unlink(__DIR__ . '/../../' . $old_testimonial['avatar_url']);
                }

                $stmt = $this->pdo->prepare("UPDATE testimonials SET quote = ?, text = ?, author_name = ?, author_location = ?, avatar_url = ? WHERE id = ?");
                $stmt->execute([$quote, $text, $author_name, $author_location, $avatar_url, $id]);
                $GLOBALS['testimonial_message'] = "แก้ไขคอมเมนต์สำเร็จ!";
                header("Location: index.php?page=home");
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
            }
        }

        // จัดการการลบคอมเมนต์
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_testimonial') {
            $id = $_GET['id'];

            // ดึงข้อมูลคอมเมนต์เพื่อลบรูปภาพ
            $stmt = $this->pdo->prepare("SELECT avatar_url FROM testimonials WHERE id = ?");
            $stmt->execute([$id]);
            $testimonial = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($testimonial['avatar_url'] && file_exists(__DIR__ . '/../../' . $testimonial['avatar_url'])) {
                unlink(__DIR__ . '/../../' . $testimonial['avatar_url']);
            }

            $stmt = $this->pdo->prepare("DELETE FROM testimonials WHERE id = ?");
            $stmt->execute([$id]);
            $GLOBALS['testimonial_message'] = "ลบคอมเมนต์สำเร็จ!";
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