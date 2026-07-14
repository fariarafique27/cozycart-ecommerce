<!DOCTYPE html>
<html lang="en" class="h-full bg-stone-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CozyCart - Premium Plushies 🧸</title>
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col min-h-full font-sans antialiased bg-stone-50">

    <nav class="bg-white border-b border-stone-100 sticky top-0 z-50 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex items-center gap-3">
                    @auth
                        <button onclick="toggleMobileSidebar()" class="md:hidden text-stone-600 hover:text-pink-600 p-1.5 hover:bg-stone-50 rounded-lg focus:outline-none cursor-pointer">
                            <span class="text-xl">☰</span>
                        </button>
                    @endauth

                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🧸</span>
                        <span class="text-xl font-bold bg-gradient-to-r from-pink-600 to-rose-500 bg-clip-text text-transparent">CozyCart</span>
                    </div>
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
                        <span class="text-sm font-medium text-stone-600 hidden sm:inline">
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

    <div class="flex flex-1">
        
        @auth
            <aside class="w-64 bg-white border-r border-stone-100 min-h-[calc(100vh-4rem)] sticky top-16 hidden md:flex flex-col justify-between p-6">
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest px-3 mb-3">Main Navigation</p>
                        <nav class="space-y-1">
                            <a href="{{ route('shop.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-stone-600 hover:text-pink-600 hover:bg-stone-50 rounded-xl transition">
                                <span>🛍️</span> Shop Catalog
                            </a>
                            <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-stone-600 hover:text-pink-600 hover:bg-stone-50 rounded-xl transition">
                                <span>🛒</span> View Cart
                            </a>
                        </nav>
                    </div>

                    @if(Auth::user()->role === 'admin' || request()->is('admin*'))
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest px-3 mb-3">Admin Panel</p>
                            <nav class="space-y-1">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-pink-50 text-pink-600 font-semibold' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>📊</span> Dashboard
                                </a>
                                <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.analytics') ? 'bg-pink-50 text-pink-600 font-semibold' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>📈</span> Analytics Stats
                                </a>
                                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-pink-50 text-pink-600 font-semibold' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>🧸</span> Manage Products
                                </a>
                                <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.categories') ? 'bg-pink-50 text-pink-600 font-semibold' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>🏷️</span> Categories
                                </a>
                            </nav>
                        </div>
                    @endif
                </div>

                <div class="text-xs text-stone-400 px-3">
                    Mode: <span class="text-pink-500 font-semibold">Development</span>
                </div>
            </aside>
        @endauth

        @auth
            <div id="mobile-sidebar" class="fixed inset-0 z-50 hidden md:hidden">
                <div onclick="toggleMobileSidebar()" class="fixed inset-0 bg-stone-900/40 backdrop-blur-xs"></div>
                
                <div class="fixed top-0 bottom-0 left-0 w-64 bg-white shadow-2xl flex flex-col justify-between p-6">
                    <div class="space-y-6">
                        <div class="flex justify-between items-center pb-2 border-b border-stone-50">
                            <span class="text-base font-bold text-stone-800">Menu</span>
                            <button onclick="toggleMobileSidebar()" class="text-stone-400 hover:text-stone-600 font-bold p-1">✕</button>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-3">Main Navigation</p>
                            <nav class="space-y-1">
                                <a href="{{ route('shop.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-stone-600 hover:text-pink-600 hover:bg-stone-50 rounded-xl transition">
                                    <span>🛍️</span> Shop Catalog
                                </a>
                                <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-stone-600 hover:text-pink-600 hover:bg-stone-50 rounded-xl transition">
                                    <span>🛒</span> View Cart
                                </a>
                            </nav>
                        </div>

                        @if(Auth::user()->role === 'admin' || request()->is('admin*'))
                            <div>
                                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-3">Admin Panel</p>
                                <nav class="space-y-1">
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-pink-50 text-pink-600 font-semibold' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                        <span>📊</span> Dashboard
                                    </a>
                                    <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.analytics') ? 'bg-pink-50 text-pink-600 font-semibold' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                        <span>📈</span> Analytics Stats
                                    </a>
                                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-pink-50 text-pink-600 font-semibold' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                        <span>🧸</span> Manage Products
                                    </a>
                                    <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.categories') ? 'bg-pink-50 text-pink-600 font-semibold' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                        <span>🏷️</span> Categories
                                    </a>
                                </nav>
                            </div>
                        @endif
                    </div>

                    <div class="text-xs text-stone-400">
                        Mode: <span class="text-pink-500 font-semibold">Development</span>
                    </div>
                </div>
            </div>
        @endauth

        <main class="flex-grow w-full bg-stone-50">
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" id="success-banner">
                    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-sm font-semibold flex justify-between items-center shadow-xs">
                        <div class="flex items-center gap-2">
                            <span>🎉</span>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="document.getElementById('success-banner').remove()" class="text-emerald-400 hover:text-emerald-600 transition cursor-pointer font-bold p-1">
                            ✕
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" id="error-banner">
                    <div class="p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl text-sm font-semibold flex justify-between items-center shadow-xs">
                        <div class="flex items-center gap-2">
                            <span>⚠️</span>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button onclick="document.getElementById('error-banner').remove()" class="text-rose-400 hover:text-rose-600 transition cursor-pointer font-bold p-1">
                            ✕
                        </button>
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8">
                {{ $slot }}  
            </div>
        </main>

    </div>

    <footer class="bg-white border-t border-stone-100 py-6 text-center text-sm text-stone-400 mt-auto">
        &copy; {{ date('Y') }} CozyCart. All soft toys reserved.
    </footer>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
            } else {
                sidebar.classList.add('hidden');
            }
        }
    </script>

</body>
</html>