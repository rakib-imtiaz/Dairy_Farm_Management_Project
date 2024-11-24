<?php
require_once 'includes/auth.php';
requireLogin();

// Get database connection
$conn = getDBConnection();

// Fetch basic statistics
try {
    // Total cows
    $stmt = $conn->query("SELECT COUNT(*) as total FROM cows");
    $totalCows = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Today's milk production
    $stmt = $conn->query("SELECT total_milk_yield FROM milk_production WHERE production_date = CURDATE()");
    $todayMilk = $stmt->fetch(PDO::FETCH_ASSOC)['total_milk_yield'] ?? 0;

    // Low inventory alerts
    $stmt = $conn->query("SELECT COUNT(*) as total FROM alerts WHERE alert_type = 'Low Inventory'");
    $lowInventory = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Recent health events
    $stmt = $conn->query("SELECT COUNT(*) as total FROM health_events WHERE event_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
    $recentHealth = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

} catch (PDOException $e) {
    // For demo, simply set default values if query fails
    $totalCows = 0;
    $todayMilk = 0;
    $lowInventory = 0;
    $recentHealth = 0;
}

require_once 'includes/header.php';
?>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Message -->
        <h1 class="text-2xl font-semibold text-gray-900">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p class="mt-1 text-sm text-gray-600">Here's an overview of your farm's current status</p>

        <!-- Statistics Cards -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Cows -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Cows</dt>
                                <dd class="text-lg font-semibold text-gray-900"><?php echo $totalCows; ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="<?php echo BASE_URL; ?>modules/cows/" class="font-medium text-blue-600 hover:text-blue-900">View all cows →</a>
                    </div>
                </div>
            </div>

            <!-- Today's Milk Production -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Today's Milk (L)</dt>
                                <dd class="text-lg font-semibold text-gray-900"><?php echo number_format($todayMilk, 2); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="<?php echo BASE_URL; ?>modules/milk/" class="font-medium text-blue-600 hover:text-blue-900">View production →</a>
                    </div>
                </div>
            </div>

            <!-- Low Inventory Alerts -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Low Stock Alerts</dt>
                                <dd class="text-lg font-semibold text-gray-900"><?php echo $lowInventory; ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="<?php echo BASE_URL; ?>modules/inventory/" class="font-medium text-blue-600 hover:text-blue-900">Check inventory →</a>
                    </div>
                </div>
            </div>

            <!-- Recent Health Events -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Health Events (7d)</dt>
                                <dd class="text-lg font-semibold text-gray-900"><?php echo $recentHealth; ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="<?php echo BASE_URL; ?>modules/health/" class="font-medium text-blue-600 hover:text-blue-900">View health records →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900">Quick Actions</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="<?php echo BASE_URL; ?>modules/cows/add.php" class="block p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                    <h3 class="text-base font-medium text-gray-900">Add New Cow</h3>
                    <p class="mt-1 text-sm text-gray-500">Register a new cow in the system</p>
                </a>
                <a href="<?php echo BASE_URL; ?>modules/milk/add.php" class="block p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                    <h3 class="text-base font-medium text-gray-900">Record Milk Production</h3>
                    <p class="mt-1 text-sm text-gray-500">Enter today's milk production data</p>
                </a>
                <a href="<?php echo BASE_URL; ?>modules/health/add.php" class="block p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                    <h3 class="text-base font-medium text-gray-900">Log Health Event</h3>
                    <p class="mt-1 text-sm text-gray-500">Record a new health event</p>
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 