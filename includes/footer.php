<?php
$current_year = date('Y');
?>

<footer class="bg-green-800">
    <!-- Main footer content -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Column 1: About -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">MIM Dairy Farm</h3>
                <p class="text-gray-200 text-sm">
                    Leading dairy farm in Bangladesh, providing quality dairy products and livestock management solutions.
                </p>
            </div>

            <!-- Column 2: Quick Links -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/dashboard.php" class="text-gray-400 hover:text-white text-sm">Dashboard</a>
                    </li>
                    <li>
                        <a href="/modules/cows/" class="text-gray-400 hover:text-white text-sm">Cows</a>
                    </li>
                    <li>
                        <a href="/modules/milk/" class="text-gray-400 hover:text-white text-sm">Milk Production</a>
                    </li>
                    <li>
                        <a href="/modules/alerts/" class="text-gray-400 hover:text-white text-sm">Alerts</a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Contact -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="text-gray-200 text-sm">
                        <span class="block">Email: info@mimdairy.com</span>
                    </li>
                    <li class="text-gray-200 text-sm">
                        <span class="block">Phone: (880) 123-456789</span>
                    </li>
                    <li class="text-gray-200 text-sm">
                        <span class="block">Location: Dhaka, Bangladesh</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 pt-8 border-t border-green-700">
            <p class="text-center text-gray-200 text-sm">
                &copy; <?php echo date('Y'); ?> MIM Dairy Farm, Bangladesh. All rights reserved.
            </p>
        </div>
    </div>
</footer> 