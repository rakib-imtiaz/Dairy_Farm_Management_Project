<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';
requireLogin();

$production_id = isset($_GET['id']) ? $_GET['id'] : null;
$error_message = '';
$success_message = '';

// Fetch milk production details if ID is provided
if ($production_id) {
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT * FROM milk_production WHERE production_id = ?");
        $stmt->execute([$production_id]);
        $production = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$production) {
            $_SESSION['error_message'] = "Production record not found";
            header('Location: ' . BASE_URL . 'modules/milk/');
            exit();
        }
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $production_date = $_POST['production_date'] ?? '';
    $total_milk_yield = $_POST['total_milk_yield'] ?? '';

    // Validate input
    if (empty($production_date) || empty($total_milk_yield)) {
        $error_message = "All fields are required.";
    } elseif (!is_numeric($total_milk_yield) || $total_milk_yield < 0) {
        $error_message = "Invalid milk yield value.";
    } else {
        try {
            $conn = getDBConnection();
            
            // Check if another record exists for the same date (excluding current record)
            $stmt = $conn->prepare("SELECT production_id FROM milk_production 
                                  WHERE production_date = ? AND production_id != ?");
            $stmt->execute([$production_date, $production_id]);
            
            if ($stmt->fetch()) {
                $error_message = "A production record already exists for this date.";
            } else {
                // Update the record
                $stmt = $conn->prepare("UPDATE milk_production 
                                      SET production_date = ?, total_milk_yield = ? 
                                      WHERE production_id = ?");
                $stmt->execute([$production_date, $total_milk_yield, $production_id]);
                
                $_SESSION['success_message'] = "Milk production record updated successfully";
                header('Location: ' . BASE_URL . 'modules/milk/');
                exit();
            }
        } catch (PDOException $e) {
            $error_message = "Update failed: " . $e->getMessage();
        }
    }
}

require_once '../../includes/header.php';
?>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Milk Production Record</h1>
                <p class="mt-2 text-sm text-gray-700">Update milk production details for this record</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="<?php echo BASE_URL; ?>modules/milk/" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Back to List
                </a>
            </div>
        </div>

        <?php if ($error_message): ?>
            <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <?php if ($production): ?>
            <div class="mt-8 bg-white shadow rounded-lg">
                <form method="POST" action="" class="space-y-6 p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="production_date" class="block text-sm font-medium text-gray-700">Production Date</label>
                            <input type="date" id="production_date" name="production_date" 
                                value="<?php echo htmlspecialchars($production['production_date']); ?>" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="total_milk_yield" class="block text-sm font-medium text-gray-700">Total Milk Yield (Liters)</label>
                            <input type="number" step="0.01" min="0" id="total_milk_yield" name="total_milk_yield" 
                                value="<?php echo htmlspecialchars($production['total_milk_yield']); ?>" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end pt-5">
                        <button type="submit" 
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Record
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?> 