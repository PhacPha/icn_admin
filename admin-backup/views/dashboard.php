<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<main class="main-content">
    <h1>ยินดีต้อนรับสู่ Admin Dashboard, <?php echo htmlspecialchars($admin_name); ?></h1>
    <p>นี่คือภาพรวมของระบบ Iconnex Thailand (ข้อมูล ณ วันที่ <?php echo date('d/m/Y H:i:s'); ?>)</p>

    <div class="stats">
        <div class="stat-card">
            <h3>จำนวน Admins</h3>
            <p><?php echo isset($total_admins) ? $total_admins : 0; ?></p>
        </div>
        <div class="stat-card">
            <h3>จำนวน Logos</h3>
            <p><?php echo isset($total_logos) ? $total_logos : 0; ?></p>
        </div>
        <div class="stat-card">
            <h3>จำนวน Services</h3>
            <p><?php echo isset($total_services) ? $total_services : 0; ?></p>
        </div>
        <div class="stat-card">
            <h3>จำนวน Works</h3>
            <p><?php echo isset($total_works) ? $total_works : 0; ?></p>
        </div>
        <div class="stat-card">
            <h3>ข้อความติดต่อใหม่</h3>
            <p><?php echo isset($total_contact_messages) ? $total_contact_messages : 0; ?></p>
        </div>
        <div class="stat-card">
            <h3>เซสชันของคุณ</h3>
            <p><?php echo isset($total_sessions) ? $total_sessions : 0; ?></p>
        </div>
    </div>
</main>

<?php include 'partials/footer.php'; ?>