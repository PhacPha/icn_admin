<?php
require_once __DIR__ . '/../config.php'; // รวม config.php เพื่อใช้ IMAGE_UPLOAD_DIR และ PDO

class ServiceManagementController {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function manage() {
        // ดึงข้อมูลทั้งหมดจากตาราง service_cards
        $stmt = $this->pdo->query("SELECT * FROM service_cards");
        $GLOBALS['service_cards'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ดึงข้อมูลทั้งหมดจากตาราง why_choose_us
        $stmt = $this->pdo->query("SELECT * FROM why_choose_us");
        $GLOBALS['why_choose_us'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ดึงข้อมูลทั้งหมดจากตาราง work_process
        $stmt = $this->pdo->query("SELECT * FROM work_process");
        $GLOBALS['work_process'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // จัดการ Service Cards
        $this->handleServiceCards();

        // จัดการ Why Choose Us
        $this->handleWhyChooseUs();

        // จัดการ Work Process
        $this->handleWorkProcess();
    }

    private function handleServiceCards() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_service_card') {
            $icon_url = $this->handleImageUpload('icon', $_POST['icon_url']);
            $title = $_POST['title'];
            $description = $_POST['description'];
            $list_item1 = $_POST['list_item1'];
            $list_item2 = $_POST['list_item2'];
            $list_item3 = $_POST['list_item3'];
            $list_item4 = $_POST['list_item4'];

            if ($icon_url) {
                $stmt = $this->pdo->prepare("INSERT INTO service_cards (icon_url, title, description, list_item1, list_item2, list_item3, list_item4) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$icon_url, $title, $description, $list_item1, $list_item2, $list_item3, $list_item4]);
                header("Location: index.php?page=service_management");
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_service_card') {
            $id = $_POST['id'];
            $icon_url = $this->handleImageUpload('icon', $_POST['icon_url']);
            $title = $_POST['title'];
            $description = $_POST['description'];
            $list_item1 = $_POST['list_item1'];
            $list_item2 = $_POST['list_item2'];
            $list_item3 = $_POST['list_item3'];
            $list_item4 = $_POST['list_item4'];

            $stmt = $this->pdo->prepare("SELECT icon_url FROM service_cards WHERE id = ?");
            $stmt->execute([$id]);
            $old_card = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($icon_url) {
                if ($old_card['icon_url'] && file_exists(IMAGE_UPLOAD_DIR . basename($old_card['icon_url']))) {
                    unlink(IMAGE_UPLOAD_DIR . basename($old_card['icon_url']));
                }
                $stmt = $this->pdo->prepare("UPDATE service_cards SET icon_url = ?, title = ?, description = ?, list_item1 = ?, list_item2 = ?, list_item3 = ?, list_item4 = ? WHERE id = ?");
                $stmt->execute([$icon_url, $title, $description, $list_item1, $list_item2, $list_item3, $list_item4, $id]);
                header("Location: index.php?page=service_management");
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_service_card') {
            $id = $_GET['id'];
            $stmt = $this->pdo->prepare("SELECT icon_url FROM service_cards WHERE id = ?");
            $stmt->execute([$id]);
            $card = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($card['icon_url'] && file_exists(IMAGE_UPLOAD_DIR . basename($card['icon_url']))) {
                unlink(IMAGE_UPLOAD_DIR . basename($card['icon_url']));
            }
            $stmt = $this->pdo->prepare("DELETE FROM service_cards WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: index.php?page=service_management");
            exit;
        }
    }

    private function handleWhyChooseUs() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_why_choose_us') {
            $title = $_POST['title'];
            $description = $_POST['description'];

            $stmt = $this->pdo->prepare("INSERT INTO why_choose_us (title, description) VALUES (?, ?)");
            $stmt->execute([$title, $description]);
            header("Location: index.php?page=service_management");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_why_choose_us') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];

            $stmt = $this->pdo->prepare("UPDATE why_choose_us SET title = ?, description = ? WHERE id = ?");
            $stmt->execute([$title, $description, $id]);
            header("Location: index.php?page=service_management");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_why_choose_us') {
            $id = $_GET['id'];
            $stmt = $this->pdo->prepare("DELETE FROM why_choose_us WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: index.php?page=service_management");
            exit;
        }
    }

    private function handleWorkProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_work_process') {
            $step = $_POST['step'];
            $title = $_POST['title'];
            $description = $_POST['description'];

            $stmt = $this->pdo->prepare("INSERT INTO work_process (step, title, description) VALUES (?, ?, ?)");
            $stmt->execute([$step, $title, $description]);
            header("Location: index.php?page=service_management");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_work_process') {
            $id = $_POST['id'];
            $step = $_POST['step'];
            $title = $_POST['title'];
            $description = $_POST['description'];

            $stmt = $this->pdo->prepare("UPDATE work_process SET step = ?, title = ?, description = ? WHERE id = ?");
            $stmt->execute([$step, $title, $description, $id]);
            header("Location: index.php?page=service_management");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete_work_process') {
            $id = $_GET['id'];
            $stmt = $this->pdo->prepare("DELETE FROM work_process WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: index.php?page=service_management");
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