<?php
session_start();
// require_once '../admin-backup/config/db_connect.php';
require_once '../config/db_connect.php'; 

class DashboardController
{
    public function index()
    {
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
        $total_clicks = $GLOBALS['pdo']->query("SELECT SUM(click_count) FROM clicks")->fetchColumn() ?: 0; // เพิ่มการดึง total_clicks

        // ในไฟล์หลักหรือ DashboardController ก่อน include 'views/dashboard.php'
        $days = 7; // จำนวนวันที่ต้องการแสดงในกราฟ (ปรับได้ตามต้องการ)
        $click_data = [];
        $labels = [];

        // กำหนดวันที่ย้อนหลัง 7 วัน
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('d M', strtotime($date)); // เช่น "07 Apr"
        }

        // ดึงข้อมูลจากตาราง clicks
        $stmt = $pdo->prepare("SELECT click_date, click_count FROM clicks WHERE click_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)");
        $stmt->execute([$days]);
        $clicks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // เติมข้อมูลลงใน array ถ้าไม่มีวันนั้นให้เป็น 0
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
                $click_data[] = 0; // วันไหนไม่มีข้อมูลให้ใส่ 0
            }
        }
        include '../views/dashboard.php';
    }
}
?>