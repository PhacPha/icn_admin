<?php
session_start();
require_once '../config/db_connect.php';

class DashboardController {
    public function index() {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: login.php");
            exit();
        }

        // ดึงชื่อ Admin
        $stmt = $GLOBALS['pdo']->prepare("SELECT name FROM admins WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();
        $admin_name = $admin ? $admin['name'] : "Guest";

        // ดึงข้อมูลสรุป
        $total_admins = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM admins")->fetchColumn();
        $total_logos = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM logos")->fetchColumn();
        $total_services = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM services")->fetchColumn();
        $total_works = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM works")->fetchColumn();

        include '../views/dashboard.php';
    }
}
?>