<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<main class="main-content">
    <h1>จัดการโลโก้</h1>

    <!-- แสดงข้อความแจ้งเตือน -->
    <?php if (isset($message) && $message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- ฟอร์มเพิ่มโลโก้ใหม่ -->
    <h2>เพิ่มโลโก้ใหม่</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">
        <div class="form-group">
            <label for="image_url">URL รูปภาพ:</label>
            <input type="url" id="image_url" name="image_url" required>
        </div>
        <div class="form-group">
            <label for="alt_text">ข้อความ Alt:</label>
            <input type="text" id="alt_text" name="alt_text" required>
        </div>
        <button type="submit" class="btn btn-add">เพิ่มโลโก้</button>
    </form>

    <!-- ตารางแสดงโลโก้ -->
    <h2>รายการโลโก้</h2>
    <?php if (empty($logos)): ?>
        <p>ยังไม่มีโลโก้ในระบบ</p>
    <?php else: ?>
        <table class="logo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>รูปภาพ</th>
                    <th>ข้อความ Alt</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logos as $logo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($logo['id']); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($logo['image_url']); ?>" alt="<?php echo htmlspecialchars($logo['alt_text']); ?>" style="max-width: 100px;">
                        </td>
                        <td><?php echo htmlspecialchars($logo['alt_text']); ?></td>
                        <td>
                            <!-- ปุ่มแก้ไข (เปิดฟอร์มแก้ไข) -->
                            <button class="btn btn-edit" onclick="showEditForm(<?php echo $logo['id']; ?>, '<?php echo htmlspecialchars($logo['image_url']); ?>', '<?php echo htmlspecialchars($logo['alt_text']); ?>')">แก้ไข</button>
                            <!-- ปุ่มลบ -->
                            <a href="index.php?page=logos&action=delete&id=<?php echo $logo['id']; ?>" class="btn btn-delete" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบโลโก้นี้?')">ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- ฟอร์มแก้ไขโลโก้ (ซ่อนไว้ก่อน) -->
    <div id="edit-form" style="display: none;">
        <h2>แก้ไขโลโก้</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group">
                <label for="edit-image_url">URL รูปภาพ:</label>
                <input type="url" id="edit-image_url" name="image_url" required>
            </div>
            <div class="form-group">
                <label for="edit-alt_text">ข้อความ Alt:</label>
                <input type="text" id="edit-alt_text" name="alt_text" required>
            </div>
            <button type="submit" class="btn btn-save">บันทึก</button>
            <button type="button" class="btn btn-cancel" onclick="hideEditForm()">ยกเลิก</button>
        </form>
    </div>
</main>

<script>
    function showEditForm(id, image_url, alt_text) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-image_url').value = image_url;
        document.getElementById('edit-alt_text').value = alt_text;
        document.getElementById('edit-form').style.display = 'block';
    }

    function hideEditForm() {
        document.getElementById('edit-form').style.display = 'none';
    }
</script>

<?php include 'partials/footer.php'; ?>