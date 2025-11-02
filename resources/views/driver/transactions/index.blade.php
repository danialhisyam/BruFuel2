<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - RoadRanger</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <header class="bg-blue-600 text-white p-4 shadow-md">
            <div class="container mx-auto flex items-center">
                <!-- ✅ Back to Menu -->
                <a href="{{ route('driver.dashboard') }}" class="mr-4">
                    <i data-feather="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-xl font-bold">Transactions</h1>
            </div>
        </header>

        <main class="flex-grow container mx-auto p-4">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Earnings Summary -->
                <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                    <h2 class="text-lg font-medium mb-2">Total Earnings</h2>
                    <p class="text-3xl font-bold mb-1">$1,245.50</p>
                    <p class="text-sm opacity-80">Last 30 days: $876.25</p>
                </div>

                <!-- Transaction List -->
                <div class="p-4">
                    <h3 class="font-medium text-gray-800 mb-3">Recent Transactions</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center p-3 border rounded-lg hover:shadow-md transition">
                            <div class="bg-green-100 p-2 rounded-full">
                                <i data-feather="dollar-sign" class="w-5 h-5 text-green-600"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <p class="font-medium text-gray-800">Trip #TRP-789123</p>
                                <p class="text-sm text-gray-500">Today, 11:20 AM</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-green-600">+$24.50</p>
                                <p class="text-xs text-gray-500">Completed</p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 border rounded-lg hover:shadow-md transition">
                            <div class="bg-blue-100 p-2 rounded-full">
                                <i data-feather="credit-card" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <p class="font-medium text-gray-800">Weekly Payout</p>
                                <p class="text-sm text-gray-500">Jul 15, 2023</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-blue-600">+$356.80</p>
                                <p class="text-xs text-gray-500">Bank Transfer</p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 border rounded-lg hover:shadow-md transition">
                            <div class="bg-yellow-100 p-2 rounded-full">
                                <i data-feather="alert-circle" class="w-5 h-5 text-yellow-600"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <p class="font-medium text-gray-800">Trip #TRP-456789</p>
                                <p class="text-sm text-gray-500">Jul 12, 2023</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-red-600">-$5.00</p>
                                <p class="text-xs text-gray-500">Cancellation fee</p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 border rounded-lg hover:shadow-md transition">
                            <div class="bg-green-100 p-2 rounded-full">
                                <i data-feather="dollar-sign" class="w-5 h-5 text-green-600"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <p class="font-medium text-gray-800">Trip #TRP-321654</p>
                                <p class="text-sm text-gray-500">Jul 10, 2023</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-green-600">+$18.75</p>
                                <p class="text-xs text-gray-500">Completed</p>
                            </div>
                        </div>

                        <div id="emptyTransactions" class="hidden text-center py-10">
                            <i data-feather="dollar-sign" class="w-12 h-12 mx-auto text-gray-300"></i>
                            <p class="mt-2 text-gray-500">No transactions found</p>
                        </div>
                    </div>
                </div>

                <!-- View All Button -->
                <div class="p-4 border-t">
                    <a href="{{ route('driver.dashboard') }}" 
                       class="block w-full py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition text-center">
                        ← Return to Menu
                    </a>
                </div>
            </div>
        </main>

        <footer class="bg-gray-800 text-white p-4 text-center text-sm">
            © 2025 BruFuel - Driver Portal
        </footer>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
