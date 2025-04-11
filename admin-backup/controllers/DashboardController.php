<?php


// โหลดไฟล์เชื่อมต่อฐานข้อมูล
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
        // ตรวจสอบว่ามี admin_id ใน session หรือไม่
        if (!isset($_SESSION['admin_id'])) {
            header("Location: login.php");
            exit();
        }

        // ดึงชื่อ Admin จากตาราง admins ตาม session admin_id
        $stmt = $GLOBALS['pdo']->prepare("SELECT name FROM admins WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();
        $admin_name = $admin ? $admin['name'] : "Guest";

        // ดึงข้อมูลสรุปจากตารางต่าง ๆ
        $total_admins = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM admins")->fetchColumn();
        $total_logos = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM logos")->fetchColumn();
        $total_services = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM services")->fetchColumn();
        $total_works = $GLOBALS['pdo']->query("SELECT COUNT(*) FROM works")->fetchColumn();
        $total_clicks = $GLOBALS['pdo']->query("SELECT SUM(click_count) FROM clicks")->fetchColumn() ?: 0;

        // เตรียมข้อมูลสำหรับกราฟคลิก (7 วันล่าสุด)
        $days = 7;
        $click_data = [];
        $labels = [];

        // ดึงข้อมูลคลิกในช่วง 7 วันที่ผ่านมา
        $stmt = $GLOBALS['pdo']->prepare("SELECT click_date, click_count FROM clicks WHERE click_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)");
        $stmt->execute([$days]);
        $clicks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // สร้าง labels และ click_data
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('d M', strtotime($date));
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

        // ข้อมูลประเทศ
        $countryStmt = $GLOBALS['pdo']->query("SELECT country_name, COUNT(*) as total FROM ip_country GROUP BY country_name ORDER BY total DESC");
        $countries = $countryStmt->fetchAll(PDO::FETCH_ASSOC);
        $total_visits = array_sum(array_column($countries, 'total'));

        // ดึงข้อมูลสถิติอุปกรณ์จากตาราง device_logs (สมมุติว่ามีฟิลด์ 'device')
        // ผลลัพธ์จะได้เป็น array แบบ key => value (เช่น 'Desktop' => 120)
        $stmt = $GLOBALS['pdo']->query("SELECT device, COUNT(*) as total FROM device_logs GROUP BY device");
        $device_stats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $device_stats[$row['device']] = $row['total'];
        }

        // ส่งตัวแปรทั้งหมดไปยัง View
        include __DIR__ . '/../views/dashboard.php';

    }
}
?>