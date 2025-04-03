<?php
session_start();

// ตรวจสอบและรวมไฟล์ db_connect.php
if (file_exists('../admin-backup/config/db_connect.php')) {
    echo "พบไฟล์ db_connect.php";
} else {
    echo "ไม่พบไฟล์ db_connect.php";
}
require_once '../admin-backup/config/db_connect.php';
// require_once '../../config/db_connect.php';

// ถ้ามี session admin อยู่แล้ว ให้ redirect ไปหน้า Dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php?page=dashboard");
    exit();
}

// ตัวแปรสำหรับเก็บข้อความ error
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // ตรวจสอบว่ากรอกครบหรือไม่
    if (empty($email) || empty($password)) {
        $error = "กรุณากรอกอีเมลและรหัสผ่าน";
    } else {
        // ดึงข้อมูล admin จากตาราง admins
        $stmt = $pdo->prepare("SELECT id, name, password_hash FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        // ตรวจสอบว่ามี admin นี้หรือไม่ และรหัสผ่านถูกต้องหรือไม่
        if ($admin && password_verify($password, $admin['password_hash'])) {
            // ล็อกอินสำเร็จ ตั้งค่า session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];

            // เพิ่มข้อมูลในตาราง sessions
            $session_token = bin2hex(random_bytes(16)); // สร้าง token สำหรับเซสชัน
            $stmt = $pdo->prepare("INSERT INTO sessions (admin_id, session_token, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$admin['id'], $session_token]);

            // Redirect ไปหน้า Dashboard
            header("Location: index.php?page=dashboard");
            exit();
        } else {
            $error = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Iconnex Thailand Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login-style.css">
</head>
<body>
    <div class="login-container">
        <h2>เข้าสู่ระบบ Admin</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">อีเมล:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-login">เข้าสู่ระบบ</button>
        </form>
        <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
    </div>
    <script src="assets/js/login-script.js"></script>
</body>
</html>