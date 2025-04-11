<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start(); }
// โหลดไฟล์เชื่อมต่อฐานข้อมูล
require_once __DIR__ . '/../icn_admin/admin-backup/config/db_connect.php';

// เรียกใช้ record_ip เงียบๆ
define('SILENT_MODE', true);
require_once '../icn_admin/admin-backup/controllers/record_ip.php';
// header.php (User-side header)

// เริ่ม session ถ้าจำเป็น (ถ้าไม่ได้เริ่มไว้ที่อื่น)
// session_start();



// ----------------------
// BEGIN: Device Logging
// รับค่า User Agent และ IP Address
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ip_address = $_SERVER['REMOTE_ADDR'];

// ตรวจจับ iPadOS 13+ ที่ส่ง UA เป็น Mac แต่จริงๆ คือ iPad
$is_ipados = stripos($user_agent, 'Macintosh') !== false
           && stripos($user_agent, 'Safari')   !== false
           && stripos($user_agent, 'Version/') !== false
           && stripos($user_agent, 'Mobile')   === false;

// ตรวจจับประเภทอุปกรณ์
if (
    stripos($user_agent, 'tablet') !== false ||
    stripos($user_agent, 'ipad') !== false ||
    stripos($user_agent, 'playbook') !== false ||
    stripos($user_agent, 'silk') !== false ||
    $is_ipados 
) {
    $device = 'Tablet';
} elseif (
    stripos($user_agent, 'mobile') !== false ||
    stripos($user_agent, 'iphone') !== false ||
    stripos($user_agent, 'android') !== false ||
    stripos($user_agent, 'blackberry') !== false ||
    stripos($user_agent, 'iemobile') !== false ||
    stripos($user_agent, 'kindle') !== false
) {
    $device = 'Mobile';
} else {
    $device = 'Desktop';
}

// บันทึกลงฐานข้อมูล
try {
    $stmt = $pdo->prepare(
        "INSERT INTO device_logs (device, user_agent, ip_address) VALUES (?, ?, ?)"
    );
    $stmt->execute([$device, $user_agent, $ip_address]);
    error_log("Device log inserted: $device, $ip_address");
} catch (PDOException $e) {
    error_log("Error inserting device log: " . $e->getMessage());
}
// END: Device Logging
// ----------------------

// --- BEGIN: Update Online Status ---
// ใช้ session_id() เป็น key แทน user_id เพื่อจับแต่ละ session
// $sessionId = session_id();
$pdo->prepare("
  INSERT INTO user_activity (user_id, last_activity)
  VALUES (:uid, NOW())
  ON DUPLICATE KEY UPDATE last_activity = NOW()
")->execute([':uid' => session_id()]);
?>



<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="img/2.png" alt="Logo" class="logo" onclick="window.location.href='index'" style="border-radius: 5rem;">
            <nav>
                <div class="burger-menu" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul class="nav-list">
                    <li><a href="index">หน้าแรก</a></li>
                    <li><a href="about">เกี่ยวกับเรา</a></li>
                    <li><a href="service">บริการ</a></li>
                    <li><a href="content">ผลงาน</a></li>
                    <li><a href="contact">ติดต่อเรา</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <script src="header.js"></script>
    <script>
    // ฟังก์ชันลบสถานะออนไลน์
    function removeOnline() {
      navigator.sendBeacon('/iconnex_thailand_db/count_online.php');
    }
    // เมื่อปิดหรือสลับแท็บ ให้ยิง Beacon
    window.addEventListener('pagehide', removeOnline);
    document.addEventListener('visibilitychange', function() {
      if (document.visibilityState === 'hidden') {
        removeOnline();
      }
    });
  </script>



</body>
</html>