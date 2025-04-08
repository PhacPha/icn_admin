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

$stmt = $GLOBALS['pdo']->prepare("
    SELECT click_date, click_count 
    FROM clicks 
    WHERE click_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
");
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
    if (! $found) {
        $click_data[] = 0;
    }
}
?>

<main class="main-content w-full px-6 py-6">
  <h1 class="text-2xl font-bold mb-6">Dash Board</h1>

  <!-- Stats Section: 4 small cards at top -->
  <div class="stats grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8 w-full">
    <div class="bg-white p-4 rounded-lg shadow w-full">
      <h3 class="text-lg font-semibold">จำนวน Admins</h3>
      <p class="text-2xl font-bold">
        <?= number_format($total_admins) ?>
        <span class="text-green-500 text-sm">+11.01% ↗</span>
      </p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow w-full">
      <h3 class="text-lg font-semibold">จำนวน Logos</h3>
      <p class="text-2xl font-bold">
        <?= number_format($total_logos) ?>
        <span class="text-green-500 text-sm">+11.01% ↗</span>
      </p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow w-full">
      <h3 class="text-lg font-semibold">CTR รวม</h3>
      <p class="text-2xl font-bold">
        <?= number_format($total_clicks) ?>
        <span class="text-green-500 text-sm">+11.01% ↗</span>
      </p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow w-full">
      <h3 class="text-lg font-semibold">จำนวน Works</h3>
      <p class="text-2xl font-bold">
        <?= number_format($total_works) ?>
        <span class="text-green-500 text-sm">+11.01% ↗</span>
      </p>
    </div>
  </div>

  <!-- Two-column layout below stats -->
  <div class="flex flex-col lg:flex-row gap-6 w-full">

    <!-- Left column: Social + Chart -->
    <div class="flex-1 space-y-6 w-full">
      <!-- Social Media Posts Section -->
      <div class="bg-white p-4 rounded-lg shadow overflow-x-auto w-full">
        <h3 class="text-lg font-semibold mb-4">จำนวนโพสต์ในโซเชียล</h3>
        <table class="min-w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-2 px-3">แพลตฟอร์ม</th>
              <th class="py-2 px-3">จำนวนโพสต์</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (['Facebook','Instagram','YouTube','Line'] as $pf): ?>
            <tr class="hover:bg-gray-50">
              <td class="py-2 px-3 flex items-center">
                <i class="fab fa-<?= strtolower($pf) ?> mr-2"></i><?= $pf ?>
              </td>
              <td class="py-2 px-3"><?= $social_posts[$pf] ?? 0 ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Clicks Chart Section -->
      <div class="bg-white p-4 rounded-lg shadow w-full">
        <h3 class="text-lg font-semibold mb-4">จำนวนคลิกต่อวัน (7 วันล่าสุด)</h3>
        <div class="w-full h-64">
          <canvas id="clicksChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Right column: Countries, Devices, Online Users -->
    <div class="w-full lg:w-1/3 flex flex-col gap-6">
      <!-- Countries Visiting Section -->
      <div class="bg-white p-4 rounded-lg shadow overflow-x-auto w-full">
        <h3 class="text-lg font-semibold mb-4">ประเทศที่เข้าชม</h3>
        <table class="min-w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-2 px-3">ประเทศ</th>
              <th class="py-2 px-3">จำนวนการเข้าชม</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="py-2 px-3">ยังไม่มีข้อมูล</td>
              <td class="py-2 px-3">0</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Devices Used Section -->
      <div class="bg-white p-4 rounded-lg shadow overflow-x-auto w-full">
        <h3 class="text-lg font-semibold mb-4">อุปกรณ์ที่เข้าชม</h3>
        <table class="min-w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-2 px-3">ประเภทอุปกรณ์</th>
              <th class="py-2 px-3">จำนวนการใช้งาน</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($device_stats)): ?>
              <?php foreach ($device_stats as $dev => $cnt): ?>
              <tr class="hover:bg-gray-50">
                <td class="py-2 px-3"><?= htmlspecialchars($dev) ?></td>
                <td class="py-2 px-3"><?= number_format($cnt) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td class="py-2 px-3">ยังไม่มีข้อมูล</td>
                <td class="py-2 px-3">0</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Current Online Users Section -->
      <div class="bg-white p-4 rounded-lg shadow text-center w-full">
        <h3 class="text-lg font-semibold mb-3">จำนวน User ที่ออนไลน์อยู่ในตอนนี้</h3>
        <p class="text-2xl font-bold">0 <span class="text-gray-500 text-sm">ผู้ใช้</span></p>
      </div>
    </div>

  </div>
</main>

<?php include 'partials/footer.php'; ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('clicksChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= json_encode($labels) ?>,
      datasets: [{
        label: 'จำนวนคลิก',
        data: <?= json_encode($click_data) ?>,
        borderColor: 'rgba(74,144,226,1)',
        backgroundColor: 'rgba(74,144,226,0.2)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#fff',
        pointBorderColor: 'rgba(74,144,226,1)',
        pointBorderWidth: 2,
        pointRadius: 4
      }]
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      scales: {
        y: { beginAtZero: true, title: { display: true, text: 'จำนวนคลิก' } },
        x: { title: { display: true, text: 'วันที่' } }
      },
      plugins: {
        legend: { display: true, position: 'top' },
        tooltip: {
          callbacks: {
            label: ctx => `${ctx.dataset.label}: ${ctx.raw} คลิก`
          }
        }
      }
    }
  });
</script>
 