<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

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
        
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>');
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.25em;
        }
    </style>

</head>
<body class="antialiased aurora-gradient">
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-12">
        
        <div class="mb-8">
            <a href="/" class="flex items-center text-3xl font-bold text-white tracking-wider">
                <svg class="w-9 h-9 mr-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span>{{ config('app.name', 'YourApp') }}</span>
            </a>
        </div>

        <div class="w-full max-w-md p-8 space-y-6 bg-gray-900/60 rounded-xl shadow-2xl backdrop-blur-md border border-gray-700">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-white">Create an Account</h1>
                <p class="mt-2 text-gray-400">Join us and start your journey.</p>
            </div>
            
            <form class="space-y-4" action="{{ route('register') }}" method="POST">
                @csrf 
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-300">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full p-3 bg-gray-800 border @error('name') border-red-500 @else border-gray-700 @enderror rounded-md text-white placeholder-gray-500 
                                  focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition" 
                           placeholder="John Doe" required>
                    @error('name') <p class="mt-2 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-300">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full p-3 bg-gray-800 border @error('email') border-red-500 @else border-gray-700 @enderror rounded-md text-white placeholder-gray-500 
                                  focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition" 
                           placeholder="you@example.com" required>
                    @error('email') <p class="mt-2 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="divisi" class="block mb-2 text-sm font-medium text-gray-300">Division</label>
                    <select id="divisi" name="divisi" class="w-full p-3 bg-gray-800 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                        <option value="gudang" @if(old('divisi') == 'gudang') selected @endif>Gudang</option>
                        <option value="sales" @if(old('divisi') == 'sales') selected @endif>Sales</option>
                        <option value="purchasing" @if(old('divisi') == 'purchasing') selected @endif>Purchasing</option>
                    </select>
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-300">Password</label>
                    <input type="password" name="password" id="password" 
                           class="w-full p-3 bg-gray-800 border @error('password') border-red-500 @else border-gray-700 @enderror rounded-md text-white placeholder-gray-500 
                                  focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition" 
                           placeholder="••••••••" required>
                    @error('password') <p class="mt-2 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-300">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full p-3 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500 
                                  focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition" 
                           placeholder="••••••••" required>
                </div>
                
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3 px-4 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-500/50 
                                   text-white font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105 duration-300">
                        Create Account
                    </button>
                </div>
                
                <p class="text-sm text-center text-gray-400">
                    Already have an account? 
                    {{-- 1. PERBAIKAN UTAMA PADA BAGIAN INI --}}
                    <a href="{{ route('login') }}" class="font-medium text-cyan-400 hover:text-cyan-300">Sign in here</a>
                </p>
            </form>
        </div>
        
        <footer class="mt-8 text-sm text-center text-gray-400">
            © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All Rights Reserved.
        </footer>
    </div>
</body>
</html>