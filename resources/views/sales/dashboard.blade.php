<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .aurora-gradient {
            background: linear-gradient(-45deg, #0d324d, #7f5a83, #2c5364, #1c2e4a);
            background-size: 400% 400%;
            animation: aurora 20s ease infinite;
        }
        @keyframes aurora {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="antialiased aurora-gradient text-gray-200">
    
    <header class="bg-gray-900/30 backdrop-blur-md sticky top-0 z-10 border-b border-gray-700">
        <nav class="container mx-auto px-4 lg:px-6 py-3 flex justify-between items-center">
            <a href="#" class="flex items-center text-xl font-bold text-white tracking-wider">
                <svg class="w-7 h-7 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                <span>Sales Panel</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5">
                    Logout
                </button>
            </form>
        </nav>
    </header>

    <main class="container mx-auto mt-8 mb-10 px-4">
        
        <div class="w-full p-6 sm:p-8 bg-gray-900/60 rounded-xl shadow-2xl backdrop-blur-md border border-gray-700 mb-8">
            <h2 class="text-2xl font-bold text-white mb-6">Create New Order Request</h2>
            <form action="{{ route('sales.order-requests.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                @csrf
                <div>
                    <label for="item_name" class="block mb-2 text-sm font-medium text-gray-300">Nama Barang</label>
                    <input type="text" name="item_name" class="w-full p-2.5 bg-gray-800 border border-gray-700 rounded-md" required>
                </div>
                <div>
                    <label for="current_stock" class="block mb-2 text-sm font-medium text-gray-300">Stok Saat Ini</label>
                    <input type="number" name="current_stock" class="w-full p-2.5 bg-gray-800 border border-gray-700 rounded-md" required>
                </div>
                <div>
                    <label for="required_stock" class="block mb-2 text-sm font-medium text-gray-300">Stok Dibutuhkan</label>
                    <input type="number" name="required_stock" class="w-full p-2.5 bg-gray-800 border border-gray-700 rounded-md" required>
                </div>
                <div>
                    <label for="order_quantity" class="block mb-2 text-sm font-medium text-gray-300">Jumlah Order</label>
                    <input type="number" name="order_quantity" class="w-full p-2.5 bg-gray-800 border border-gray-700 rounded-md" required>
                </div>
                <button type="submit" class="w-full py-2.5 px-4 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105">
                    Submit Request
                </button>
            </form>
        </div>

        <div class="w-full p-6 sm:p-8 bg-gray-900/60 rounded-xl shadow-2xl backdrop-blur-md border border-gray-700">
            <h2 class="text-2xl font-bold text-white mb-6">My Submitted Requests</h2>
            @if (session('success'))
                <div class="bg-cyan-900/50 border border-cyan-500 text-cyan-200 px-4 py-3 rounded-lg mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-700">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Item Name</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Order Quantity</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Request Date</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderRequests as $request)
                            <tr class="border-b border-gray-800">
                                <td class="px-5 py-4"><p class="text-white">{{ $request->item_name }}</p></td>
                                <td class="px-5 py-4"><p class="text-white">{{ $request->order_quantity }}</p></td>
                                <td class="px-5 py-4"><p class="text-gray-400">{{ $request->created_at->format('d M Y') }}</p></td>
                                <td class="px-5 py-4">
                                    @if($request->status == 'pending')
                                        <span class="px-3 py-1 text-xs font-semibold text-yellow-200 bg-yellow-900/50 rounded-full">Pending</span>
                                    @elseif($request->status == 'processed')
                                        <span class="px-3 py-1 text-xs font-semibold text-blue-200 bg-blue-900/50 rounded-full">Processed</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold text-green-200 bg-green-900/50 rounded-full">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-5 text-center text-gray-500">No requests submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>