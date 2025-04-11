<?php
session_start();
require_once __DIR__ . '/../icn_admin/admin-backup/config/db_connect.php';

// 1) ถ้าเป็น POST ให้ลบ session นี้ทันที (จาก sendBeacon / fetch keepalive)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sessionId = session_id();
    $pdo->prepare("DELETE FROM user_activity WHERE user_id = ?")
        ->execute([$sessionId]);
    http_response_code(204);
    exit;
}

// 2) ลบ record เก่าๆ ที่ last_activity เกิน 5 นาที (cleanup stale sessions)
$pdo->exec("
    DELETE FROM user_activity
    WHERE last_activity < (NOW() - INTERVAL 5 MINUTE)
");

// 3) นับจำนวน record ที่เหลือ (คือ online users)
header('Content-Type: application/json');
$row = $pdo->query("
    SELECT COUNT(*) AS cnt
    FROM user_activity
")->fetch(PDO::FETCH_ASSOC);

echo json_encode(['count' => (int)$row['cnt']]);
