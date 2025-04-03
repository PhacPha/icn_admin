<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<main class="ml-64 p-6 w-full min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 animate__animated animate__fadeIn">จัดการหน้า Content</h1>

    <!-- Blocks -->
    <div class="card bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg mb-6 animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">จัดการ Blocks</h2>
            <button onclick="showAddBlockModal()" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200">เพิ่ม Block</button>
        </div>
        <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mt-6 mb-3">รายการ Blocks</h3>
        <?php if (empty($GLOBALS['blocks'])): ?>
            <p class="text-gray-600 dark:text-gray-400">ยังไม่มี Blocks ในระบบ</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-3">ID</th>
                            <th class="p-3">รูปภาพ</th>
                            <th class="p-3">ชื่อ</th>
                            <th class="p-3">รายละเอียด 1-3</th>
                            <th class="p-3">คำอธิบาย</th>
                            <th class="p-3">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GLOBALS['blocks'] as $block): ?>
                            <tr class="bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                <td class="p-3"><?php echo htmlspecialchars($block['id']); ?></td>
                                <td class="p-3">
                                    <img src="<?php echo htmlspecialchars($block['image_url']); ?>" alt="<?php echo htmlspecialchars($block['title']); ?>" class="max-w-[50px] rounded-lg" data-placeholder="/iconnex_thailand_db/img/placeholder.png">
                                </td>
                                <td class="p-3"><?php echo htmlspecialchars($block['title']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($block['detail1'] . ', ' . $block['detail2'] . ', ' . $block['detail3']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($block['description']); ?></td>
                                <td class="p-3 flex gap-2">
                                    <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200" onclick="showEditBlockModal(<?php echo $block['id']; ?>, '<?php echo htmlspecialchars($block['image_url']); ?>', '<?php echo htmlspecialchars($block['title']); ?>', '<?php echo htmlspecialchars($block['detail1']); ?>', '<?php echo htmlspecialchars($block['detail2']); ?>', '<?php echo htmlspecialchars($block['detail3']); ?>', '<?php echo htmlspecialchars($block['description']); ?>')">แก้ไข</button>
                                    <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="showDeleteBlockModal(<?php echo $block['id']; ?>)">ลบ</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal สำหรับเพิ่ม Block -->
    <div id="add-block-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">เพิ่ม Block ใหม่</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_block">
                <div class="form-group mb-4">
                    <label for="add-block-image" class="block text-gray-700 dark:text-gray-300 mb-1">รูปภาพ (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="add-block-image" name="image" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="add-block-image_url" name="image_url" placeholder="วาง URL รูปภาพ" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="add-block-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อ:</label>
                    <input type="text" id="add-block-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-block-detail1" class="block text-gray-700 dark:text-gray-300 mb-1">รายละเอียด 1:</label>
                    <input type="text" id="add-block-detail1" name="detail1" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-block-detail2" class="block text-gray-700 dark:text-gray-300 mb-1">รายละเอียด 2:</label>
                    <input type="text" id="add-block-detail2" name="detail2" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-block-detail3" class="block text-gray-700 dark:text-gray-300 mb-1">รายละเอียด 3:</label>
                    <input type="text" id="add-block-detail3" name="detail3" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-block-description" class="block text-gray-700 dark:text-gray-300 mb-1">คำอธิบาย:</label>
                    <textarea id="add-block-description" name="description" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">เพิ่ม</button>
                    <button type="button" onclick="hideAddBlockModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับแก้ไข Block -->
    <div id="edit-block-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">แก้ไข Block</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_block">
                <input type="hidden" name="id" id="edit-block-id">
                <div class="form-group mb-4">
                    <label for="edit-block-image" class="block text-gray-700 dark:text-gray-300 mb-1">รูปภาพ (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="edit-block-image" name="image" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="edit-block-image_url" name="image_url" placeholder="วาง URL รูปภาพ" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-block-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อ:</label>
                    <input type="text" id="edit-block-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-block-detail1" class="block text-gray-700 dark:text-gray-300 mb-1">รายละเอียด 1:</label>
                    <input type="text" id="edit-block-detail1" name="detail1" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-block-detail2" class="block text-gray-700 dark:text-gray-300 mb-1">รายละเอียด 2:</label>
                    <input type="text" id="edit-block-detail2" name="detail2" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-block-detail3" class="block text-gray-700 dark:text-gray-300 mb-1">รายละเอียด 3:</label>
                    <input type="text" id="edit-block-detail3" name="detail3" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-block-description" class="block text-gray-700 dark:text-gray-300 mb-1">คำอธิบาย:</label>
                    <textarea id="edit-block-description" name="description" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">บันทึก</button>
                    <button type="button" onclick="hideEditBlockModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับลบ Block -->
    <div id="delete-block-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">ยืนยันการลบ Block</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">คุณแน่ใจหรือไม่ว่าต้องการลบ Block นี้?</p>
            <form method="GET" action="">
                <input type="hidden" name="page" value="content_management">
                <input type="hidden" name="action" value="delete_block">
                <input type="hidden" name="id" id="delete-block-id">
                <div class="flex gap-2">
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ลบ</button>
                    <button type="button" onclick="hideDeleteBlockModal()" class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
// Block Modals
function showAddBlockModal() {
    document.getElementById('add-block-modal').classList.remove('hidden');
}
function hideAddBlockModal() {
    document.getElementById('add-block-modal').classList.add('hidden');
}
function showEditBlockModal(id, image_url, title, detail1, detail2, detail3, description) {
    document.getElementById('edit-block-id').value = id;
    document.getElementById('edit-block-image_url').value = image_url;
    document.getElementById('edit-block-title').value = title;
    document.getElementById('edit-block-detail1').value = detail1;
    document.getElementById('edit-block-detail2').value = detail2;
    document.getElementById('edit-block-detail3').value = detail3;
    document.getElementById('edit-block-description').value = description;
    document.getElementById('edit-block-modal').classList.remove('hidden');
}
function hideEditBlockModal() {
    document.getElementById('edit-block-modal').classList.add('hidden');
}
function showDeleteBlockModal(id) {
    document.getElementById('delete-block-id').value = id;
    document.getElementById('delete-block-modal').classList.remove('hidden');
}
function hideDeleteBlockModal() {
    document.getElementById('delete-block-modal').classList.add('hidden');
}
</script>

<?php include 'partials/footer.php'; ?>