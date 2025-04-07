<?php
session_start();
require_once '../admin-backup/config/db_connect.php'; // ปรับ path การเชื่อมต่อฐานข้อมูล

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
<<<<<<< HEAD
$total_testimonials = $pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();
$total_contact_messages = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();

// ดึงจำนวนเซสชันของ admin ปัจจุบัน
$stmt = $pdo->prepare("SELECT COUNT(*) FROM sessions WHERE admin_id = ?");
$stmt->execute([$_SESSION['admin_id']]);
$total_sessions = $stmt->fetchColumn();
=======
$total_contact_messages = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();

// เพิ่มการดึงข้อมูล total_clicks
$total_clicks = $pdo->query("SELECT SUM(click_count) FROM clicks")->fetchColumn() ?: 0; // ถ้าไม่มีข้อมูลให้เป็น 0

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

// ดึงข้อมูลสำหรับกราฟ
$manufacturer_data = [
    'Aliqui' => array_fill(0, 12, 0),
    'Natura' => array_fill(0, 12, 0),
    'Pirum' => array_fill(0, 12, 0),
    'VanArsdel' => array_fill(0, 12, 0)
];
$months = ['Jan-14', 'Feb-14', 'Mar-14', 'Apr-14', 'May-14', 'Jun-14', 'Jul-14', 'Aug-14', 'Sep-14', 'Oct-14', 'Nov-14', 'Dec-14'];
while ($row = $stmt->fetch()) {
    $month_index = array_search($row['month'], $months);
    if ($month_index !== false) {
        $manufacturer_data[$row['manufacturer']][$month_index] = $row['units'];
    }
}
>>>>>>> origin/contact-page

// Routing ตามหน้า
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

switch ($page) {
    case 'dashboard':
        if (!file_exists('views/dashboard.php')) {
            die("Error: ไม่พบไฟล์ dashboard.php ในโฟลเดอร์ /iconnex_thailand_db/views/");
        }
        include 'views/dashboard.php';
        break;
    case 'home':
        if (!file_exists('controllers/LogoController.php') || 
            !file_exists('controllers/HomeServiceController.php') || 
            !file_exists('controllers/WorkController.php') || 
            !file_exists('controllers/TestimonialController.php')) {
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
            die("Error: ไม่พบไฟล์ content_management.php ในโฟลเดอร์ /iconnex_thailand_db/views/");
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
<<<<<<< HEAD
?>








require_once '../admin-backup/config/db_connect.php';
=======
?>
>>>>>>> origin/contact-page
