<?php

// ไม่ต้องเรียก session_start() ซ้ำ ถ้าเรียกจาก index.php แล้ว
require_once __DIR__ . '/../config/db_connect.php';

class DashboardController
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function index()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: login.php");
            exit();
        }

        // ดึงข้อมูลผู้ดูแลระบบ
        $stmt = $this->pdo->prepare("SELECT name FROM admins WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();
        $admin_name = $admin ? $admin['name'] : "Guest";

        // ดึงสรุปข้อมูล
        $total_admins = $this->pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
        $total_logos = $this->pdo->query("SELECT COUNT(*) FROM logos")->fetchColumn();
        $total_services = $this->pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
        $total_works = $this->pdo->query("SELECT COUNT(*) FROM works")->fetchColumn();
        $total_clicks = $this->pdo->query("SELECT SUM(click_count) FROM clicks")->fetchColumn() ?: 0;

        // ข้อมูลประเทศ
        $countryStmt = $this->pdo->query("SELECT country_name, COUNT(*) as total FROM ip_country GROUP BY country_name ORDER BY total DESC");
        $countries = $countryStmt->fetchAll(PDO::FETCH_ASSOC);
        $total_visits = array_sum(array_column($countries, 'total'));

        // ข้อมูลโพสต์ในโซเชียลมีเดีย
        $social_posts = [
            'Facebook' => 0,
            'Instagram' => 0,
            'YouTube' => 0,
            'Line' => 0
        ];

        $stmt = $this->pdo->query("SELECT platform, post_count FROM social_posts");
        while ($row = $stmt->fetch()) {
            $social_posts[$row['platform']] = $row['post_count'];
        }

        // ข้อมูลกราฟคลิก
        $days = 7;
        $click_data = [];
        $labels = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('d M', strtotime($date));
        }

        $clickStmt = $this->pdo->prepare("SELECT click_date, click_count FROM clicks WHERE click_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)");
        $clickStmt->execute([$days]);
        $clicks = $clickStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($labels as $index => $label) {
            $date = date('Y-m-d', strtotime("-$index days"));
            $found = false;
            foreach ($clicks as $click) {
                if ($click['click_date'] === $date) {
                    $click_data[] = (int)$click['click_count'];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $click_data[] = 0;
            }
        }

        // เรียก view dashboard.php
        include __DIR__ . '/../views/dashboard.php';
    }
}
