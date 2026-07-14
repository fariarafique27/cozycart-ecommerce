<!DOCTYPE html>
<html lang="en" class="h-full bg-stone-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CozyCart - Premium Plushies 🧸</title>
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col min-h-full font-sans antialiased">

    <nav class="bg-white border-b border-stone-100 sticky top-0 z-50 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🧸</span>
                    <span class="text-xl font-bold bg-gradient-to-r from-pink-600 to-rose-500 bg-clip-text text-transparent">CozyCart</span>
                </div>

                <div class="flex items-center gap-4">
                    @guest
                        <a href="{{ url('/login') }}" 
                        class="text-sm font-semibold text-stone-600 hover:text-pink-600 transition">
                            Log In
                        </a>
                        <a href="{{ url('/register') }}" 
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 rounded-lg shadow-sm transition">
                            Sign Up
                        </a>
                    @endguest

                    @auth
                        <span class="text-sm font-medium text-stone-600">
                            Hello, <strong class="text-stone-900">{{ Auth::user()->name }}</strong>! 👋
                        </span>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 transition cursor-pointer">
                                Log Out
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full">
        {{ $slot }}  
    </main>

    <footer class="bg-white border-t border-stone-100 py-6 text-center text-sm text-stone-400">
        &copy; {{ date('Y') }} CozyCart. All soft toys reserved.
    </footer>

</body>
</html>