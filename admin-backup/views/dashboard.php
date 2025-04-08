<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<?php
// ดึงข้อมูลสำหรับกราฟคลิก
$days = 7;
$click_data = [];
$labels = [];

for ($i = $days - 1; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('d M', strtotime($date));
}

$stmt = $GLOBALS['pdo']->prepare("SELECT click_date, click_count FROM clicks WHERE click_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)");
$stmt->execute([$days]);
$clicks = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($labels as $index => $label) {
    $date = date('Y-m-d', strtotime("-$index days"));
    $found = false;
    foreach ($clicks as $click) {
        if ($click['click_date'] === $date) {
            $click_data[] = (int)$click['click_count'];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $click_data[] = 0;
    }
}
?>

<main class="main-content p-6">
    <h1 class="text-2xl font-bold mb-4">Dash Board</h1>

    <!-- Stats Section -->
    <div class="stats grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- จำนวน Admins -->
        <div class="stat-card bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">จำนวน Admins</h3>
            <p class="text-2xl font-bold"><?php echo number_format($total_admins); ?> <span class="text-green-500 text-sm">+11.01% ↗</span></p>
        </div>
        <!-- จำนวน Logos -->
        <div class="stat-card bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">จำนวน Logos</h3>
            <p class="text-2xl font-bold"><?php echo number_format($total_logos); ?> <span class="text-green-500 text-sm">+11.01% ↗</span></p>
        </div>
        <!-- CTR รวม -->
        <div class="stat-card bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">CTR รวม</h3>
            <p class="text-2xl font-bold"><?php echo number_format($total_clicks); ?> <span class="text-green-500 text-sm">+11.01% ↗</span></p>
        </div>
        <!-- จำนวน Works -->
        <div class="stat-card bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">จำนวน Works</h3>
            <p class="text-2xl font-bold"><?php echo number_format($total_works); ?> <span class="text-green-500 text-sm">+11.01% ↗</span></p>
        </div>
    </div>

    <!-- Social Media Posts Section -->
    <div class="social-stats bg-white p-4 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">จำนวนโพสต์ในโซเชียล</h3>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="p-2">แพลตฟอร์ม</th>
                    <th class="p-2">จำนวนโพสต์</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-2 flex items-center"><i class="fab fa-facebook-f mr-2"></i> Facebook</td>
                    <td class="p-2"><?php echo $social_posts['Facebook']; ?></td>
                </tr>
                <tr>
                    <td class="p-2 flex items-center"><i class="fab fa-instagram mr-2"></i> Instagram</td>
                    <td class="p-2"><?php echo $social_posts['Instagram']; ?></td>
                </tr>
                <tr>
                    <td class="p-2 flex items-center"><i class="fab fa-youtube mr-2"></i> YouTube</td>
                    <td class="p-2"><?php echo $social_posts['YouTube']; ?></td>
                </tr>
                <tr>
                    <td class="p-2 flex items-center"><i class="fab fa-line mr-2"></i> Line</td>
                    <td class="p-2"><?php echo $social_posts['Line']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Chart Section -->
    <div class="chart bg-white p-4 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">จำนวนคลิกต่อวัน (7 วันล่าสุด)</h3>
        <canvas id="clicksChart" height="100"></canvas>
    </div>

    
    <!-- Countries Visiting Section -->
<div class="countries-stats bg-white p-4 rounded-lg shadow mb-6">
    <h3 class="text-lg font-semibold mb-4">ประเทศที่เข้าชม</h3>
    <table class="w-full text-left">
        <thead>
            <tr>
                <th class="p-2">ประเทศ</th>
                <th class="p-2">จำนวนการเข้าชม</th>
                <th class="p-2">เปอร์เซ็นต์</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($countries)): ?>
                <?php foreach ($countries as $row): ?>
                    <tr>
                        <td class="p-2"><?= htmlspecialchars($row['country_name']) ?></td>
                        <td class="p-2"><?= number_format($row['total']) ?></td>
                        <td class="p-2"><?= round(($row['total'] / $total_visits) * 100, 2) ?>%</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="p-2">ยังไม่มีข้อมูล</td>
                    <td class="p-2">0</td>
                    <td class="p-2">0%</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


    <!-- Devices Used Section -->
    <div class="devices-stats bg-white p-4 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">อุปกรณ์ที่เข้าชม</h3>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="p-2">ประเภทอุปกรณ์</th>
                    <th class="p-2">จำนวนการใช้งาน</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-2">ยังไม่มีข้อมูล</td>
                    <td class="p-2">0</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Current Online Users Section -->
    <div class="online-users bg-white p-4 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">จำนวน User ที่ออนไลน์อยู่ในตอนนี้</h3>
        <p class="text-2xl font-bold">0 <span class="text-gray-500 text-sm">ผู้ใช้</span></p>
    </div>

</main>

<!-- Include Chart.js for the graph -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('clicksChart').getContext('2d');
    const clicksChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'จำนวนคลิก',
                data: <?php echo json_encode($click_data); ?>,
                borderColor: '#4A90E2',
                backgroundColor: 'rgba(74, 144, 226, 0.2)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4A90E2',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'จำนวนคลิก'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'วันที่'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw} คลิก`;
                        }
                    }
                }
            }
        }
    });
</script>

<!-- เพิ่มส่วนนี้ใน dashboard.php เพื่อ debug -->
<script>
    console.log('Labels:', <?php echo json_encode($labels); ?>);
    console.log('Click Data:', <?php echo json_encode($click_data); ?>);
</script>

<?php include 'partials/footer.php'; ?>