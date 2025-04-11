<?php
session_start();

// รวมไฟล์ db_connect.php
require_once __DIR__ . '/config/db_connect.php';

// ถ้ามี session admin อยู่แล้ว ให้ redirect ไปหน้า Dashboard
if (isset($_SESSION['admin_id'])) {
    $stmt = $pdo->prepare("SELECT session_token FROM sessions WHERE admin_id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $session = $stmt->fetch();
    if ($session && isset($_SESSION['session_token']) && $session['session_token'] === $_SESSION['session_token']) {
        header("Location: index.php?page=dashboard");
        exit();
    } else {
        session_unset();
        session_destroy();
    }
}

// สร้าง CSRF Token ถ้ายังไม่มี
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ตัวแปรสำหรับเก็บข้อความ error และข้อมูลฟอร์ม
$error = '';
$modal_error = '';
$modal_success = '';
$email = '';
$password = '';
$forgot_name = '';
$forgot_email = '';
$show_reset_form = false;
$new_password = '';
$confirm_password = '';

// ตรวจสอบการล็อกอิน
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['forgot_password']) && !isset($_POST['reset_password'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "การตรวจสอบความปลอดภัยล้มเหลว!";
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {
            $error = "กรุณากรอกอีเมลและรหัสผ่าน";
        } else {
            $stmt = $pdo->prepare("SELECT id, name, password_hash FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password_hash'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $session_token = bin2hex(random_bytes(16));
                $stmt = $pdo->prepare("INSERT INTO sessions (admin_id, session_token, created_at) VALUES (?, ?, NOW())");
                $stmt->execute([$admin['id'], $session_token]);
                $_SESSION['session_token'] = $session_token;
                header("Location: index.php?page=dashboard");
                exit();
            } else {
                $error = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
                $password = '';
            }
        }
    }
}

// ตรวจสอบชื่อและอีเมลสำหรับลืมรหัสผ่าน
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot_password'])) {
    $forgot_name = filter_input(INPUT_POST, 'forgot_name', FILTER_SANITIZE_STRING);
    $forgot_email = filter_input(INPUT_POST, 'forgot_email', FILTER_SANITIZE_EMAIL);

    if (empty($forgot_name) || empty($forgot_email)) {
        $modal_error = "กรุณากรอกชื่อและอีเมล!";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM admins WHERE name = ? AND email = ?");
        $stmt->execute([$forgot_name, $forgot_email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $show_reset_form = true;
            $_SESSION['reset_admin_id'] = $admin['id'];
        } else {
            $modal_error = "ชื่อหรืออีเมลไม่ถูกต้อง!";
        }
    }
}

// อัปเดตรหัสผ่านใหม่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $forgot_name = filter_input(INPUT_POST, 'forgot_name', FILTER_SANITIZE_STRING);
    $forgot_email = filter_input(INPUT_POST, 'forgot_email', FILTER_SANITIZE_EMAIL);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($new_password) || empty($confirm_password)) {
        $modal_error = "กรุณากรอกรหัสผ่านทั้งสองช่อง!";
        $show_reset_form = true;
    } elseif ($new_password !== $confirm_password) {
        $modal_error = "รหัสผ่านไม่ตรงกัน!";
        $show_reset_form = true;
    } else {
        $admin_id = $_SESSION['reset_admin_id'] ?? null;
        if ($admin_id) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
            $stmt->execute([$new_password_hash, $admin_id]);
            $modal_success = "รีเซ็ตรหัสผ่านสำเร็จ! กรุณาใช้รหัสผ่านใหม่ในการเข้าสู่ระบบ";
            unset($_SESSION['reset_admin_id']);
        } else {
            $modal_error = "เกิดข้อผิดพลาด กรุณาลองใหม่!";
            $show_reset_form = true;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="login-container">
        <h2>เข้าสู่ระบบ Admin</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form-group">
                <label for="email">อีเมล:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group password-container">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required>
                <i class="fa-regular fa-eye toggle-password" onclick="togglePassword()"></i>
            </div>
            <button type="submit" class="btn btn-login">เข้าสู่ระบบ</button>
        </form>
        <p><a href="#" onclick="showModal()">ลืมรหัสผ่าน?</a>
        </p>
    </div>

    <!-- Modal สำหรับลืมรหัสผ่าน -->
    <div id="forgotModal" class="modal" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['forgot_password']) || isset($_POST['reset_password'])))
        echo 'style="display: flex;"'; ?>>
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>ลืมรหัสผ่าน</h2>
            <?php if ($modal_error)
                echo "<p class='error'>$modal_error</p>"; ?>
            <?php if ($modal_success)
                echo "<p class='success'>$modal_success</p>"; ?>

            <?php if ($show_reset_form && !$modal_success): ?>
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="reset_password" value="1">
                    <input type="hidden" name="forgot_name" value="<?php echo htmlspecialchars($forgot_name); ?>">
                    <input type="hidden" name="forgot_email" value="<?php echo htmlspecialchars($forgot_email); ?>">
                    <div class="form-group password-container">
                        <label for="new_password">รหัสผ่านใหม่:</label>
                        <input type="password" id="new_password" name="new_password" required>
                        <i class="fa-regular fa-eye toggle-password" onclick="toggleNewPassword()"></i>
                    </div>
                    <div class="form-group password-container">
                        <label for="confirm_password">ยืนยันรหัสผ่าน:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <i class="fa-regular fa-eye toggle-password" onclick="toggleConfirmPassword()"></i>
                    </div>
                    <button type="submit" class="btn btn-login">บันทึก</button>
                    <?php elseif (!$modal_success): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="forgot_password" value="1">
                            <div class="form-group">
                                <label for="forgot_name">ชื่อ:</label>
                                <input type="text" id="forgot_name" name="forgot_name"
                                    value="<?php echo htmlspecialchars($forgot_name); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="forgot_email">อีเมล:</label>
                                <input type="email" id="forgot_email" name="forgot_email"
                                    value="<?php echo htmlspecialchars($forgot_email); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-login">ส่ง</button>
                        </form>
                    <?php endif; ?>
                </form>
        </div>
    </div>

    <!-- HTML คงเดิม ไม่ต้องเปลี่ยนแปลง -->
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 25px;
            width: 100%;
            max-width: 400px;
            /* text-align: center; */
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .close {
            float: right;
            top: -1rem;
            right: 0;
            position: absolute;
            font-size: 50px;
            cursor: pointer;
            color: #666;
            width: 40px;
            transition: all 0.3s ease;
        }

        .close:hover {
            color: #e63946;
        }

        .error {
            color: #e63946;
        }

        .success {
            color: #00cc00;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
    </style>

    <script>
        // แสดง Modal
        function showModal() {
            const modal = document.getElementById('forgotModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('active'); // เพิ่ม class active เพื่อเริ่ม animation
            }, 10); // หน่วงเวลาเล็กน้อยเพื่อให้ transition ทำงาน
        }

        // ซ่อน Modal
        function hideModal() {
            const modal = document.getElementById('forgotModal');
            modal.classList.remove('active'); // ลบ class active
            setTimeout(() => {
                modal.style.display = 'none'; // ซ่อนหลังจาก transition เสร็จ
            }, 300); // รอให้ transition เสร็จ (0.3 วินาที)
        }

        // เพิ่ม Event Listener สำหรับปุ่มปิด
        document.querySelector('.modal .close').addEventListener('click', hideModal);

        // สลับการแสดงรหัสผ่าน
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = passwordInput.nextElementSibling;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // สลับการแสดงรหัสผ่านใหม่
        function toggleNewPassword() {
            const newPasswordInput = document.getElementById('new_password');
            const toggleIcon = newPasswordInput.nextElementSibling;
            if (newPasswordInput.type === 'password') {
                newPasswordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                newPasswordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // สลับการแสดงรหัสผ่านยืนยัน
        function toggleConfirmPassword() {
            const confirmPasswordInput = document.getElementById('confirm_password');
            const toggleIcon = confirmPasswordInput.nextElementSibling;
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // เรียก showModal หาก modal ควรแสดง (เช่น หลัง POST)
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['forgot_password']) || isset($_POST['reset_password']))): ?>
            showModal();
        <?php endif; ?>
    </script>
</body>

</html>