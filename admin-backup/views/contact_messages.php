<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<main class="ml-64 p-6 w-full min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 animate__animated animate__fadeIn">ข้อความติดต่อจากลูกค้า</h1>

    <div class="card bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg animate__animated animate__fadeInUp">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">รายการข้อความ</h2>
        <?php if (empty($GLOBALS['contact_messages'])): ?>
            <p class="text-gray-600 dark:text-gray-400">ยังไม่มีข้อความในระบบ</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-3">ชื่อ</th>
                            <th class="p-3">อีเมล</th>
                            <th class="p-3">หัวข้อ</th>
                            <th class="p-3">ข้อความ</th>
                            <th class="p-3">วันที่ส่ง</th>
                            <th class="p-3">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody id="messages-table">
                        <?php foreach ($GLOBALS['contact_messages'] as $message): ?>
                            <tr class="bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200"
                                data-id="<?php echo $message['id']; ?>">
                                <td class="p-3"><?php echo htmlspecialchars($message['name']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($message['email']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($message['subject']); ?></td>
                                <td class="p-3 message-preview"
                                    onclick="showMessageDetail(<?php echo $message['id']; ?>, '<?php echo htmlspecialchars($message['name']); ?>', '<?php echo htmlspecialchars($message['email']); ?>', '<?php echo htmlspecialchars($message['subject']); ?>', '<?php echo htmlspecialchars(addslashes($message['message'])); ?>', '<?php echo htmlspecialchars($message['submitted_at']); ?>', <?php echo $message['is_read']; ?>)">
                                    <?php
                                    $short_message = strlen($message['message']) > 50 ? substr($message['message'], 0, 50) . '...' : $message['message'];
                                    echo htmlspecialchars($short_message);
                                    ?>
                                    <?php if (!$message['is_read']): ?>
                                        <span class="inline-block w-2 h-2 bg-green-500 rounded-full ml-2"></span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3"><?php echo htmlspecialchars($message['submitted_at']); ?></td>
                                <td class="p-3 flex gap-2">
                                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo htmlspecialchars($message['email']); ?>&su=ตอบกลับคุณ: <?php echo htmlspecialchars($message['name']); ?> ในเรื่อง: <?php echo htmlspecialchars($message['subject']); ?>&body=สวัสดีครับ/ค่ะ,%0A%0A[กรุณาพิมพ์ข้อความตอบกลับของคุณที่นี่]%0A%0AICONNEX,%0Aทีมงาน Iconnex Thailand"
                                        target="_blank"
                                        class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200">ตอบกลับ</a>
                                    <button
                                        class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200"
                                        onclick="showDeleteMessageModal(<?php echo $message['id']; ?>)">ลบ</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal สำหรับรายละเอียดข้อความ -->
    <div id="message-detail-modal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">รายละเอียดข้อความ</h3>
            <p><strong>ชื่อ:</strong> <span id="detail-name"></span></p>
            <p><strong>อีเมล:</strong> <span id="detail-email"></span></p>
            <p><strong>หัวข้อ:</strong> <span id="detail-subject"></span></p>
            <p><strong>ข้อความ:</strong> <span id="detail-message"></span></p>
            <p><strong>วันที่ส่ง:</strong> <span id="detail-submitted_at"></span></p>
            <div class="flex gap-2 mt-4">
                <button onclick="hideMessageDetail()"
                    class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ปิด</button>
            </div>
        </div>
    </div>

    <!-- Modal สำหรับลบข้อความ -->
    <div id="delete-message-modal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">ยืนยันการลบข้อความ</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">คุณแน่ใจหรือไม่ว่าต้องการลบข้อความนี้?</p>
            <form method="GET" action="">
                <input type="hidden" name="page" value="contact_messages">
                <input type="hidden" name="action" value="delete_message">
                <input type="hidden" name="id" id="delete-message-id">
                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ลบ</button>
                    <button type="button" onclick="hideDeleteMessageModal()"
                        class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    // ฟังก์ชันสำหรับ Modal รายละเอียดข้อความ
    function showMessageDetail(id, name, email, subject, message, submitted_at, is_read) {
        document.getElementById('detail-name').textContent = name;
        document.getElementById('detail-email').textContent = email;
        document.getElementById('detail-subject').textContent = subject;
        document.getElementById('detail-message').textContent = message;
        document.getElementById('detail-submitted_at').textContent = submitted_at;
        document.getElementById('message-detail-modal').classList.remove('hidden');

        if (!is_read) {
            fetch(`index.php?page=contact_messages&action=mark_read&id=${id}`).then(() => {
                const dot = document.querySelector(`tr[data-id="${id}"] .bg-green-500`);
                if (dot) dot.style.display = 'none';
            });
        }
    }

    function hideMessageDetail() {
        document.getElementById('message-detail-modal').classList.add('hidden');
    }

    // ฟังก์ชันสำหรับ Modal ลบข้อความ
    function showDeleteMessageModal(id) {
        document.getElementById('delete-message-id').value = id;
        document.getElementById('delete-message-modal').classList.remove('hidden');
    }

    function hideDeleteMessageModal() {
        document.getElementById('delete-message-modal').classList.add('hidden');
    }

    // อัปเดตข้อความแบบเรียลไทม์
    function fetchMessages() {
        fetch('fetch_messages.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('messages-table');
                tableBody.innerHTML = '';
                data.forEach(message => {
                    const shortMessage = message.message.length > 50 ? message.message.substring(0, 50) + '...' : message.message;
                    const row = `
                    <tr class="bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200" data-id="${message.id}">
                        <td class="p-3">${message.name}</td>
                        <td class="p-3">${message.email}</td>
                        <td class="p-3">${message.subject}</td>
                        <td class="p-3 message-preview" onclick="showMessageDetail(${message.id}, '${message.name}', '${message.email}', '${message.subject}', '${message.message.replace(/'/g, "\\'")}', '${message.submitted_at}', ${message.is_read})">
                            ${shortMessage} ${!message.is_read ? '<span class="inline-block w-2 h-2 bg-green-500 rounded-full ml-2"></span>' : ''}
                        </td>
                        <td class="p-3">${message.submitted_at}</td>
                        <td class="p-3 flex gap-2">
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=${message.email}&su=ตอบกลับคุณ: ${message.name} ในเรื่อง: ${message.subject}&body=สวัสดีครับ/ค่ะ,%0A%0A[กรุณาพิมพ์ข้อความตอบกลับของคุณที่นี่]%0A%0Aขอแสดงความนับถือ,%0Aทีมงาน ICONNEX Thailand" target="_blank" 
                                class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200">ตอบกลับ</a>
                            <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="showDeleteMessageModal(${message.id})">ลบ</button>
                        </td>
                    </tr>
                `;
                    tableBody.innerHTML += row;
                });
            });
    }

    setInterval(fetchMessages, 5000);
    fetchMessages();
</script>

<?php include 'partials/footer.php'; ?>