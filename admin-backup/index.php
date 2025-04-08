<?php
session_start();
require_once 'config/db_connect.php';

// รับค่าหน้าจาก query string เช่น ?page=dashboard
$page = $_GET['page'] ?? 'dashboard';

switch ($page) {
    case 'dashboard':
        require_once 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    case 'home':
        require_once 'controllers/LogoController.php';
        require_once 'controllers/HomeServiceController.php';
        require_once 'controllers/WorkController.php';
        require_once 'controllers/TestimonialController.php';

        $logoController = new LogoController();
        $serviceController = new HomeServiceController();
        $workController = new WorkController();
        $testimonialController = new TestimonialController();

        $logoController->manage();
        $serviceController->manage();
        $workController->manage();
        $testimonialController->manage();

        if (!file_exists('views/home.php')) {
            die("Error: ไม่พบไฟล์ views/home.php");
        }
        include 'views/home.php';
        break;

    case 'service_management':
        require_once 'controllers/ServiceManagementController.php';
        $serviceManagementController = new ServiceManagementController();
        $serviceManagementController->manage();
        include 'views/service_management.php';
        break;

    case 'content_management':
        require_once 'controllers/ContentManagementController.php';
        $contentManagementController = new ContentManagementController();
        $contentManagementController->manage();
        include 'views/content_management.php';
        break;

    case 'contact_messages':
        require_once 'controllers/ContactMessagesController.php';
        $contactMessagesController = new ContactMessagesController();
        $contactMessagesController->manage();
        include 'views/contact_messages.php';
        break;

    case 'reply_message':
        include 'views/reply_message.php';
        break;

    case 'logout':
        session_destroy();
        header("Location: login.php");
        break;

    default:
        echo "404 - Page Not Found";
        break;
}
