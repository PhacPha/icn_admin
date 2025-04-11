<?php
session_start();

// ตรวจสอบและรวมไฟล์ db_connect.php
if (!file_exists('../admin-backup/config/db_connect.php')) {
    die("Error: ไม่พบไฟล์ db_connect.php ในโฟลเดอร์");
}
require_once '../admin-backup/config/db_connect.php';

// ถ้ามี session admin อยู่แล้ว ให้ redirect ไปหน้า Dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php?page=dashboard");
    exit();
}

// ตัวแปรสำหรับเก็บข้อความ error และ success
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // ตรวจสอบว่ากรอกครบหรือไม่
    if (empty($name) || empty($email) || empty($password)) {
        $error = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "รูปแบบอีเมลไม่ถูกต้อง";
    } elseif (strlen($password) < 6) {
        $error = "รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร";
    } else {
        // ตรวจสอบว่า email นี้มีอยู่ในระบบแล้วหรือไม่
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $error = "อีเมลนี้มีอยู่ในระบบแล้ว";
        } else {
            // เข้ารหัสรหัสผ่าน
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // เพิ่ม admin ใหม่ลงในตาราง admins
            $stmt = $pdo->prepare("INSERT INTO admins (name, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $password_hash]);

            $success = "สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ";
            // Redirect ไปหน้า Login หลังจากสมัครสำเร็จ
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Iconnex Thailand Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/register-style.css">
</head>
<body>
    <div class="register-container">
        <h2>สมัครสมาชิก Admin</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">ชื่อ:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">อีเมล:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-register">สมัครสมาชิก</button>
        </form>
        <p>มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
    </div>

    <script src="assets/js/register-script.js"></script>
</body>
</html>