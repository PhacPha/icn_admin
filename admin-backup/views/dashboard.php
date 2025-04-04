<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

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
    <div class="chart bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Total Units by Month and Manufacturer</h3>
        <canvas id="unitsChart" height="100"></canvas>
    </div>
</main>

<!-- Include Chart.js for the graph -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('unitsChart').getContext('2d');
    const unitsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan-14', 'Feb-14', 'Mar-14', 'Apr-14', 'May-14', 'Jun-14', 'Jul-14', 'Aug-14', 'Sep-14', 'Oct-14', 'Nov-14', 'Dec-14'],
            datasets: [
                {
                    label: 'Aliqui',
                    data: <?php echo json_encode($manufacturer_data['Aliqui']); ?>,
                    borderColor: '#00C4B4',
                    fill: false
                },
                {
                    label: 'Natura',
                    data: <?php echo json_encode($manufacturer_data['Natura']); ?>,
                    borderColor: '#FF6B6B',
                    fill: false
                },
                {
                    label: 'Pirum',
                    data: <?php echo json_encode($manufacturer_data['Pirum']); ?>,
                    borderColor: '#4A90E2',
                    fill: false
                },
                {
                    label: 'VanArsdel',
                    data: <?php echo json_encode($manufacturer_data['VanArsdel']); ?>,
                    borderColor: '#FFD700',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 2000
                }
            }
        }
    });
</script>

<?php include 'partials/footer.php'; ?>