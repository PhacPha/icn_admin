<?php
require_once 'config/db_connect.php';

header('Content-Type: application/json');

$stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);
exit;