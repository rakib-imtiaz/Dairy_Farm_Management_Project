<?php
require_once 'includes/auth.php';

// Redirect to dashboard if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        // Attempt to verify login
        if (verifyLogin($username, $password)) {
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIM Dairy Farm - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
</head>
<body class="min-h-screen bg-gradient-to-b from-green-50 to-green-100 flex flex-col">
    <!-- Top Bar -->
    <div class="bg-green-800 text-white py-2 px-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-sm">
                Follow Us: 
                <a href="#" class="ml-2 hover:text-green-200">Facebook</a>
                <a href="#" class="ml-2 hover:text-green-200">Twitter</a>
                <a href="#" class="ml-2 hover:text-green-200">LinkedIn</a>
                <a href="#" class="ml-2 hover:text-green-200">Instagram</a>
            </div>
            <div class="text-sm">
                Call Us: +012 345 6789
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-green-800">MIM Dairy Farm</h1>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-green-800 hover:text-green-600">Home</a>
                    <a href="#" class="text-green-800 hover:text-green-600">About</a>
                    <a href="#" class="text-green-800 hover:text-green-600">Services</a>
                    <a href="#" class="text-green-800 hover:text-green-600">Products</a>
                    <a href="#" class="text-green-800 hover:text-green-600">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <!-- Logo/Header -->
            <div>
                <h1 class="text-center text-3xl font-extrabold text-green-800">
                    Welcome to MIM Dairy Farm
                </h1>
                <h2 class="mt-2 text-center text-xl text-gray-900">
                    Sign in to your account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Bangladesh's Premier Dairy Management System
                </p>
            </div>

            <!-- Demo Credentials -->
            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                <p class="text-sm text-green-800">
                    <strong>Demo Credentials:</strong><br>
                    Username: admin<br>
                    Password: admin123
                </p>
            </div>

            <!-- Error Message -->
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form class="mt-8 space-y-6" method="POST">
                <div class="rounded-md shadow-sm -space-y-px">
                    <!-- Username Field -->
                    <div>
                        <label for="username" class="sr-only">Username</label>
                        <input id="username" 
                               name="username" 
                               type="text" 
                               required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" 
                               placeholder="Username"
                               value="<?php echo htmlspecialchars($username ?? ''); ?>">
                    </div>
                    
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" 
                               placeholder="Password">
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <!-- Lock Icon -->
                            <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" 
                                 xmlns="http://www.w3.org/2000/svg" 
                                 viewBox="0 0 20 20" 
                                 fill="currentColor" 
                                 aria-hidden="true">
                                <path fill-rule="evenodd" 
                                      d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" 
                                      clip-rule="evenodd" />
                            </svg>
                        </span>
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-green-800">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-white">
                &copy; <?php echo date('Y'); ?> MIM Dairy Farm, Bangladesh. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
