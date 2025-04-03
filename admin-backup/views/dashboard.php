<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<main class="ml-64 p-6 w-full min-h-screen bg-gray-100">
    <!-- ส่วนหัว Dashboard -->
    <div class="bg-gray-200 rounded p-4 mb-6 w-full">
        <h1 class="text-2xl font-bold">Dash Board</h1>
        <p class="text-gray-700 mt-1">
            ยินดีต้อนรับ, <span class="font-semibold"><?php echo htmlspecialchars($admin_name); ?></span>
        </p>
        <p class="text-sm text-gray-500">
            ข้อมูล ณ วันที่ <?php echo date('d/m/Y H:i:s'); ?>
        </p>
    </div>

    <!-- แถวแรก: การ์ดสถิติ 4 ใบ -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 w-full">
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold">จำนวน Admins</h3>
            <p class="text-2xl font-bold">
                <?php echo isset($total_admins) ? $total_admins : 0; ?>
            </p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold">จำนวน Logos</h3>
            <p class="text-2xl font-bold">
                <?php echo isset($total_logos) ? $total_logos : 0; ?>
            </p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold">จำนวน Services</h3>
            <p class="text-2xl font-bold">
                <?php echo isset($total_services) ? $total_services : 0; ?>
            </p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold">จำนวน Works</h3>
            <p class="text-2xl font-bold">
                <?php echo isset($total_works) ? $total_works : 0; ?>
            </p>
        </div>
    </div>

    <!-- แถวที่สอง: การ์ดสถิติ 2 ใบ -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 w-full">
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold">ข้อความติดต่อใหม่</h3>
            <p class="text-2xl font-bold">
                <?php echo isset($total_contact_messages) ? $total_contact_messages : 0; ?>
            </p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold">เซสชันของคุณ</h3>
            <p class="text-2xl font-bold">
                <?php echo isset($total_sessions) ? $total_sessions : 0; ?>
            </p>
        </div>
    </div>

    <!-- แถวที่สาม: พื้นที่กราฟ (2 ส่วนซ้าย) + การ์ดแอพ (1 ส่วนขวา) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 w-full">
        <!-- พื้นที่กราฟ (Placeholder) -->
        <div class="lg:col-span-2 bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold mb-2">Total Units by Month and Manufacturer</h3>
            <div class="border border-gray-200 rounded p-4 flex items-center justify-center">
                <img src="https://via.placeholder.com/600x300?text=Chart+Placeholder" alt="Chart Placeholder">
            </div>
        </div>

        <!-- การ์ดแสดงข้อมูลแอพ -->
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold mb-2">แอพพลิเคชั่น</h3>
            <table class="w-full mt-4">
                <tbody>
                    <tr>
                        <td class="py-2">Facebook</td>
                        <td class="py-2 text-right">10</td>
                    </tr>
                    <tr>
                        <td class="py-2">Instagram</td>
                        <td class="py-2 text-right">7</td>
                    </tr>
                    <tr>
                        <td class="py-2">Youtube</td>
                        <td class="py-2 text-right">5</td>
                    </tr>
                    <tr>
                        <td class="py-2">Line</td>
                        <td class="py-2 text-right">2</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'partials/footer.php'; ?>
