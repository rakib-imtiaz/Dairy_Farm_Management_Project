<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';
requireLogin();

$alert_id = isset($_GET['id']) ? $_GET['id'] : null;
$error_message = '';

if (!$alert_id) {
    header('Location: index.php');
    exit();
}

// Check if the alert exists before deletion
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT alert_id FROM alerts WHERE alert_id = ?");
    $stmt->execute([$alert_id]);
    
    if (!$stmt->fetch()) {
        $_SESSION['error_message'] = "Alert not found.";
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Database error: " . $e->getMessage();
    header('Location: index.php');
    exit();
}

// Handle the deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare("DELETE FROM alerts WHERE alert_id = ?");
        $stmt->execute([$alert_id]);
        
        $_SESSION['success_message'] = "Alert deleted successfully.";
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        $error_message = "Deletion failed: " . $e->getMessage();
    }
}

require_once '../../includes/header.php';
?>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold text-gray-900">Delete Alert</h1>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="index.php" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Back to List
                </a>
            </div>
        </div>

        <?php if ($error_message): ?>
            <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Confirm Deletion</h3>
                <p class="mt-1 text-sm text-gray-500">Are you sure you want to delete this alert? This action cannot be undone.</p>
            </div>
            <div class="mt-6 flex justify-center space-x-4">
                <form method="POST" action="">
                    <button type="submit" class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Alert
                    </button>
                </form>
                <a href="index.php" class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div> 