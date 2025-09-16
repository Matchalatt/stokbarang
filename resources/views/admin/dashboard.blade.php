<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        <nav class="container mx-auto px-4 lg:px-6 py-3">
            <div class="flex flex-wrap justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center text-xl font-bold text-white tracking-wider">
                    <svg class="w-7 h-7 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Admin Panel</span>
                </a>
                <div class="flex items-center">
                    {{-- 2. UBAH LINK MENJADI FORM LOGOUT --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 transition-colors duration-300">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto mt-8 mb-10 px-4">
        <div class="w-full p-6 sm:p-8 bg-gray-900/60 rounded-xl shadow-2xl backdrop-blur-md border border-gray-700">
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-6">Pending User Approvals</h1>

            @if (session('success'))
                <div class="bg-cyan-900/50 border border-cyan-500 text-cyan-200 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
    
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="border-b-2 border-gray-700">
                            <th class="px-5 py-3 bg-transparent text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Name</th>
                            <th class="px-5 py-3 bg-transparent text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                            <th class="px-5 py-3 bg-transparent text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Division</th>
                            <th class="px-5 py-3 bg-transparent text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingUsers as $user)
                            <tr class="border-b border-gray-800">
                                <td class="px-5 py-4 bg-transparent text-sm"><p class="text-white whitespace-no-wrap">{{ $user->name }}</p></td>
                                <td class="px-5 py-4 bg-transparent text-sm"><p class="text-white whitespace-no-wrap">{{ $user->email }}</p></td>
                                <td class="px-5 py-4 bg-transparent text-sm"><p class="text-white whitespace-no-wrap capitalize">{{ $user->role->name }}</p></td>
                                <td class="px-5 py-4 bg-transparent text-sm">
                                    <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 font-bold py-2 px-4 rounded-full transition-transform transform hover:scale-105 duration-300">
                                            Approve
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-5 bg-transparent text-sm text-center text-gray-500">
                                    No pending users for approval.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>