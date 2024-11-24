<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DFMS - Dairy Farm Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">
    <?php if (isLoggedIn()): ?>
    <!-- Navigation -->
    <nav class="bg-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="<?php echo BASE_URL; ?>dashboard.php" class="text-white text-lg font-bold hover:text-gray-200">DFMS</a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <?php
                        $current_page = $_SERVER['PHP_SELF'];
                        $nav_items = [
                            'dashboard.php' => 'Dashboard',
                            'modules/cows/' => 'Cows',
                            'modules/health/' => 'Health',
                            'modules/feeding/' => 'Feeding',
                            'modules/milk/' => 'Milk Production',
                            'modules/inventory/' => 'Inventory',
                            'modules/alerts/' => 'Alerts'
                        ];

                        foreach ($nav_items as $url => $label) {
                            $full_url = BASE_URL . $url;
                            $active = strpos($current_page, $url) === 0;
                            $class = $active 
                                ? 'bg-blue-700 text-white' 
                                : 'text-white hover:bg-blue-500';
                            echo "<a href='{$full_url}' class='{$class} px-3 py-2 rounded-md text-sm font-medium'>{$label}</a>";
                        }
                        ?>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="relative ml-3">
                            <div class="flex items-center">
                                <span class="text-white mr-4">
                                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                                </span>
                                <a href="<?php echo BASE_URL; ?>logout.php" 
                                   class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-sm font-medium">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" 
                            class="mobile-menu-button bg-blue-600 inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-600 focus:ring-white"
                            aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <?php
                foreach ($nav_items as $url => $label) {
                    $full_url = BASE_URL . $url;
                    $active = strpos($current_page, $url) === 0;
                    $class = $active 
                        ? 'bg-blue-700 text-white' 
                        : 'text-white hover:bg-blue-500';
                    echo "<a href='{$full_url}' class='{$class} block px-3 py-2 rounded-md text-base font-medium'>{$label}</a>";
                }
                ?>
                <a href="<?php echo BASE_URL; ?>logout.php" class="text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium">Logout</a>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="flex-grow">
</body>
</html> 