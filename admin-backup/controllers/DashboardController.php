<?php
session_start();
require_once '../config/db_connect.php';

class DashboardController {
    public function index() {
        // ตรวจสอบ session admin_id ว่ามีการล็อกอินหรือไม่
        if (!isset($_SESSION['admin_id'])) {
            header("Location: login.php");
            exit();
        }

        // ดึงชื่อ Admin จากตาราง admins
        $stmt = $GLOBALS['pdo']->prepare("SELECT name FROM admins WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();
        $admin_name = $admin ? $admin['name'] : "Guest";

        // ดึงข้อมูลสรุปจากตารางต่างๆ
        $total_admins = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM admins")->fetchColumn();
        $total_logos = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM logos")->fetchColumn();
        $total_services = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM services")->fetchColumn();
        $total_works = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM works")->fetchColumn();

        // ดึงข้อมูล Analytics จากตาราง visitors
        // จำนวนการเข้าชมทั้งหมด
        $total_visits = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM visitors")->fetchColumn();
        // จำนวนผู้เข้าชมไม่ซ้ำ (Unique Visitors) โดยนับจาก IP ที่ไม่ซ้ำกัน
        $unique_visitors = $GLOBALS['pdo']->query("SELECT COUNT(DISTINCT ip) FROM visitors")->fetchColumn();

        // เก็บข้อมูลทั้งหมดในอาร์เรย์เพื่อส่งต่อไปยัง View
        $data = [
            'admin_name'      => $admin_name,
            'total_admins'    => $total_admins,
            'total_logos'     => $total_logos,
            'total_services'  => $total_services,
            'total_works'     => $total_works,
            'total_visits'    => $total_visits,
            'unique_visitors' => $unique_visitors,
        ];

        // ส่งข้อมูลไปยัง Dashboard View
        include '../views/dashboard.php';
    }
}
?>
