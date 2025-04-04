<aside class="sidebar w-64 text-white h-screen fixed top-0 left-0 p-6 shadow-lg transition-all duration-300 bg-blue-600">
    <!-- กล่องรวมโลโก้ + ชื่อ Admin -->
    <div class="flex flex-col items-center mb-6">
        <!-- ตรงนี้คือส่วนของโลโก้ -->
        <img src="../icn_admin/admin_backup/img/logo.png" alt="Iconnex Logo" class="w-20 h-20 object-cover rounded-full mb-2" />

        <!-- ข้อความ Iconnex Admin -->
        <h2 class="text-2xl font-bold">Iconnex Admin</h2>
    </div>

    <nav>
        <ul>
            <li class="mb-4">
                <a href="index.php?page=dashboard" class="flex items-center gap-3 p-3">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="mb-4">
                <a href="index.php?page=home" class="flex items-center gap-3 p-3">
                    <i class="fas fa-home"></i> Manage Home Page
                </a>
            </li>
            <li class="mb-4">
                <a href="index.php?page=service_management" class="flex items-center gap-3 p-3">
                    <i class="fas fa-cogs"></i> Service Management
                </a>
            </li>
            <li class="mb-4">
                <a href="index.php?page=content_management" class="flex items-center gap-3 p-3">
                    <i class="fas fa-file-alt"></i> Content Management
                </a>
            </li>
            <li class="mb-4">
                <a href="../logout.php" class="flex items-center gap-3 p-3">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
</aside>
