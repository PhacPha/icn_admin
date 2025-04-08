<?php
session_start();
require_once '../admin-backup/config/db_connect.php'; // ปรับ path การเชื่อมต่อฐานข้อมูลตามโปรเจกต์ของคุณ

// ตรวจสอบว่าเป็น admin หรือไม่
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// ดึงข้อมูล admin ที่ล็อกอิน
$stmt = $pdo->prepare("SELECT name FROM admins WHERE id = ?");
$stmt->execute([$_SESSION['admin_id']]);
$admin = $stmt->fetch();
$admin_name = $admin ? $admin['name'] : "Guest";

// ดึงข้อมูลสรุปสำหรับ Dashboard
$total_admins = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
$total_logos = $pdo->query("SELECT COUNT(*) FROM logos")->fetchColumn();
$total_services = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$total_works = $pdo->query("SELECT COUNT(*) FROM works")->fetchColumn();
$total_contact_messages = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
$total_clicks = $pdo->query("SELECT SUM(click_count) FROM clicks")->fetchColumn() ?: 0;

// ดึงข้อมูลโพสต์ในโซเชียลมีเดีย
$social_posts = [
    'Facebook' => 0,
    'Instagram' => 0,
    'YouTube' => 0,
    'Line' => 0
];
$stmt = $pdo->query("SELECT platform, post_count FROM social_posts");
while ($row = $stmt->fetch()) {
    $social_posts[$row['platform']] = $row['post_count'];
}

// ดึงข้อมูลสำหรับกราฟคลิก (7 วันล่าสุด)
$days = 7;
$click_data = [];
$labels = [];

// สร้าง label สำหรับวันที่ย้อนหลัง 7 วัน (เช่น "07 Apr")
for ($i = $days - 1; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('d M', strtotime($date));
}

$stmt = $pdo->prepare("SELECT click_date, click_count FROM clicks WHERE click_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)");
$stmt->execute([$days]);
$clicks = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($labels as $index => $label) {
    $date = date('Y-m-d', strtotime("-$index days"));
    $found = false;
    foreach ($clicks as $click) {
        if ($click['click_date'] === $date) {
            $click_data[] = (int) $click['click_count'];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $click_data[] = 0;
    }
}

// *** ดึงข้อมูลสถิติอุปกรณ์ (Devices Used) ***
// สมมุติว่ามีตาราง device_logs ที่มีฟิลด์ 'device'
$stmt = $pdo->query("SELECT device, COUNT(*) as total FROM device_logs GROUP BY device");
// หาก PHP ของคุณรองรับ PDO::FETCH_KEY_PAIR (PHP 7.4 ขึ้นไป)
// คุณสามารถใช้แบบนี้:
$device_stats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// ถ้าไม่รองรับ ให้ใช้วิธีแบบ loop ดังนี้:
/*
$device_stats = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $device_stats[$row['device']] = $row['total'];
}
*/

// Routing ตามหน้า (controller และ view ต่าง ๆ)
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

switch ($page) {
    case 'dashboard':
        if (!file_exists('views/dashboard.php')) {
            die("Error: ไม่พบไฟล์ dashboard.php ในโฟลเดอร์ /iconnex_thailand_db/views/");
        }
        include 'views/dashboard.php';
        break;
    case 'home':
        if (
            !file_exists('controllers/LogoController.php') ||
            !file_exists('controllers/HomeServiceController.php') ||
            !file_exists('controllers/WorkController.php') ||
            !file_exists('controllers/TestimonialController.php')
        ) {
            die("Error: ไม่พบไฟล์ Controller ในโฟลเดอร์ /iconnex_thailand_db/controllers/");
        }
        include 'controllers/LogoController.php';
        include 'controllers/HomeServiceController.php';
        include 'controllers/WorkController.php';
        include 'controllers/TestimonialController.php';

        $logoController = new LogoController();
        $serviceController = new HomeServiceController();
        $workController = new WorkController();
        $testimonialController = new TestimonialController();

        $logoController->manage();
        $serviceController->manage();
        $workController->manage();
        $testimonialController->manage();

        if (!file_exists('views/home.php')) {
            die("Error: ไม่พบไฟล์ home.php ในโฟลเดอร์ /iconnex_thailand_db/views/");
        }
        include 'views/home.php';
        break;
    case 'service_management':
        if (!file_exists('controllers/ServiceManagementController.php')) {
            die("Error: ไม่พบไฟล์ ServiceManagementController.php ในโฟลเดอร์ /iconnex_thailand_db/controllers/");
        }
        include 'controllers/ServiceManagementController.php';
        $serviceManagementController = new ServiceManagementController();
        $serviceManagementController->manage();

        if (!file_exists('views/service_management.php')) {
            die("Error: ไม่พบไฟล์ service_management.php ในโฟลเดอร์ /iconnex_thailand_db/views/");
        }
        include 'views/service_management.php';
        break;
    case 'content_management':
        if (!file_exists('controllers/ContentManagementController.php')) {
            die("Error: ไม่พบไฟล์ ContentManagementController.php ในโฟลเดอร์ /iconnex_thailand_db/controllers/");
        }
        include 'controllers/ContentManagementController.php';
        $contentManagementController = new ContentManagementController();
        $contentManagementController->manage();

        if (!file_exists('views/content_management.php')) {
            die("Error: ไม่พบไฟล์ content_management.php ในโฟลded /iconnex_thailand_db/views/");
        }
        include 'views/content_management.php';
        break;
    case 'contact_messages':
        if (!file_exists('controllers/ContactMessagesController.php')) {
            die("Error: ไม่พบไฟล์ ContactMessagesController.php ในโฟลเดอร์ /iconnex_thailand_db/controllers/");
        }
        include 'controllers/ContactMessagesController.php';
        $contactMessagesController = new ContactMessagesController();
        $contactMessagesController->manage();

        if (!file_exists('views/contact_messages.php')) {
            die("Error: ไม่พบไฟล์ contact_messages.php ในโฟลเดอร์ /iconnex_thailand_db/views/");
        }
        include 'views/contact_messages.php';
        break;
    case 'reply_message':
        if (!file_exists('views/reply_message.php')) {
            die("Error: ไม่พบไฟล์ reply_message.php ในโฟลเดอร์ /iconnex_thailand_db/views/");
        }
        include 'views/reply_message.php';
        break;
    default:
        echo "404 - Page Not Found";
        break;
}
?>
