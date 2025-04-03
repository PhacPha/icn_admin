<?php
session_start();

// ลบ session ทั้งหมด
session_unset();
session_destroy();

// Redirect ไปหน้า Login
header("Location: login.php");
exit();
?>