<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - {{ config('app.name', 'Laravel') }}</title>

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
    </style>

</head>
<body class="antialiased aurora-gradient">
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-12">
        
        <div class="mb-8">
            <a href="/" class="flex items-center text-3xl font-bold text-white tracking-wider">
                <svg class="w-9 h-9 mr-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span>{{ config('app.name', 'YourApp') }}</span>
            </a>
        </div>

        <div class="w-full max-w-md p-8 space-y-6 bg-gray-900/60 rounded-xl shadow-2xl backdrop-blur-md border border-gray-700">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-white">Login</h1>
                <p class="mt-2 text-gray-400">Welcome back, please enter your details.</p>
            </div>
            
            {{-- 1. BLOK UNTUK MENAMPILKAN NOTIFIKASI --}}
            @if (session('success'))
                <div class="bg-cyan-900/50 border border-cyan-500 text-cyan-200 px-4 py-3 rounded-lg text-center text-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf 
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-300">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full p-3 bg-gray-800 border @error('email') border-red-500 @else border-gray-700 @enderror rounded-md text-white placeholder-gray-500 
                                  focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition" 
                           placeholder="you@example.com" required>
                    
                    {{-- 2. MENAMPILKAN PESAN ERROR SPESIFIK UNTUK EMAIL --}}
                    @error('email')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-300">Password</label>
                    <input type="password" name="password" id="password" 
                           class="w-full p-3 bg-gray-800 border @error('password') border-red-500 @else border-gray-700 @enderror rounded-md text-white placeholder-gray-500 
                                  focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition" 
                           placeholder="••••••••" required>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="h-4 w-4 rounded border-gray-600 bg-gray-700 text-cyan-500 focus:ring-cyan-600">
                        <label for="remember" class="ml-2 block text-sm text-gray-400">Remember me</label>
                    </div>
                    <a href="#" class="text-sm font-medium text-cyan-400 hover:text-cyan-300">Forgot password?</a>
                </div>
                
                <button type="submit" 
                        class="w-full py-3 px-4 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-500/50 
                               text-white font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105 duration-300">
                    Login
                </button>
                
                <p class="text-sm text-center text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-cyan-400 hover:text-cyan-300">Register</a>
                </p>
            </form>
        </div>
        
        <footer class="mt-8 text-sm text-center text-gray-400">
            © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All Rights Reserved.
        </footer>
    </div>
</body>
</html>