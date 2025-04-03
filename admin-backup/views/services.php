<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<main class="main-content">
    <h1>จัดการบริการ</h1>

    <!-- แสดงข้อความแจ้งเตือน -->
    <?php if (isset($message) && $message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- ฟอร์มเพิ่มบริการใหม่ -->
    <h2>เพิ่มบริการใหม่</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">
        <div class="form-group">
            <label for="icon_url">URL ไอคอน:</label>
            <input type="url" id="icon_url" name="icon_url" required>
        </div>
        <div class="form-group">
            <label for="title">ชื่อบริการ:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="list_item1">รายการที่ 1:</label>
            <input type="text" id="list_item1" name="list_item1" required>
        </div>
        <div class="form-group">
            <label for="list_item2">รายการที่ 2:</label>
            <input type="text" id="list_item2" name="list_item2" required>
        </div>
        <div class="form-group">
            <label for="list_item3">รายการที่ 3:</label>
            <input type="text" id="list_item3" name="list_item3" required>
        </div>
        <button type="submit" class="btn btn-add">เพิ่มบริการ</button>
    </form>

    <!-- ตารางแสดงบริการ -->
    <h2>รายการบริการ</h2>
    <?php if (empty($services)): ?>
        <p>ยังไม่มีบริการในระบบ</p>
    <?php else: ?>
        <table class="service-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ไอคอน</th>
                    <th>ชื่อบริการ</th>
                    <th>รายการที่ 1</th>
                    <th>รายการที่ 2</th>
                    <th>รายการที่ 3</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service['id']); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($service['icon_url']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" style="max-width: 50px;">
                        </td>
                        <td><?php echo htmlspecialchars($service['title']); ?></td>
                        <td><?php echo htmlspecialchars($service['list_item1']); ?></td>
                        <td><?php echo htmlspecialchars($service['list_item2']); ?></td>
                        <td><?php echo htmlspecialchars($service['list_item3']); ?></td>
                        <td>
                            <!-- ปุ่มแก้ไข (เปิดฟอร์มแก้ไข) -->
                            <button class="btn btn-edit" onclick="showEditForm(<?php echo $service['id']; ?>, '<?php echo htmlspecialchars($service['icon_url']); ?>', '<?php echo htmlspecialchars($service['title']); ?>', '<?php echo htmlspecialchars($service['list_item1']); ?>', '<?php echo htmlspecialchars($service['list_item2']); ?>', '<?php echo htmlspecialchars($service['list_item3']); ?>')">แก้ไข</button>
                            <!-- ปุ่มลบ -->
                            <a href="index.php?page=services&action=delete&id=<?php echo $service['id']; ?>" class="btn btn-delete" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบบริการนี้?')">ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- ฟอร์มแก้ไขบริการ (ซ่อนไว้ก่อน) -->
    <div id="edit-form" style="display: none;">
        <h2>แก้ไขบริการ</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group">
                <label for="edit-icon_url">URL ไอคอน:</label>
                <input type="url" id="edit-icon_url" name="icon_url" required>
            </div>
            <div class="form-group">
                <label for="edit-title">ชื่อบริการ:</label>
                <input type="text" id="edit-title" name="title" required>
            </div>
            <div class="form-group">
                <label for="edit-list_item1">รายการที่ 1:</label>
                <input type="text" id="edit-list_item1" name="list_item1" required>
            </div>
            <div class="form-group">
                <label for="edit-list_item2">รายการที่ 2:</label>
                <input type="text" id="edit-list_item2" name="list_item2" required>
            </div>
            <div class="form-group">
                <label for="edit-list_item3">รายการที่ 3:</label>
                <input type="text" id="edit-list_item3" name="list_item3" required>
            </div>
            <button type="submit" class="btn btn-save">บันทึก</button>
            <button type="button" class="btn btn-cancel" onclick="hideEditForm()">ยกเลิก</button>
        </form>
    </div>
</main>

<script>
    function showEditForm(id, icon_url, title, list_item1, list_item2, list_item3) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-icon_url').value = icon_url;
        document.getElementById('edit-title').value = title;
        document.getElementById('edit-list_item1').value = list_item1;
        document.getElementById('edit-list_item2').value = list_item2;
        document.getElementById('edit-list_item3').value = list_item3;
        document.getElementById('edit-form').style.display = 'block';
    }

    function hideEditForm() {
        document.getElementById('edit-form').style.display = 'none';
    }
</script>

<?php include 'partials/footer.php'; ?>