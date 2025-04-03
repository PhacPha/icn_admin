<aside class="w-64 bg-gray-800 text-white h-screen fixed top-0 left-0 p-6 shadow-lg transition-all duration-300">
    <h2 class="text-2xl font-bold text-center mb-8">Iconnex Admin</h2>
    <nav>
        <ul>
            <li class="mb-4">
                <a href="index.php?page=dashboard" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="mb-4">
                <a href="index.php?page=home" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-home"></i> Manage Home Page
                </a>
            </li>
            <li class="mb-4">
                <a href="index.php?page=service_management" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-cogs"></i> Service Management
                </a>
            </li>
            <li class="mb-4">
                <a href="index.php?page=content_management" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-file-alt"></i> Content Management
                </a>
            </li>
            <li class="mb-4">
                <a href="../logout.php" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
    <!-- Dark Mode Toggle -->
    <div class="mt-8 flex justify-center">
        <button id="dark-mode-toggle" class="p-2 rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-200">
            <i class="fas fa-moon text-white"></i>
        </button>
    </div>
</aside>