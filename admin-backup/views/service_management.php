<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<main class="ml-64 p-6 w-full min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 animate__animated animate__fadeIn">จัดการหน้า Services</h1>

    <!-- Service Cards -->
    <div class="card bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg mb-6 animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">จัดการ Service Cards</h2>
            <button onclick="showAddServiceCardModal()" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200">เพิ่ม Service Card</button>
        </div>
        <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mt-6 mb-3">รายการ Service Cards</h3>
        <?php if (empty($GLOBALS['service_cards'])): ?>
            <p class="text-gray-600 dark:text-gray-400">ยังไม่มี Service Cards ในระบบ</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-3">ID</th>
                            <th class="p-3">ไอคอน</th>
                            <th class="p-3">ชื่อ</th>
                            <th class="p-3">คำอธิบาย</th>
                            <th class="p-3">รายการ 1-4</th>
                            <th class="p-3">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GLOBALS['service_cards'] as $card): ?>
                            <tr class="bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                <td class="p-3"><?php echo htmlspecialchars($card['id']); ?></td>
                                <td class="p-3">
                                    <img src="<?php echo htmlspecialchars($card['icon_url']); ?>" alt="<?php echo htmlspecialchars($card['title']); ?>" class="max-w-[50px] rounded-lg" data-placeholder="/iconnex_thailand_db/img/placeholder.png">
                                </td>
                                <td class="p-3"><?php echo htmlspecialchars($card['title']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($card['description']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($card['list_item1'] . ', ' . $card['list_item2'] . ', ' . $card['list_item3'] . ', ' . $card['list_item4']); ?></td>
                                <td class="p-3 flex gap-2">
                                    <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200" onclick="showEditServiceCardModal(<?php echo $card['id']; ?>, '<?php echo htmlspecialchars($card['icon_url']); ?>', '<?php echo htmlspecialchars($card['title']); ?>', '<?php echo htmlspecialchars($card['description']); ?>', '<?php echo htmlspecialchars($card['list_item1']); ?>', '<?php echo htmlspecialchars($card['list_item2']); ?>', '<?php echo htmlspecialchars($card['list_item3']); ?>', '<?php echo htmlspecialchars($card['list_item4']); ?>')">แก้ไข</button>
                                    <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="showDeleteServiceCardModal(<?php echo $card['id']; ?>)">ลบ</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Why Choose Us -->
    <div class="card bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg mb-6 animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">จัดการ Why Choose Us</h2>
            <button onclick="showAddWhyChooseUsModal()" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200">เพิ่ม Why Choose Us</button>
        </div>
        <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mt-6 mb-3">รายการ Why Choose Us</h3>
        <?php if (empty($GLOBALS['why_choose_us'])): ?>
            <p class="text-gray-600 dark:text-gray-400">ยังไม่มี Why Choose Us ในระบบ</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-3">ID</th>
                            <th class="p-3">ชื่อ</th>
                            <th class="p-3">คำอธิบาย</th>
                            <th class="p-3">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GLOBALS['why_choose_us'] as $item): ?>
                            <tr class="bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                <td class="p-3"><?php echo htmlspecialchars($item['id']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($item['title']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($item['description']); ?></td>
                                <td class="p-3 flex gap-2">
                                    <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200" onclick="showEditWhyChooseUsModal(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['title']); ?>', '<?php echo htmlspecialchars($item['description']); ?>')">แก้ไข</button>
                                    <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="showDeleteWhyChooseUsModal(<?php echo $item['id']; ?>)">ลบ</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Work Process -->
    <div class="card bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg mb-6 animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">จัดการ Work Process</h2>
            <button onclick="showAddWorkProcessModal()" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200">เพิ่ม Work Process</button>
        </div>
        <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mt-6 mb-3">รายการ Work Process</h3>
        <?php if (empty($GLOBALS['work_process'])): ?>
            <p class="text-gray-600 dark:text-gray-400">ยังไม่มี Work Process ในระบบ</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-3">ID</th>
                            <th class="p-3">ขั้นตอน</th>
                            <th class="p-3">ชื่อ</th>
                            <th class="p-3">คำอธิบาย</th>
                            <th class="p-3">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GLOBALS['work_process'] as $process): ?>
                            <tr class="bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                <td class="p-3"><?php echo htmlspecialchars($process['id']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($process['step']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($process['title']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($process['description']); ?></td>
                                <td class="p-3 flex gap-2">
                                    <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200" onclick="showEditWorkProcessModal(<?php echo $process['id']; ?>, '<?php echo htmlspecialchars($process['step']); ?>', '<?php echo htmlspecialchars($process['title']); ?>', '<?php echo htmlspecialchars($process['description']); ?>')">แก้ไข</button>
                                    <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="showDeleteWorkProcessModal(<?php echo $process['id']; ?>)">ลบ</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal สำหรับเพิ่ม Service Card -->
    <div id="add-service-card-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">เพิ่ม Service Card ใหม่</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_service_card">
                <div class="form-group mb-4">
                    <label for="add-service-card-icon" class="block text-gray-700 dark:text-gray-300 mb-1">ไอคอน (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="add-service-card-icon" name="icon" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="add-service-card-icon_url" name="icon_url" placeholder="วาง URL ไอคอน" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-card-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อ:</label>
                    <input type="text" id="add-service-card-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-card-description" class="block text-gray-700 dark:text-gray-300 mb-1">คำอธิบาย:</label>
                    <textarea id="add-service-card-description" name="description" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-card-list_item1" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 1:</label>
                    <input type="text" id="add-service-card-list_item1" name="list_item1" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-card-list_item2" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 2:</label>
                    <input type="text" id="add-service-card-list_item2" name="list_item2" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-card-list_item3" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 3:</label>
                    <input type="text" id="add-service-card-list_item3" name="list_item3" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-card-list_item4" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 4:</label>
                    <input type="text" id="add-service-card-list_item4" name="list_item4" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">เพิ่ม</button>
                    <button type="button" onclick="hideAddServiceCardModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับแก้ไข Service Card -->
    <div id="edit-service-card-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">แก้ไข Service Card</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_service_card">
                <input type="hidden" name="id" id="edit-service-card-id">
                <div class="form-group mb-4">
                    <label for="edit-service-card-icon" class="block text-gray-700 dark:text-gray-300 mb-1">ไอคอน (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="edit-service-card-icon" name="icon" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="edit-service-card-icon_url" name="icon_url" placeholder="วาง URL ไอคอน" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-card-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อ:</label>
                    <input type="text" id="edit-service-card-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-card-description" class="block text-gray-700 dark:text-gray-300 mb-1">คำอธิบาย:</label>
                    <textarea id="edit-service-card-description" name="description" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-card-list_item1" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 1:</label>
                    <input type="text" id="edit-service-card-list_item1" name="list_item1" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-card-list_item2" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 2:</label>
                    <input type="text" id="edit-service-card-list_item2" name="list_item2" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-card-list_item3" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 3:</label>
                    <input type="text" id="edit-service-card-list_item3" name="list_item3" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-card-list_item4" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 4:</label>
                    <input type="text" id="edit-service-card-list_item4" name="list_item4" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">บันทึก</button>
                    <button type="button" onclick="hideEditServiceCardModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับลบ Service Card -->
    <div id="delete-service-card-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">ยืนยันการลบ Service Card</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">คุณแน่ใจหรือไม่ว่าต้องการลบ Service Card นี้?</p>
            <form method="GET" action="">
                <input type="hidden" name="page" value="service_management">
                <input type="hidden" name="action" value="delete_service_card">
                <input type="hidden" name="id" id="delete-service-card-id">
                <div class="flex gap-2">
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ลบ</button>
                    <button type="button" onclick="hideDeleteServiceCardModal()" class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับเพิ่ม Why Choose Us -->
    <div id="add-why-choose-us-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">เพิ่ม Why Choose Us ใหม่</h3>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_why_choose_us">
                <div class="form-group mb-4">
                    <label for="add-why-choose-us-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อ:</label>
                    <input type="text" id="add-why-choose-us-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-why-choose-us-description" class="block text-gray-700 dark:text-gray-300 mb-1">คำอธิบาย:</label>
                    <textarea id="add-why-choose-us-description" name="description" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">เพิ่ม</button>
                    <button type="button" onclick="hideAddWhyChooseUsModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับแก้ไข Why Choose Us -->
    <div id="edit-why-choose-us-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">แก้ไข Why Choose Us</h3>
            <form method="POST" action="">
                <input type="hidden" name="action" value="edit_why_choose_us">
                <input type="hidden" name="id" id="edit-why-choose-us-id">
                <div class="form-group mb-4">
                    <label for="edit-why-choose-us-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อ:</label>
                    <input type="text" id="edit-why-choose-us-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-why-choose-us-description" class="block text-gray-700 dark:text-gray-300 mb-1">คำอธิบาย:</label>
                    <textarea id="edit-why-choose-us-description" name="description" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">บันทึก</button>
                    <button type="button" onclick="hideEditWhyChooseUsModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับลบ Why Choose Us -->
    <div id="delete-why-choose-us-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">ยืนยันการลบ Why Choose Us</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">คุณแน่ใจหรือไม่ว่าต้องการลบ Why Choose Us นี้?</p>
            <form method="GET" action="">
                <input type="hidden" name="page" value="service_management">
                <input type="hidden" name="action" value="delete_why_choose_us">
                <input type="hidden" name="id" id="delete-why-choose-us-id">
                <div class="flex gap-2">
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ลบ</button>
                    <button type="button" onclick="hideDeleteWhyChooseUsModal()" class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับเพิ่ม Work Process -->
    <div id="add-work-process-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">เพิ่ม Work Process ใหม่</h3>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_work_process">
                <div class="form-group mb-4">
                    <label for="add-work-process-step" class="block text-gray-700 dark:text-gray-300 mb-1">ขั้นตอน:</label>
                    <input type="text" id="add-work-process-step" name="step" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-work-process-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อ:</label>
                    <input type="text" id="add-work-process-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-work-process-description" class="block text-gray-700 dark:text-gray-300 mb-1">คำอธิบาย:</label>
                    <textarea id="add-work-process-description" name="description" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">เพิ่ม</button>
                    <button type="button" onclick="hideAddWorkProcessModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับแก้ไข Work Process -->
    <div id="edit-work-process-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">แก้ไข Work Process</h3>
            <form method="POST" action="">
                <input type="hidden" name="action" value="edit_work_process">
                <input type="hidden" name="id" id="edit-work-process-id">
                <div class="form-group mb-4">
                    <label for="edit-work-process-step" class="block text-gray-700 dark:text-gray-300 mb-1">ขั้นตอน:</label>
                    <input type="text" id="edit-work-process-step" name="step" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-work-process-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อ:</label>
                    <input type="text" id="edit-work-process-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-work-process-description" class="block text-gray-700 dark:text-gray-300 mb-1">คำอธิบาย:</label>
                    <textarea id="edit-work-process-description" name="description" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">บันทึก</button>
                    <button type="button" onclick="hideEditWorkProcessModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับลบ Work Process -->
    <div id="delete-work-process-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">ยืนยันการลบ Work Process</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">คุณแน่ใจหรือไม่ว่าต้องการลบ Work Process นี้?</p>
            <form method="GET" action="">
                <input type="hidden" name="page" value="service_management">
                <input type="hidden" name="action" value="delete_work_process">
                <input type="hidden" name="id" id="delete-work-process-id">
                <div class="flex gap-2">
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ลบ</button>
                    <button type="button" onclick="hideDeleteWorkProcessModal()" class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
// Service Card Modals
function showAddServiceCardModal() {
    document.getElementById('add-service-card-modal').classList.remove('hidden');
}
function hideAddServiceCardModal() {
    document.getElementById('add-service-card-modal').classList.add('hidden');
}
function showEditServiceCardModal(id, icon_url, title, description, list_item1, list_item2, list_item3, list_item4) {
    document.getElementById('edit-service-card-id').value = id;
    document.getElementById('edit-service-card-icon_url').value = icon_url;
    document.getElementById('edit-service-card-title').value = title;
    document.getElementById('edit-service-card-description').value = description;
    document.getElementById('edit-service-card-list_item1').value = list_item1;
    document.getElementById('edit-service-card-list_item2').value = list_item2;
    document.getElementById('edit-service-card-list_item3').value = list_item3;
    document.getElementById('edit-service-card-list_item4').value = list_item4;
    document.getElementById('edit-service-card-modal').classList.remove('hidden');
}
function hideEditServiceCardModal() {
    document.getElementById('edit-service-card-modal').classList.add('hidden');
}
function showDeleteServiceCardModal(id) {
    document.getElementById('delete-service-card-id').value = id;
    document.getElementById('delete-service-card-modal').classList.remove('hidden');
}
function hideDeleteServiceCardModal() {
    document.getElementById('delete-service-card-modal').classList.add('hidden');
}

// Why Choose Us Modals
function showAddWhyChooseUsModal() {
    document.getElementById('add-why-choose-us-modal').classList.remove('hidden');
}
function hideAddWhyChooseUsModal() {
    document.getElementById('add-why-choose-us-modal').classList.add('hidden');
}
function showEditWhyChooseUsModal(id, title, description) {
    document.getElementById('edit-why-choose-us-id').value = id;
    document.getElementById('edit-why-choose-us-title').value = title;
    document.getElementById('edit-why-choose-us-description').value = description;
    document.getElementById('edit-why-choose-us-modal').classList.remove('hidden');
}
function hideEditWhyChooseUsModal() {
    document.getElementById('edit-why-choose-us-modal').classList.add('hidden');
}
function showDeleteWhyChooseUsModal(id) {
    document.getElementById('delete-why-choose-us-id').value = id;
    document.getElementById('delete-why-choose-us-modal').classList.remove('hidden');
}
function hideDeleteWhyChooseUsModal() {
    document.getElementById('delete-why-choose-us-modal').classList.add('hidden');
}

// Work Process Modals
function showAddWorkProcessModal() {
    document.getElementById('add-work-process-modal').classList.remove('hidden');
}
function hideAddWorkProcessModal() {
    document.getElementById('add-work-process-modal').classList.add('hidden');
}
function showEditWorkProcessModal(id, step, title, description) {
    document.getElementById('edit-work-process-id').value = id;
    document.getElementById('edit-work-process-step').value = step;
    document.getElementById('edit-work-process-title').value = title;
    document.getElementById('edit-work-process-description').value = description;
    document.getElementById('edit-work-process-modal').classList.remove('hidden');
}
function hideEditWorkProcessModal() {
    document.getElementById('edit-work-process-modal').classList.add('hidden');
}
function showDeleteWorkProcessModal(id) {
    document.getElementById('delete-work-process-id').value = id;
    document.getElementById('delete-work-process-modal').classList.remove('hidden');
}
function hideDeleteWorkProcessModal() {
    document.getElementById('delete-work-process-modal').classList.add('hidden');
}
</script>

<?php include 'partials/footer.php'; ?>