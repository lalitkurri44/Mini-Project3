<?php

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require('connection.php');
$username = $_SESSION['username'];

$query = "SELECT * FROM carrom_boys WHERE username='$username' LIMIT 1";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockWave - Modern Stock Trading Platform</title>
    <link rel="stylesheet" href="soham.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="script.js" defer></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .chart-container {
            height: 300px;
        }
        .stock-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
        .price-up {
            color: #10B981;
        }
        .price-down {
            color: #EF4444;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="stockApp()" class="min-h-screen">





       
            <!-- Navigation -->
            <nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-8 8" />
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900">StockWave</span>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="#" @click="activeTab = 'dashboard'" :class="{ 'border-indigo-500 text-gray-900': activeTab === 'dashboard' }" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Dashboard
                    </a>
                    <a href="#" @click="activeTab = 'market'" :class="{ 'border-indigo-500 text-gray-900': activeTab === 'market' }" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Market
                    </a>
                    <a href="#" @click="activeTab = 'portfolio'" :class="{ 'border-indigo-500 text-gray-900': activeTab === 'portfolio' }" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Portfolio
                    </a>
                    <a href="#" @click="activeTab = 'transactions'" :class="{ 'border-indigo-500 text-gray-900': activeTab === 'transactions' }" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Transactions
                    </a>
                    <a href="#" 
                    @click="activeTab = 'analysis'" 
                    :class="{ 'border-indigo-500 text-gray-900': activeTab === 'analysis' }" 
                    class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                    Analysis
                    </a>

                    <a href="#" 
                    @click="activeTab = 'AI'" 
                    :class="{ 'border-indigo-500 text-gray-900': activeTab === 'AI' }" 
                    class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                    AI
                    </a>

                </div>
            </div>
            
    <div class="flex items-center"> <div class="flex items-center ml-4 mr-2"> <div class="text-right"> <p class="text-sm font-medium text-gray-700">$<span x-text="portfolioValue.toFixed(2)"></span></p> <p class="text-xs text-gray-500">Portfolio Value</p> </div> <div class="ml-3 bg-green-100 text-green-800 rounded-full h-8 w-8 flex items-center justify-center text-sm font-bold"> <span x-text="userInitials"></span>  </div>
  





                    <div style="margin-left=20px" class="flex items-center space-x-3">
     <!-- User Photo -->
   


    

    <!-- User Name -->
    <span class="text-BLACK-700 font-LARGE ml-8">
        <?php echo htmlspecialchars($username); ?>
    </span>
</div>



                    <!-- ✅ PHP Logout Button -->
                    
<form action="logout.php" method="post" class="ml-4 flex items-center space-x-2">
   

    <!-- Logout button -->
    <button type="submit" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded p-2 transition duration-200">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
    </svg>
</button>

</form>

                    <!-- ✅ End Logout -->
                </div>
            </div>
        </div>
    </div>
</nav>


            <!-- Main Content -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Dashboard View -->
                <div x-show="activeTab === 'dashboard'">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Portfolio Summary -->
                        <div class="bg-white rounded-xl shadow-lg p-6 col-span-1 md:col-span-2">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Portfolio Overview</h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg">
                                    <p class="text-2xl font-bold text-blue-600">$<span x-text="portfolioValue.toFixed(2)"></span></p>
                                    <p class="text-sm text-blue-800">Total Value</p>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-green-50 to-emerald-100 rounded-lg">
                                    <p class="text-2xl font-bold text-green-600">$<span x-text="totalInvested.toFixed(2)"></span></p>
                                    <p class="text-sm text-green-800">Invested</p>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-pink-100 rounded-lg">
                                    <p class="text-2xl font-bold text-purple-600">$<span x-text="profitLoss.toFixed(2)"></span></p>
                                    <p :class="profitLoss >= 0 ? 'text-sm text-purple-800' : 'text-sm text-red-600'">Profit/Loss</p>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-orange-50 to-red-100 rounded-lg">
                                    <p class="text-2xl font-bold text-orange-600"><span x-text="portfolioReturn.toFixed(2)"></span>%</p>
                                    <p class="text-sm text-orange-800">Return</p>
                                </div>
                            </div>
                            <div class="mt-6 chart-container">
                                <canvas id="portfolioChart"></canvas>
                            </div>
                        </div>
                        <!-- Quick Actions -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                            <div class="space-y-3">
                                <button @click="showBuyModal = true" class="w-full btn-primary text-white py-3 px-4 rounded-lg font-medium hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Buy Stocks
                                </button>
                                <button @click="showSellModal = true" class="w-full bg-gradient-to-r from-red-500 to-pink-600 text-white py-3 px-4 rounded-lg font-medium hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    Sell Stocks
                                </button>

                                
                                <form action="new/index.php" method="post">
   <a href="../new/index.php" class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200 flex items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    Deposit Funds
</a>

</form>



                            </div>
                            <div class="mt-6">
                                <h3 class="text-md font-semibold text-gray-900 mb-3">Recent Activity</h3>
                                <div class="space-y-2 max-h-60 overflow-y-auto">
                                    <template x-for="activity in recentActivity" :key="activity.id">
                                        <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                                            <div :class="activity.type === 'buy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                                <span x-text="activity.type === 'buy' ? '+' : '-'"></span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900"><span x-text="activity.symbol"></span> <span x-text="activity.shares"></span> shares</p>
                                                <p class="text-xs text-gray-500"><span x-text="activity.time"></span></p>
                                            </div>
                                            <p :class="activity.type === 'buy' ? 'text-green-600' : 'text-red-600'" class="text-sm font-semibold">
                                                $<span x-text="activity.amount.toFixed(2)"></span>
                                            </p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Watchlist -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Your Watchlist</h2>
                            <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View All</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Symbol</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="stock in watchlist" :key="stock.symbol">
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900" x-text="stock.symbol"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500" x-text="stock.name"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="`$${stock.price.toFixed(2)}`"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div :class="stock.change >= 0 ? 'text-green-600' : 'text-red-600'" class="text-sm font-medium" x-text="`${stock.change >= 0 ? '+' : ''}${stock.changePercent.toFixed(2)}%`"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button @click="selectedStock = stock; showBuyModal = true" class="text-indigo-600 hover:text-indipo-900">Buy</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Market View -->
                <div x-show="activeTab === 'market'">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-2/3">
                            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold text-gray-900">Market Overview</h2>
                                    <div class="flex space-x-2">
                                        <button @click="marketView = 'all'" :class="marketView === 'all' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500'" class="px-3 py-1 rounded-full text-sm font-medium">All</button>
                                        <button @click="marketView = 'tech'" :class="marketView === 'tech' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500'" class="px-3 py-1 rounded-full text-sm font-medium">Tech</button>
                                        <button @click="marketView = 'finance'" :class="marketView === 'finance' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500'" class="px-3 py-1 rounded-full text-sm font-medium">Finance</button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <template x-for="stock in filteredMarketData" :key="stock.symbol">
                                        <div @click="selectedStock = stock; activeTab = 'market'; showStockDetail = true" class="bg-gray-50 rounded-lg p-4 cursor-pointer hover:shadow-md transition-all duration-200 stock-card">
                                            <div class="flex items-center justify-between mb-2">
                                                <h3 class="font-semibold text-gray-900" x-text="stock.symbol"></h3>
                                                <span :class="stock.change >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 py-1 rounded-full text-xs font-medium">
                                                    <span x-text="stock.change >= 0 ? '+' : ''"></span><span x-text="stock.changePercent.toFixed(2)"></span>%
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-2" x-text="stock.name"></p>
                                            <p class="text-lg font-bold text-gray-900" x-text="`$${stock.price.toFixed(2)}`"></p>
                                            <div class="mt-2 h-16">
                                                <canvas :id="'chart-' + stock.symbol" class="w-full h-full"></canvas>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="md:w-1/3">
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Market News</h2>
                                <div class="space-y-4">
                                    <template x-for="news in marketNews" :key="news.id">
                                        <div class="border-l-4 border-indigo-500 pl-4">
                                            <h3 class="text-sm font-medium text-gray-900" x-text="news.title"></h3>
                                            <p class="text-xs text-gray-500 mt-1" x-text="news.source"></p>
                                            <p class="text-xs text-gray-600 mt-1" x-text="news.summary"></p>
                                            <a href="#" class="text-xs text-indigo-600 hover:text-indigo-800 mt-2 inline-block">Read more</a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Portfolio View -->
                <div x-show="activeTab === 'portfolio'">
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Your Portfolio</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Symbol</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shares</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg. Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">P/L</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="holding in portfolio" :key="holding.symbol">
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900" x-text="holding.symbol"></div>
                                                <div class="text-sm text-gray-500" x-text="getStockName(holding.symbol)"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="holding.shares"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="`$${holding.avgPrice.toFixed(2)}`"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="`$${getCurrentPrice(holding.symbol).toFixed(2)}`"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900" x-text="`$${(holding.shares * getCurrentPrice(holding.symbol)).toFixed(2)}`"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div :class="getHoldingPL(holding) >= 0 ? 'text-green-600' : 'text-red-600'" class="text-sm font-medium">
                                                    $<span x-text="getHoldingPL(holding).toFixed(2)"></span> (<span x-text="getHoldingPLPercent(holding).toFixed(2)"></span>%)
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button @click="selectedStock = {symbol: holding.symbol, price: getCurrentPrice(holding.symbol), name: getStockName(holding.symbol)}; showSellModal = true" class="text-red-600 hover:text-red-800 mr-3">Sell</button>
                                                <button @click="selectedStock = {symbol: holding.symbol, price: getCurrentPrice(holding.symbol), name: getStockName(holding.symbol)}; showBuyModal = true" class="text-green-600 hover:text-green-800">Buy More</button>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr x-show="portfolio.length === 0">
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No holdings yet. Start investing!</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Portfolio Allocation Chart -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Portfolio Allocation</h3>
                            <div class="chart-container">
                                <canvas id="allocationChart"></canvas>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance History</h3>
                            <div class="chart-container">
                                <canvas id="performanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Transactions View -->
                <div x-show="activeTab === 'transactions'">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Transaction History</h2>
                            <div class="flex space-x-2">
                                <select x-model="transactionFilter" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                                    <option value="all">All Transactions</option>
                                    <option value="buy">Buys</option>
                                    <option value="sell">Sells</option>
                                </select>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Symbol</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shares</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="transaction in filteredTransactions" :key="transaction.id">
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="transaction.date"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900" x-text="transaction.symbol"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span :class="transaction.type === 'buy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 py-1 rounded-full text-xs font-medium" x-text="transaction.type"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="transaction.shares"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900" x-text="`$${transaction.price.toFixed(2)}`"></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div :class="transaction.type === 'buy' ? 'text-red-600' : 'text-green-600'" class="text-sm font-medium" x-text="`$${transaction.total.toFixed(2)}`"></div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr x-show="filteredTransactions.length === 0">
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No transactions found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Buy Stock Modal -->
            <div x-show="showBuyModal" class="fixed inset-0 overflow-y-auto z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showBuyModal" @click="showBuyModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div x-show="showBuyModal" @click.away="showBuyModal = false" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                Buy <span x-text="selectedStock?.symbol"></span> - <span x-text="selectedStock?.name"></span>
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Price</label>
                                    <div class="mt-1 text-lg font-semibold" x-text="`$${selectedStock?.price.toFixed(2) || 0}`"></div>
                                </div>
                                <div>
                                    <label for="shares" class="block text-sm font-medium text-gray-700">Number of Shares</label>
                                    <input type="number" id="shares" x-model.number="buyShares" min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Cost</label>
                                    <div class="mt-1 text-lg font-semibold" x-text="`$${(buyShares * (selectedStock?.price || 0)).toFixed(2)}`"></div>
                                </div>
                                <div x-show="insufficientFunds" class="bg-red-50 border-l-4 border-red-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.487 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700">Insufficient funds in your account.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" @click="executeBuy()" :disabled="buyShares <= 0 || insufficientFunds" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm" :class="{'opacity-50 cursor-not-allowed': buyShares <= 0 || insufficientFunds}">
                                Buy Shares
                            </button>
                            <button type="button" @click="showBuyModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sell Stock Modal -->
            <div x-show="showSellModal" class="fixed inset-0 overflow-y-auto z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showSellModal" @click="showSellModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div x-show="showSellModal" @click.away="showSellModal = false" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                Sell <span x-text="selectedStock?.symbol"></span> - <span x-text="selectedStock?.name"></span>
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Price</label>
                                    <div class="mt-1 text-lg font-semibold" x-text="`$${selectedStock?.price.toFixed(2) || 0}`"></div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Available Shares</label>
                                    <div class="mt-1 text-lg font-semibold" x-text="getAvailableShares(selectedStock?.symbol)"></div>
                                </div>
                                <div>
                                    <label for="sellShares" class="block text-sm font-medium text-gray-700">Number of Shares to Sell</label>
                                    <input type="number" id="sellShares" x-model.number="sellShares" :max="getAvailableShares(selectedStock?.symbol)" min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Proceeds</label>
                                    <div class="mt-1 text-lg font-semibold" x-text="`$${(sellShares * (selectedStock?.price || 0)).toFixed(2)}`"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" @click="executeSell()" :disabled="sellShares <= 0 || sellShares > getAvailableShares(selectedStock?.symbol)" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" :class="{'opacity-50 cursor-not-allowed': sellShares <= 0 || sellShares > getAvailableShares(selectedStock?.symbol)}">
                                Sell Shares
                            </button>
                            <button type="button" @click="showSellModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Toast Notification -->
            <div x-show="showToast" x-transition:enter="transform ease-out duration-300" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
                <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
                    <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 w-0 flex-1 pt-0.5">
                                    <p class="text-sm font-medium text-gray-900" x-text="toastMessage"></p>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex">
                                    <button @click="showToast = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Close</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Analysis View -->
<div x-show="activeTab === 'analysis'" class="dashboard">
      <h1 style="
    text-align: center; 
    margin: 30px 0; 
    font-size: 2.5rem; 
    font-weight: bold; 
    color: #007BFF; 
    text-shadow: 2px 2px 5px rgba(0,0,0,0.2); 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
">
    AI Analysis of Top Companies
</h1>


    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:20px; width:90%; max-width:1200px; margin-bottom:40px;">

        <div style="background:white; padding:30px 20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); text-align:center; transition:transform 0.3s, box-shadow 0.3s; cursor:pointer;"
             onclick="window.location.href='../Analyse/Apple.html';"
             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.1)';">
            <h2 style="margin:0; font-size:1.5rem; color:#007BFF;">Apple</h2>
        </div>

        <div style="background:white; padding:30px 20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); text-align:center; transition:transform 0.3s, box-shadow 0.3s; cursor:pointer;"
             onclick="window.location.href='../Analyse/Microsoft.html';"
             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.1)';">
            <h2 style="margin:0; font-size:1.5rem; color:#007BFF;">Microsoft</h2>
        </div>

        <div style="background:white; padding:30px 20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); text-align:center; transition:transform 0.3s, box-shadow 0.3s; cursor:pointer;"
             onclick="window.location.href='../Analyse/amazon.html';"
             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.1)';">
            <h2 style="margin:0; font-size:1.5rem; color:#007BFF;">Amazon</h2>
        </div>

        <div style="background:white; padding:30px 20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); text-align:center; transition:transform 0.3s, box-shadow 0.3s; cursor:pointer;"
             onclick="window.location.href='../Analyse/Google.html';"
             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.1)';">
            <h2 style="margin:0; font-size:1.5rem; color:#007BFF;">Google</h2>
        </div>
        
       

        <div style="background:white; padding:30px 20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); text-align:center; transition:transform 0.3s, box-shadow 0.3s; cursor:pointer;"
             onclick="window.location.href='../Analyse/tcs.html';"
             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.1)';">
            <h2 style="margin:0; font-size:1.5rem; color:#007BFF;">TCS</h2>
        </div>

        <div style="background:white; padding:30px 20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); text-align:center; transition:transform 0.3s, box-shadow 0.3s; cursor:pointer;"
             onclick="window.location.href='../Analyse/tesla.html';"
             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.1)';">
            <h2 style="margin:0; font-size:1.5rem; color:#007BFF;">Tesla</h2>
        </div>
    </div>
</div>

<div x-show="activeTab === 'AI'" 
    
 class="dashboard cursor-pointer"
     x-on:click="window.open('../Ai-chatbot/index.html','_blank')">
  
  <a href="../Ai-chatbot/index.html" target="_blank"
   style="
     display:flex;
     justify-content:center;
     align-items:center;
     height:250px;
     width:100%;
     max-width:600px;
     margin:50px auto;
     background: linear-gradient(135deg, #6c5ce7, #a29bfe);
     color:white;
     font-size:2rem;
     font-weight:800;
     text-decoration:none;
     border-radius:20px;
     box-shadow: 0 10px 30px rgba(0,0,0,0.3);
     transition: transform 0.3s ease, box-shadow 0.3s ease;
     text-align:center;
   "
   onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 15px 40px rgba(0,0,0,0.5)'"
   onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.3)'"
>
  🚀 WANT TO CHAT WITH AI? CLICK HERE!
</a>

</a>


</div>




</div>

<script>
    // Example data for each year
    const dataByYear = {
        2014: {
            totalSales: "1,794,875",
            totalMargin: "549,028",
            avgMargin: "30.50%",
            newCustomers: "92",
            repeatCustomers: "148"
        },
        2015: {
            totalSales: "2,010,450",
            totalMargin: "612,340",
            avgMargin: "30.45%",
            newCustomers: "110",
            repeatCustomers: "160"
        },
        2016: {
            totalSales: "2,345,670",
            totalMargin: "690,520",
            avgMargin: "29.45%",
            newCustomers: "135",
            repeatCustomers: "175"
        },
        2017: {
            totalSales: "2,789,230",
            totalMargin: "830,200",
            avgMargin: "29.75%",
            newCustomers: "150",
            repeatCustomers: "190"
        },
        2018: {
            totalSales: "3,120,000",
            totalMargin: "960,000",
            avgMargin: "30.77%",
            newCustomers: "170",
            repeatCustomers: "210"
        },
        2019: {
            totalSales: "3,540,900",
            totalMargin: "1,080,700",
            avgMargin: "30.52%",
            newCustomers: "185",
            repeatCustomers: "225"
        },
        2020: {
            totalSales: "3,000,000",
            totalMargin: "890,000",
            avgMargin: "29.67%",
            newCustomers: "160",
            repeatCustomers: "210"
        },
        2021: {
            totalSales: "3,600,000",
            totalMargin: "1,020,000",
            avgMargin: "28.33%",
            newCustomers: "190",
            repeatCustomers: "230"
        },
        2022: {
            totalSales: "4,100,000",
            totalMargin: "1,230,000",
            avgMargin: "30.00%",
            newCustomers: "210",
            repeatCustomers: "250"
        },
        2023: {
            totalSales: "4,700,000",
            totalMargin: "1,410,000",
            avgMargin: "30.00%",
            newCustomers: "230",
            repeatCustomers: "270"
        },
        2024: {
            totalSales: "5,200,000",
            totalMargin: "1,650,000",
            avgMargin: "31.73%",
            newCustomers: "260",
            repeatCustomers: "290"
        }
    };

    // When a year button is clicked
    document.querySelectorAll(".year").forEach(button => {
        button.addEventListener("click", function() {
            // Remove active from all
            document.querySelectorAll(".year").forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            const year = this.getAttribute("data-year");
            const stats = dataByYear[year];

            // Update stats section
            document.getElementById("totalSales").textContent = stats.totalSales;
            document.getElementById("totalMargin").textContent = stats.totalMargin;
            document.getElementById("avgMargin").textContent = stats.avgMargin;
            document.getElementById("newCustomers").textContent = stats.newCustomers;
            document.getElementById("repeatCustomers").textContent = stats.repeatCustomers;

            // TODO: Update charts for each year if you have chart data
        });
    });
</script>



        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            function stockApp() {
                return {
                    // Authentication state
                    isAuthenticated: false,
                    loginEmail: '',
                    loginPassword: '',
                    loginError: false,
                    loginErrorMessage: '',
                    showRegister: false,
                    registerName: '',
                    registerEmail: '',
                    registerPassword: '',
                    registerConfirm: '',
                    registerError: false,
                    registerErrorMessage: '',
                    rememberMe: false,
                    
                    // App state (only when authenticated)
                    activeTab: 'dashboard',
                    userInitials: 'JD',
                    portfolioValue: 25430.50,
                    totalInvested: 22000.00,
                    profitLoss: 3430.50,
                    portfolioReturn: 15.6,
                    // Portfolio holdings
                    portfolio: [
                        { symbol: 'AAPL', shares: 25, avgPrice: 150.25 },
                        { symbol: 'GOOGL', shares: 15, avgPrice: 2800.75 },
                        { symbol: 'MSFT', shares: 30, avgPrice: 310.50 },
                        { symbol: 'TSLA', shares: 10, avgPrice: 850.25 }
                    ],
                    // Watchlist
                    watchlist: [
                        { symbol: 'AAPL', name: 'Apple Inc.', price: 175.30, change: 2.15, changePercent: 1.24 },
                        { symbol: 'GOOGL', name: 'Alphabet Inc.', price: 2850.45, change: 15.20, changePercent: 0.54 },
                        { symbol: 'MSFT', name: 'Microsoft Corporation', price: 330.75, change: 5.25, changePercent: 1.61 },
                        { symbol: 'AMZN', name: 'Amazon.com Inc.', price: 3400.20, change: -25.80, changePercent: -0.75 },
                        { symbol: 'TSLA', name: 'Tesla Inc.', price: 875.40, change: 12.25, changePercent: 1.42 },
                        { symbol: 'NFLX', name: 'Netflix Inc.', price: 620.80, change: -8.40, changePercent: -1.33 }
                    ],
                    // Market data
                    marketData: [
                        { symbol: 'AAPL', name: 'Apple Inc.', price: 175.30, change: 2.15, changePercent: 1.24, sector: 'tech' },
                        { symbol: 'GOOGL', name: 'Alphabet Inc.', price: 2850.45, change: 15.20, changePercent: 0.54, sector: 'tech' },
                        { symbol: 'MSFT', name: 'Microsoft Corporation', price: 330.75, change: 5.25, changePercent: 1.61, sector: 'tech' },
                        { symbol: 'AMZN', name: 'Amazon.com Inc.', price: 3400.20, change: -25.80, changePercent: -0.75, sector: 'tech' },
                        { symbol: 'TSLA', name: 'Tesla Inc.', price: 875.40, change: 12.25, changePercent: 1.42, sector: 'auto' },
                        { symbol: 'NFLX', name: 'Netflix Inc.', price: 620.80, change: -8.40, changePercent: -1.33, sector: 'entertainment' },
                        { symbol: 'JPM', name: 'JPMorgan Chase & Co.', price: 165.40, change: 1.25, changePercent: 0.76, sector: 'finance' },
                        { symbol: 'V', name: 'Visa Inc.', price: 245.80, change: 3.15, changePercent: 1.30, sector: 'finance' },
                        { symbol: 'MA', name: 'Mastercard Incorporated', price: 380.25, change: 2.75, changePercent: 0.73, sector: 'finance' },
                        { symbol: 'DIS', name: 'The Walt Disney Company', price: 180.45, change: -2.30, changePercent: -1.26, sector: 'entertainment' },
                        { symbol: 'NKE', name: 'Nike, Inc.', price: 155.70, change: 0.85, changePercent: 0.55, sector: 'retail' },
                        { symbol: 'SBUX', name: 'Starbucks Corporation', price: 115.30, change: -1.20, changePercent: -1.03, sector: 'retail' }
                    ],
                    marketView: 'all',
                    get filteredMarketData() {
                        if (this.marketView === 'all') return this.marketData;
                        return this.marketData.filter(stock => stock.sector === this.marketView);
                    },
                    // Market news
                    marketNews: [
                        { id: 1, title: 'Tech Stocks Rally on Strong Earnings Reports', source: 'Financial Times', summary: 'Major tech companies report better than expected quarterly results, boosting market sentiment.' },
                        { id: 2, title: 'Federal Reserve Holds Interest Rates Steady', source: 'Wall Street Journal', summary: 'The Fed maintains current rates amid inflation concerns and strong economic data.' },
                        { id: 3, title: 'Renewable Energy Stocks Surge on New Climate Initiative', source: 'Bloomberg', summary: 'Government announces major investment in clean energy, benefiting solar and wind companies.' },
                        { id: 4, title: 'Retail Sales Exceed Expectations in June', source: 'CNBC', summary: 'Consumer spending shows resilience despite economic headwinds, boosting retail sector.' }
                    ],
                    // Transactions
                    transactions: [
                        { id: 1, date: '2023-06-15', symbol: 'AAPL', type: 'buy', shares: 10, price: 150.25, total: 1502.50 },
                        { id: 2, date: '2023-06-10', symbol: 'GOOGL', type: 'buy', shares: 5, price: 2800.75, total: 14003.75 },
                        { id: 3, date: '2023-06-05', symbol: 'MSFT', type: 'buy', shares: 15, price: 310.50, total: 4657.50 },
                        { id: 4, date: '2023-05-28', symbol: 'TSLA', type: 'buy', shares: 5, price: 850.25, total: 4251.25 },
                        { id: 5, date: '2023-05-20', symbol: 'AAPL', type: 'buy', shares: 15, price: 150.25, total: 2253.75 }
                    ],
                    transactionFilter: 'all',
                    get filteredTransactions() {
                        if (this.transactionFilter === 'all') return this.transactions;
                        return this.transactions.filter(t => t.type === this.transactionFilter);
                    },
                    // Recent activity
                    recentActivity: [
                        { id: 1, symbol: 'AAPL', shares: 10, amount: 1753.00, type: 'buy', time: '2 hours ago' },
                        { id: 2, symbol: 'TSLA', shares: 5, amount: 4377.00, type: 'buy', time: '5 hours ago' },
                        { id: 3, symbol: 'MSFT', shares: 10, amount: 3307.50, type: 'buy', time: '1 day ago' }
                    ],
                    // Modal states
                    showBuyModal: false,
                    showSellModal: false,
                    showStockDetail: false,
                    selectedStock: null,
                    buyShares: 1,
                    sellShares: 1,
                    // Toast notification
                    showToast: false,
                    toastMessage: '',
                    // Computed properties
                    get insufficientFunds() {
                        return this.buyShares * (this.selectedStock?.price || 0) > 50000; // Simulated account balance
                    },
                    getStockName(symbol) {
                        const stock = this.marketData.find(s => s.symbol === symbol);
                        return stock ? stock.name : symbol;
                    },
                    getCurrentPrice(symbol) {
                        const stock = this.marketData.find(s => s.symbol === symbol);
                        return stock ? stock.price : 0;
                    },
                    getHoldingPL(holding) {
                        const currentPrice = this.getCurrentPrice(holding.symbol);
                        return (currentPrice - holding.avgPrice) * holding.shares;
                    },
                    getHoldingPLPercent(holding) {
                        const currentPrice = this.getCurrentPrice(holding.symbol);
                        return ((currentPrice - holding.avgPrice) / holding.avgPrice) * 100;
                    },
                    getAvailableShares(symbol) {
                        const holding = this.portfolio.find(p => p.symbol === symbol);
                        return holding ? holding.shares : 0;
                    },
                    // Authentication methods
                    login() {
                        // Simple validation
                        if (!this.loginEmail || !this.loginPassword) {
                            this.loginError = true;
                            this.loginErrorMessage = 'Please enter both email and password';
                            return;
                        }
                        
                        // Simulate login process
                        this.loginError = false;
                        this.isAuthenticated = true;
                        // Extract initials from email for display
                        const name = this.loginEmail.split('@')[0];
                        this.userInitials = name.charAt(0).toUpperCase();
                        
                        // Show welcome toast
                        this.toastMessage = `Welcome back, ${name}!`;
                        this.showToast = true;
                        setTimeout(() => { this.showToast = false; }, 3000);
                    },
                    logout() {
                        this.isAuthenticated = false;
                        this.loginEmail = '';
                        this.loginPassword = '';
                        this.activeTab = 'dashboard';
                    },
                    register() {
                        this.registerError = false;
                        
                        // Validation
                        if (!this.registerName || !this.registerEmail || !this.registerPassword || !this.registerConfirm) {
                            this.registerError = true;
                            this.registerErrorMessage = 'Please fill in all fields';
                            return;
                        }
                        
                        if (this.registerPassword !== this.registerConfirm) {
                            this.registerError = true;
                            this.registerErrorMessage = 'Passwords do not match';
                            return;
                        }
                        
                        if (this.registerPassword.length < 6) {
                            this.registerError = true;
                            this.registerErrorMessage = 'Password must be at least 6 characters long';
                            return;
                        }
                        
                        // Simulate successful registration
                        this.showRegister = false;
                        this.loginEmail = this.registerEmail;
                        this.loginPassword = '';
                        this.registerName = '';
                        this.registerEmail = '';
                        this.registerPassword = '';
                        this.registerConfirm = '';
                        
                        // Show success message
                        this.toastMessage = 'Account created successfully! Please log in.';
                        this.showToast = true;
                        setTimeout(() => { this.showToast = false; }, 3000);
                    },
                    // Methods
                    executeBuy() {
                        if (this.buyShares <= 0 || this.insufficientFunds || !this.selectedStock) return;
                        // Add to portfolio or update existing holding
                        const existingHolding = this.portfolio.find(p => p.symbol === this.selectedStock.symbol);
                        if (existingHolding) {
                            const totalCost = (existingHolding.shares * existingHolding.avgPrice + this.buyShares * this.selectedStock.price);
                            const totalShares = existingHolding.shares + this.buyShares;
                            existingHolding.avgPrice = totalCost / totalShares;
                            existingHolding.shares = totalShares;
                        } else {
                            this.portfolio.push({
                                symbol: this.selectedStock.symbol,
                                shares: this.buyShares,
                                avgPrice: this.selectedStock.price
                            });
                        }
                        // Add transaction
                        this.transactions.unshift({
                            id: Date.now(),
                            date: new Date().toISOString().split('T')[0],
                            symbol: this.selectedStock.symbol,
                            type: 'buy',
                            shares: this.buyShares,
                            price: this.selectedStock.price,
                            total: this.buyShares * this.selectedStock.price
                        });
                        // Add to recent activity
                        this.recentActivity.unshift({
                            id: Date.now(),
                            symbol: this.selectedStock.symbol,
                            shares: this.buyShares,
                            amount: this.buyShares * this.selectedStock.price,
                            type: 'buy',
                            time: 'Just now'
                        });
                        // Update portfolio value
                        this.updatePortfolioMetrics();
                        // Show success message
                        this.toastMessage = `Successfully purchased ${this.buyShares} shares of ${this.selectedStock.symbol}!`;
                        this.showToast = true;
                        setTimeout(() => { this.showToast = false; }, 3000);
                        // Close modal
                        this.showBuyModal = false;
                        this.buyShares = 1;
                    },
                    executeSell() {
                        if (this.sellShares <= 0 || this.sellShares > this.getAvailableShares(this.selectedStock?.symbol) || !this.selectedStock) return;
                        // Find holding
                        const holding = this.portfolio.find(p => p.symbol === this.selectedStock.symbol);
                        if (holding) {
                            holding.shares -= this.sellShares;
                            // Remove from portfolio if no shares left
                            if (holding.shares === 0) {
                                this.portfolio = this.portfolio.filter(p => p.symbol !== this.selectedStock.symbol);
                            }
                        }
                        // Add transaction
                        this.transactions.unshift({
                            id: Date.now(),
                            date: new Date().toISOString().split('T')[0],
                            symbol: this.selectedStock.symbol,
                            type: 'sell',
                            shares: this.sellShares,
                            price: this.selectedStock.price,
                            total: this.sellShares * this.selectedStock.price
                        });
                        // Add to recent activity
                        this.recentActivity.unshift({
                            id: Date.now(),
                            symbol: this.selectedStock.symbol,
                            shares: this.sellShares,
                            amount: this.sellShares * this.selectedStock.price,
                            type: 'sell',
                            time: 'Just now'
                        });
                        // Update portfolio value
                        this.updatePortfolioMetrics();
                        // Show success message
                        this.toastMessage = `Successfully sold ${this.sellShares} shares of ${this.selectedStock.symbol}!`;
                        this.showToast = true;
                        setTimeout(() => { this.showToast = false; }, 3000);
                        // Close modal
                        this.showSellModal = false;
                        this.sellShares = 1;
                    },
                    updatePortfolioMetrics() {
                        // Calculate total invested
                        this.totalInvested = this.transactions
                            .filter(t => t.type === 'buy')
                            .reduce((sum, t) => sum + t.total, 0);
                        // Calculate current portfolio value
                        this.portfolioValue = this.portfolio.reduce((sum, holding) => {
                            const currentPrice = this.getCurrentPrice(holding.symbol);
                            return sum + (holding.shares * currentPrice);
                        }, 0);
                        // Calculate profit/loss
                        this.profitLoss = this.portfolioValue - this.totalInvested;
                        // Calculate return percentage
                        this.portfolioReturn = this.totalInvested > 0 ? (this.profitLoss / this.totalInvested) * 100 : 0;
                    }
                };
            }
            // Initialize charts when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                // Portfolio chart
                const portfolioCtx = document.getElementById('portfolioChart')?.getContext('2d');
                if (portfolioCtx) {
                    new Chart(portfolioCtx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                            datasets: [{
                                label: 'Portfolio Value',
                                data: [20000, 21500, 23000, 22000, 24000, 25430],
                                borderColor: '#667eea',
                                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    grid: {
                                        borderDash: [5, 5]
                                    }
                                },
                                x: {
                                    grid: {
                                        borderDash: [5, 5]
                                    }
                                }
                            }
                        }
                    });
                }
                // Allocation chart
                const allocationCtx = document.getElementById('allocationChart')?.getContext('2d');
                if (allocationCtx) {
                    new Chart(allocationCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Technology', 'Finance', 'Automotive', 'Entertainment', 'Retail'],
                            datasets: [{
                                data: [45, 25, 15, 10, 5],
                                backgroundColor: [
                                    '#667eea',
                                    '#764ba2',
                                    '#f093fb',
                                    '#f5576c',
                                    '#4facfe'
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right'
                                }
                            }
                        }
                    });
                }
                // Performance chart
                const performanceCtx = document.getElementById('performanceChart')?.getContext('2d');
                if (performanceCtx) {
                    new Chart(performanceCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                            datasets: [{
                                label: 'Portfolio Return',
                                data: [2.5, 3.8, -1.2, 4.5],
                                backgroundColor: function(context) {
                                    const value = context.dataset.data[context.dataIndex];
                                    return value >= 0 ? '#10B981' : '#EF4444';
                                },
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        borderDash: [5, 5]
                                    }
                                }
                            }
                        }
                    });
                }
                // Create mini charts for market overview
                document.querySelectorAll('[id^="chart-"]').forEach(canvas => {
                    const ctx = canvas.getContext('2d');
                    const symbol = canvas.id.replace('chart-', '');
                    const stock = window.Alpine.store('stockApp')?.marketData?.find(s => s.symbol === symbol);
                    if (stock) {
                        // Generate random price data for the last 30 days
                        const prices = [];
                        let price = stock.price * 0.95; // Start at 95% of current price
                        for (let i = 0; i < 30; i++) {
                            price += (Math.random() - 0.5) * 10; // Random fluctuation
                            prices.push(price);
                        }
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: Array(30).fill(''),
                                datasets: [{
                                    data: prices,
                                    borderColor: stock.change >= 0 ? '#10B981' : '#EF4444',
                                    backgroundColor: 'transparent',
                                    borderWidth: 2,
                                    pointRadius: 0,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        enabled: false
                                    }
                                },
                                scales: {
                                    x: {
                                        display: false
                                    },
                                    y: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }
                });
            });


        </script>
    </div>
</body>
</html>


```