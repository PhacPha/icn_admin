<?php include 'partials/header.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<main class="ml-64 p-6 w-full min-h-screen bg-white">
    <!-- Loading Overlay -->
    <div id="loading-overlay"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-6 animate__animated animate__fadeIn">Manage Home Page</h1>

    <!-- Card สำหรับจัดการ Logos -->
    <div class="card bg-white p-6 rounded-lg shadow-lg mb-6 animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">จัดการโลโก้</h2>
            <button onclick="showAddLogoModal()" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200">เพิ่มโลโก้</button>
        </div>

        <!-- ตารางแสดงโลโก้ -->
        <h3 class="text-xl font-medium text-gray-700 mt-6 mb-3">Logo List</h3>
        <?php if (empty($GLOBALS['logos'])): ?>
            <p class="text-gray-600">ยังไม่มีโลโก้ในระบบ</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="logo-table w-full text-center border-separate border border-gray-300">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-3 border border-gray-300">ID</th>
                            <th class="p-3 border border-gray-300">รูปภาพ</th>
                            <th class="p-3 border border-gray-300">ข้อความ Alt</th>
                            <th class="p-3 border border-gray-300">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GLOBALS['logos'] as $logo): ?>
                            <tr class="bg-white hover:bg-gray-100 transition-colors duration-200">
                                <td class="p-3 border border-gray-300"><?php echo htmlspecialchars($logo['id']); ?></td>
                                <td class="p-3 border border-gray-300 align-middle">
                                    <?php if (!empty($logo['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($logo['image_url']); ?>" alt="<?php echo htmlspecialchars($logo['alt_text']); ?>" class="max-w-[100px] rounded-lg" data-placeholder="/assets/images/placeholder.png">
                                    <?php else: ?>
                                        <img src="/assets/images/placeholder.png" alt="Placeholder" class="max-w-[100px] rounded-lg">
                                        <p class="text-red-500 text-sm mt-1">ไม่มีรูปภาพ</p>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3"><?php echo htmlspecialchars($logo['alt_text']); ?></td>
                                <td class="p-3 flex gap-2">
                                    <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200" onclick="showEditLogoModal(<?php echo $logo['id']; ?>, '<?php echo htmlspecialchars($logo['image_url']); ?>', '<?php echo htmlspecialchars($logo['alt_text']); ?>')">แก้ไข</button>
                                    <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="showDeleteLogoModal(<?php echo $logo['id']; ?>)">ลบ</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Card สำหรับจัดการ Services -->
    <div class="card bg-white p-6 rounded-lg shadow-lg mb-6 animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">จัดการบริการ</h2>
            <button onclick="showAddServiceModal()" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200">เพิ่มบริการ</button>
        </div>

        <!-- ตารางแสดงบริการ -->
        <h3 class="text-xl font-medium text-gray-700 mt-6 mb-3">รายการบริการ</h3>
        <?php if (empty($GLOBALS['services'])): ?>
            <p class="text-gray-600">ยังไม่มีบริการในระบบ</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="service-table w-full text-center border-separate border border-gray-300">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-3 border border-gray-300">ID</th>
                            <th class="p-3 border border-gray-300">ไอคอน</th>
                            <th class="p-3 border border-gray-300">ชื่อบริการ</th>
                            <th class="p-3 border border-gray-300">รายการที่ 1</th>
                            <th class="p-3 border border-gray-300">รายการที่ 2</th>
                            <th class="p-3 border border-gray-300">รายการที่ 3</th>
                            <th class="p-3 border border-gray-300">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GLOBALS['services'] as $service): ?>
                            <tr class="bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                <td class="p-3"><?php echo htmlspecialchars($service['id']); ?></td>
                                <td class="p-3">
                                    <?php if (!empty($service['icon_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($service['icon_url']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" class="max-w-[50px] rounded-lg" data-placeholder="/assets/images/placeholder.png">
                                    <?php else: ?>
                                        <img src="/assets/images/placeholder.png" alt="Placeholder" class="max-w-[50px] rounded-lg">
                                        <p class="text-red-500 text-sm mt-1">ไม่มีไอคอน</p>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3"><?php echo htmlspecialchars($service['title']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($service['list_item1']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($service['list_item2']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($service['list_item3']); ?></td>
                                <td class="p-3 flex gap-2">
                                    <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200" onclick="showEditServiceModal(<?php echo $service['id']; ?>, '<?php echo htmlspecialchars($service['icon_url']); ?>', '<?php echo htmlspecialchars($service['title']); ?>', '<?php echo htmlspecialchars($service['list_item1']); ?>', '<?php echo htmlspecialchars($service['list_item2']); ?>', '<?php echo htmlspecialchars($service['list_item3']); ?>')">แก้ไข</button>
                                    <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="showDeleteServiceModal(<?php echo $service['id']; ?>)">ลบ</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Card สำหรับจัดการ SomeWorks -->
    <div class="card bg-white p-6 rounded-lg shadow-lg mb-6 animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">จัดการผลงาน (SomeWorks)</h2>
            <button onclick="showAddWorkModal()" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200">เพิ่มผลงาน</button>
        </div>

        <!-- ตารางแสดงผลงาน -->
        <h3 class="text-xl font-medium text-gray-700 mt-6 mb-3">รายการผลงาน</h3>
        <?php if (empty($GLOBALS['works'])): ?>
            <p class="text-gray-600">ยังไม่มีผลงานในระบบ</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="work-table w-full text-center border-separate border border-gray-300">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-3 border border-gray-300">ID</th>
                            <th class="p-3 border border-gray-300">รูปภาพ</th>
                            <th class="p-3 border border-gray-300">ชื่อผลงาน</th>
                            <th class="p-3 border border-gray-300">รายการที่ 1</th>
                            <th class="p-3 border border-gray-300">รายการที่ 2</th>
                            <th class="p-3 border border-gray-300">รายการที่ 3</th>
                            <th class="p-3 border border-gray-300">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GLOBALS['works'] as $work): ?>
                            <tr class="bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                <td class="p-3"><?php echo htmlspecialchars($work['id']); ?></td>
                                <td class="p-3">
                                    <?php if (!empty($work['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($work['image_url']); ?>" alt="<?php echo htmlspecialchars($work['title']); ?>" class="max-w-[100px] rounded-lg" data-placeholder="/assets/images/placeholder.png">
                                    <?php else: ?>
                                        <img src="/assets/images/placeholder.png" alt="Placeholder" class="max-w-[100px] rounded-lg">
                                        <p class="text-red-500 text-sm mt-1">ไม่มีรูปภาพ</p>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3"><?php echo htmlspecialchars($work['title']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($work['list_item1']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($work['list_item2']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($work['list_item3']); ?></td>
                                <td class="p-3 flex gap-2">
                                    <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200" onclick="showEditWorkModal(<?php echo $work['id']; ?>, '<?php echo htmlspecialchars($work['image_url']); ?>', '<?php echo htmlspecialchars($work['title']); ?>', '<?php echo htmlspecialchars($work['list_item1']); ?>', '<?php echo htmlspecialchars($work['list_item2']); ?>', '<?php echo htmlspecialchars($work['list_item3']); ?>')">แก้ไข</button>
                                    <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="showDeleteWorkModal(<?php echo $work['id']; ?>)">ลบ</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Card สำหรับจัดการ Testimonials -->
    <div class="card bg-white p-6 rounded-lg shadow-lg mb-6 animate__animated animate__fadeInUp">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">จัดการคอมเมนต์ (Testimonials)</h2>
            <button onclick="showAddTestimonialModal()" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200">เพิ่มคอมเมนต์</button>
        </div>
        <?php if (isset($GLOBALS['testimonial_message']) && $GLOBALS['testimonial_message']): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: '<?php echo htmlspecialchars($GLOBALS['testimonial_message']); ?>',
                        timer: 3000,
                        showConfirmButton: false
                    });
                });
            </script>
        <?php endif; ?>
        <h3 class="text-xl font-medium text-gray-700 mt-6 mb-3">รายการคอมเมนต์</h3>
        <?php if (empty($GLOBALS['testimonials'])): ?>
            <p class="text-gray-600">ยังไม่มีคอมเมนต์ในระบบ</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="testimonial-table w-full text-center border-separate border border-gray-300">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-3 border border-gray-300">ID</th>
                            <th class="p-3 border border-gray-300">คำพูด (Quote)</th>
                            <th class="p-3 border border-gray-300">ข้อความ (Text)</th>
                            <th class="p-3 border border-gray-300">ชื่อผู้เขียน</th>
                            <th class="p-3 border border-gray-300">ที่อยู่ผู้เขียน</th>
                            <th class="p-3 border border-gray-300">รูปภาพ (Avatar)</th>
                            <th class="p-3 border border-gray-300">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GLOBALS['testimonials'] as $testimonial): ?>
                            <tr class="bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                <td class="p-3"><?php echo htmlspecialchars($testimonial['id']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($testimonial['quote']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($testimonial['text']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($testimonial['author_name']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($testimonial['author_location']); ?></td>
                                <td class="p-3">
                                    <?php if (!empty($testimonial['avatar_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($testimonial['avatar_url']); ?>" alt="<?php echo htmlspecialchars($testimonial['author_name']); ?>" class="max-w-[50px] rounded-full" data-placeholder="/assets/images/placeholder.png">
                                    <?php else: ?>
                                        <img src="/assets/images/placeholder.png" alt="Placeholder" class="max-w-[50px] rounded-full">
                                        <p class="text-red-500 text-sm mt-1">ไม่มีรูปภาพ</p>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3 flex gap-2">
                                    <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors duration-200" onclick="showEditTestimonialModal(<?php echo $testimonial['id']; ?>, '<?php echo htmlspecialchars($testimonial['quote']); ?>', '<?php echo htmlspecialchars($testimonial['text']); ?>', '<?php echo htmlspecialchars($testimonial['author_name']); ?>', '<?php echo htmlspecialchars($testimonial['author_location']); ?>', '<?php echo htmlspecialchars($testimonial['avatar_url']); ?>')">แก้ไข</button>
                                    <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="showDeleteTestimonialModal(<?php echo $testimonial['id']; ?>)">ลบ</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal สำหรับเพิ่มโลโก้ -->
    <div id="add-logo-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">เพิ่มโลโก้ใหม่</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_logo">
                <div class="form-group mb-4">
                    <label for="add-logo-image" class="block text-gray-700 mb-1">รูปภาพ (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="add-logo-image" name="image" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="add-logo-image_url" name="image_url" placeholder="วาง URL รูปภาพ" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="add-logo-alt_text" class="block text-gray-700 dark:text-gray-300 mb-1">ข้อความ Alt:</label>
                    <input type="text" id="add-logo-alt_text" name="alt_text" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">เพิ่ม</button>
                    <button type="button" onclick="hideAddLogoModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับแก้ไขโลโก้ -->
    <div id="edit-logo-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">แก้ไขโลโก้</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_logo">
                <input type="hidden" name="id" id="edit-logo-id">
                <div class="form-group mb-4">
                    <label for="edit-logo-image" class="block text-gray-700 mb-1">รูปภาพ (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="edit-logo-image" name="image" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="edit-logo-image_url" name="image_url" placeholder="วาง URL รูปภาพ" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-logo-alt_text" class="block text-gray-700 dark:text-gray-300 mb-1">ข้อความ Alt:</label>
                    <input type="text" id="edit-logo-alt_text" name="alt_text" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">บันทึก</button>
                    <button type="button" onclick="hideEditLogoModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับลบโลโก้ -->
    <div id="delete-logo-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">ยืนยันการลบโลโก้</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">คุณแน่ใจหรือไม่ว่าต้องการลบโลโก้นี้?</p>
            <form method="GET" action="">
                <input type="hidden" name="page" value="home">
                <input type="hidden" name="action" value="delete_logo">
                <input type="hidden" name="id" id="delete-logo-id">
                <div class="flex gap-2">
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ลบ</button>
                    <button type="button" onclick="hideDeleteLogoModal()" class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับเพิ่มบริการ -->
    <div id="add-service-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">เพิ่มบริการใหม่</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_service">
                <div class="form-group mb-4">
                    <label for="add-service-icon" class="block text-gray-700 mb-1">ไอคอน (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="add-service-icon" name="icon" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="add-service-icon_url" name="icon_url" placeholder="วาง URL ไอคอน" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อบริการ:</label>
                    <input type="text" id="add-service-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-list_item1" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 1:</label>
                    <input type="text" id="add-service-list_item1" name="list_item1" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-list_item2" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 2:</label>
                    <input type="text" id="add-service-list_item2" name="list_item2" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-service-list_item3" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 3:</label>
                    <input type="text" id="add-service-list_item3" name="list_item3" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">เพิ่ม</button>
                    <button type="button" onclick="hideAddServiceModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับแก้ไขบริการ -->
    <div id="edit-service-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">แก้ไขบริการ</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_service">
                <input type="hidden" name="id" id="edit-service-id">
                <div class="form-group mb-4">
                    <label for="edit-service-icon" class="block text-gray-700 mb-1">ไอคอน (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="edit-service-icon" name="icon" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="edit-service-icon_url" name="icon_url" placeholder="วาง URL ไอคอน" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อบริการ:</label>
                    <input type="text" id="edit-service-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-list_item1" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 1:</label>
                    <input type="text" id="edit-service-list_item1" name="list_item1" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-list_item2" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 2:</label>
                    <input type="text" id="edit-service-list_item2" name="list_item2" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-service-list_item3" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 3:</label>
                    <input type="text" id="edit-service-list_item3" name="list_item3" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">บันทึก</button>
                    <button type="button" onclick="hideEditServiceModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับลบบริการ -->
    <div id="delete-service-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">ยืนยันการลบบริการ</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">คุณแน่ใจหรือไม่ว่าต้องการลบบริการนี้?</p>
            <form method="GET" action="">
                <input type="hidden" name="page" value="home">
                <input type="hidden" name="action" value="delete_service">
                <input type="hidden" name="id" id="delete-service-id">
                <div class="flex gap-2">
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ลบ</button>
                    <button type="button" onclick="hideDeleteServiceModal()" class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับเพิ่มผลงาน -->
    <div id="add-work-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">เพิ่มผลงานใหม่</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_work">
                <div class="form-group mb-4">
                    <label for="add-work-image" class="block text-gray-700 mb-1">รูปภาพ (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="add-work-image" name="image" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="add-work-image_url" name="image_url" placeholder="วาง URL รูปภาพ" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="add-work-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อผลงาน:</label>
                    <input type="text" id="add-work-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-work-list_item1" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 1:</label>
                    <input type="text" id="add-work-list_item1" name="list_item1" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-work-list_item2" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 2:</label>
                    <input type="text" id="add-work-list_item2" name="list_item2" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-work-list_item3" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 3:</label>
                    <input type="text" id="add-work-list_item3" name="list_item3" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">เพิ่ม</button>
                    <button type="button" onclick="hideAddWorkModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับแก้ไขผลงาน -->
    <div id="edit-work-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">แก้ไขผลงาน</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_work">
                <input type="hidden" name="id" id="edit-work-id">
                <div class="form-group mb-4">
                    <label for="edit-work-image" class="block text-gray-700 mb-1">รูปภาพ (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="edit-work-image" name="image" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="edit-work-image_url" name="image_url" placeholder="วาง URL รูปภาพ" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-work-title" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อผลงาน:</label>
                    <input type="text" id="edit-work-title" name="title" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-work-list_item1" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 1:</label>
                    <input type="text" id="edit-work-list_item1" name="list_item1" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-work-list_item2" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 2:</label>
                    <input type="text" id="edit-work-list_item2" name="list_item2" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-work-list_item3" class="block text-gray-700 dark:text-gray-300 mb-1">รายการที่ 3:</label>
                    <input type="text" id="edit-work-list_item3" name="list_item3" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">บันทึก</button>
                    <button type="button" onclick="hideEditWorkModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับลบผลงาน -->
    <div id="delete-work-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">ยืนยันการลบผลงาน</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">คุณแน่ใจหรือไม่ว่าต้องการลบผลงานนี้?</p>
            <form method="GET" action="">
                <input type="hidden" name="page" value="home">
                <input type="hidden" name="action" value="delete_work">
                <input type="hidden" name="id" id="delete-work-id">
                <div class="flex gap-2">
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ลบ</button>
                    <button type="button" onclick="hideDeleteWorkModal()" class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับเพิ่มคอมเมนต์ (Testimonials) -->
    <div id="add-testimonial-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">เพิ่มคอมเมนต์ใหม่</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_testimonial">
                <div class="form-group mb-4">
                    <label for="add-testimonial-quote" class="block text-gray-700 dark:text-gray-300 mb-1">คำพูด (Quote):</label>
                    <input type="text" id="add-testimonial-quote" name="quote" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-testimonial-text" class="block text-gray-700 dark:text-gray-300 mb-1">ข้อความ (Text):</label>
                    <textarea id="add-testimonial-text" name="text" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="add-testimonial-author_name" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อผู้เขียน:</label>
                    <input type="text" id="add-testimonial-author_name" name="author_name" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-testimonial-author_location" class="block text-gray-700 dark:text-gray-300 mb-1">ที่อยู่ผู้เขียน:</label>
                    <input type="text" id="add-testimonial-author_location" name="author_location" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="add-testimonial-avatar" class="block text-gray-700 dark:text-gray-300 mb-1">รูปภาพ (Avatar) (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="add-testimonial-avatar" name="avatar" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="add-testimonial-avatar_url" name="avatar_url" placeholder="วาง URL รูปภาพ" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">เพิ่ม</button>
                    <button type="button" onclick="hideAddTestimonialModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับแก้ไขคอมเมนต์ (Testimonials) -->
    <div id="edit-testimonial-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">แก้ไขคอมเมนต์</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_testimonial">
                <input type="hidden" name="id" id="edit-testimonial-id">
                <div class="form-group mb-4">
                    <label for="edit-testimonial-quote" class="block text-gray-700 dark:text-gray-300 mb-1">คำพูด (Quote):</label>
                    <input type="text" id="edit-testimonial-quote" name="quote" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-testimonial-text" class="block text-gray-700 dark:text-gray-300 mb-1">ข้อความ (Text):</label>
                    <textarea id="edit-testimonial-text" name="text" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-testimonial-author_name" class="block text-gray-700 dark:text-gray-300 mb-1">ชื่อผู้เขียน:</label>
                    <input type="text" id="edit-testimonial-author_name" name="author_name" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-testimonial-author_location" class="block text-gray-700 dark:text-gray-300 mb-1">ที่อยู่ผู้เขียน:</label>
                    <input type="text" id="edit-testimonial-author_location" name="author_location" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="form-group mb-4">
                    <label for="edit-testimonial-avatar" class="block text-gray-700 dark:text-gray-300 mb-1">รูปภาพ (Avatar) (อัปโหลดหรือวาง URL):</label>
                    <div class="flex items-center gap-2">
                        <input type="file" id="edit-testimonial-avatar" name="avatar" accept="image/*" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 dark:text-gray-400">หรือ</span>
                        <input type="url" id="edit-testimonial-avatar_url" name="avatar_url" placeholder="วาง URL รูปภาพ" class="w-full p-1 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex-1">บันทึก</button>
                    <button type="button" onclick="hideEditTestimonialModal()" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal สำหรับลบคอมเมนต์ (Testimonials) -->
    <div id="delete-testimonial-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200 mb-4">ยืนยันการลบคอมเมนต์</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">คุณแน่ใจหรือไม่ว่าต้องการลบคอมเมนต์นี้?</p>
            <form method="GET" action="">
                <input type="hidden" name="page" value="home">
                <input type="hidden" name="action" value="delete_testimonial">
                <input type="hidden" name="id" id="delete-testimonial-id">
                <div class="flex gap-2">
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex-1">ลบ</button>
                    <button type="button" onclick="hideDeleteTestimonialModal()" class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex-1">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    // แสดง Loading Overlay เมื่อโหลดหน้า
    document.addEventListener('DOMContentLoaded', function () {
        const loadingOverlay = document.getElementById('loading-overlay');
        loadingOverlay.classList.remove('hidden');
        setTimeout(() => {
            loadingOverlay.classList.add('hidden');
        }, 1000);

    // จัดการการสลับระหว่างการอัปโหลดไฟล์และการวาง URL
    function handleImageInput(fileInputId, urlInputId) {
        const fileInput = document.getElementById(fileInputId);
        const urlInput = document.getElementById(urlInputId);

            fileInput.addEventListener('change', function () {
                if (fileInput.files.length > 0) {
                    urlInput.value = ''; // ล้าง URL ถ้ามีการเลือกไฟล์
                }
            });

            urlInput.addEventListener('input', function () {
                if (urlInput.value) {
                    fileInput.value = ''; // ล้างไฟล์ถ้ามีการวาง URL
                }
            });
        }

    // เรียกใช้ฟังก์ชันสำหรับแต่ละ Modal
    handleImageInput('add-logo-image', 'add-logo-image_url');
    handleImageInput('edit-logo-image', 'edit-logo-image_url');
    handleImageInput('add-service-icon', 'add-service-icon_url');
    handleImageInput('edit-service-icon', 'edit-service-icon_url');
    handleImageInput('add-work-image', 'add-work-image_url');
    handleImageInput('edit-work-image', 'edit-work-image_url');
    handleImageInput('add-testimonial-avatar', 'add-testimonial-avatar_url');
    handleImageInput('edit-testimonial-avatar', 'edit-testimonial-avatar_url');

    // ป้องกัน Infinite Loop ของ onerror
    const images = document.querySelectorAll('img[data-placeholder]');
    images.forEach(img => {
        img.onerror = function() {
            if (!img.dataset.placeholderLoaded) {
                img.src = img.dataset.placeholder;
                img.dataset.placeholderLoaded = true; // เพิ่ม flag เพื่อป้องกันการเรียกซ้ำ
            }
        };
    });
});

// ฟังก์ชันสำหรับจัดการ Modal เพิ่มโลโก้
function showAddLogoModal() {
    document.getElementById('add-logo-modal').classList.remove('hidden');
}

function hideAddLogoModal() {
    document.getElementById('add-logo-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal แก้ไขโลโก้
function showEditLogoModal(id, image_url, alt_text) {
    document.getElementById('edit-logo-id').value = id;
    document.getElementById('edit-logo-image_url').value = image_url;
    document.getElementById('edit-logo-alt_text').value = alt_text;
    document.getElementById('edit-logo-modal').classList.remove('hidden');
}

function hideEditLogoModal() {
    document.getElementById('edit-logo-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal ลบโลโก้
function showDeleteLogoModal(id) {
    document.getElementById('delete-logo-id').value = id;
    document.getElementById('delete-logo-modal').classList.remove('hidden');
}

function hideDeleteLogoModal() {
    document.getElementById('delete-logo-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal เพิ่มบริการ
function showAddServiceModal() {
    document.getElementById('add-service-modal').classList.remove('hidden');
}

function hideAddServiceModal() {
    document.getElementById('add-service-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal แก้ไขบริการ
function showEditServiceModal(id, icon_url, title, list_item1, list_item2, list_item3) {
    document.getElementById('edit-service-id').value = id;
    document.getElementById('edit-service-icon_url').value = icon_url;
    document.getElementById('edit-service-title').value = title;
    document.getElementById('edit-service-list_item1').value = list_item1;
    document.getElementById('edit-service-list_item2').value = list_item2;
    document.getElementById('edit-service-list_item3').value = list_item3;
    document.getElementById('edit-service-modal').classList.remove('hidden');
}

function hideEditServiceModal() {
    document.getElementById('edit-service-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal ลบบริการ
function showDeleteServiceModal(id) {
    document.getElementById('delete-service-id').value = id;
    document.getElementById('delete-service-modal').classList.remove('hidden');
}

function hideDeleteServiceModal() {
    document.getElementById('delete-service-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal เพิ่มผลงาน
function showAddWorkModal() {
    document.getElementById('add-work-modal').classList.remove('hidden');
}

function hideAddWorkModal() {
    document.getElementById('add-work-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal แก้ไขผลงาน
function showEditWorkModal(id, image_url, title, list_item1, list_item2, list_item3) {
    document.getElementById('edit-work-id').value = id;
    document.getElementById('edit-work-image_url').value = image_url;
    document.getElementById('edit-work-title').value = title;
    document.getElementById('edit-work-list_item1').value = list_item1;
    document.getElementById('edit-work-list_item2').value = list_item2;
    document.getElementById('edit-work-list_item3').value = list_item3;
    document.getElementById('edit-work-modal').classList.remove('hidden');
}

function hideEditWorkModal() {
    document.getElementById('edit-work-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal ลบผลงาน
function showDeleteWorkModal(id) {
    document.getElementById('delete-work-id').value = id;
    document.getElementById('delete-work-modal').classList.remove('hidden');
}

function hideDeleteWorkModal() {
    document.getElementById('delete-work-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal เพิ่มคอมเมนต์ (Testimonials)
function showAddTestimonialModal() {
    document.getElementById('add-testimonial-modal').classList.remove('hidden');
}

function hideAddTestimonialModal() {
    document.getElementById('add-testimonial-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal แก้ไขคอมเมนต์ (Testimonials)
function showEditTestimonialModal(id, quote, text, author_name, author_location, avatar_url) {
    document.getElementById('edit-testimonial-id').value = id;
    document.getElementById('edit-testimonial-quote').value = quote;
    document.getElementById('edit-testimonial-text').value = text;
    document.getElementById('edit-testimonial-author_name').value = author_name;
    document.getElementById('edit-testimonial-author_location').value = author_location;
    document.getElementById('edit-testimonial-avatar_url').value = avatar_url;
    document.getElementById('edit-testimonial-modal').classList.remove('hidden');
}

function hideEditTestimonialModal() {
    document.getElementById('edit-testimonial-modal').classList.add('hidden');
}

// ฟังก์ชันสำหรับจัดการ Modal ลบคอมเมนต์ (Testimonials)
function showDeleteTestimonialModal(id) {
    document.getElementById('delete-testimonial-id').value = id;
    document.getElementById('delete-testimonial-modal').classList.remove('hidden');
}

function hideDeleteTestimonialModal() {
    document.getElementById('delete-testimonial-modal').classList.add('hidden');
}

// Dark Mode Toggle
document.getElementById('dark-mode-toggle').addEventListener('click', function() {
    document.body.classList.toggle('dark');
    const icon = this.querySelector('i');
    if (document.body.classList.contains('dark')) {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
    } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
    }
});
</script>

<?php include 'partials/footer.php'; ?>
