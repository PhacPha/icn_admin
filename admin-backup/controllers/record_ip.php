<?php
if (!defined('SILENT_MODE')) {
    header('Content-Type: application/json');
}

require_once __DIR__ . '/../config/db_connect.php';

function getCountryNameFromCode($code) {
    $url = "https://restcountries.com/v3.1/alpha/" . urlencode($code);
    $response = @file_get_contents($url);
    if (!$response) return $code;
    $data = json_decode($response, true);
    return $data[0]['name']['common'] ?? $code;
}

$ip = $_SERVER['REMOTE_ADDR'];
if ($ip === '::1' || $ip === '127.0.0.1' || strpos($ip, '192.168.') === 0) {
    $ip = '8.8.8.8';
}

$token = '0d3ee196d70d22';

try {
    $checkStmt = $pdo->prepare("SELECT id FROM ip_country WHERE ip_address = ? AND DATE(created_at) = CURDATE()");
    $checkStmt->execute([$ip]);

    if ($checkStmt->rowCount() === 0) {
        $url = "https://ipinfo.io/{$ip}/json?token={$token}";
        $response = @file_get_contents($url);
        $data = json_decode($response, true);

        $country_code = $data['country'] ?? 'XX';
        $country_name = getCountryNameFromCode($country_code);

        $insertStmt = $pdo->prepare("INSERT INTO ip_country (ip_address, country_code, country_name) VALUES (?, ?, ?)");
        $insertStmt->execute([$ip, $country_code, $country_name]);
    } else {
        $latest = $pdo->prepare("SELECT country_code, country_name FROM ip_country WHERE ip_address = ? ORDER BY created_at DESC LIMIT 1");
        $latest->execute([$ip]);
        $row = $latest->fetch();
        $country_code = $row['country_code'] ?? 'XX';
        $country_name = $row['country_name'] ?? 'Unknown';
    }

    if (!defined('SILENT_MODE')) {
        echo json_encode([
            'status' => 'success',
            'ip' => $ip,
            'country_code' => $country_code,
            'country_name' => $country_name,
        ]);
    }
} catch (Exception $e) {
    if (!defined('SILENT_MODE')) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
