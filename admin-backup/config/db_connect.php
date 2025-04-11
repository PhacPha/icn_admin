<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'iconnex_thailand_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // กำหนด timezone ให้กับเซิร์ฟเวอร์ PHP
    date_default_timezone_set('Asia/Bangkok');
    
    // กำหนด timezone ในฐานข้อมูล MySQL
    $pdo->exec("SET time_zone = '+07:00'");

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>