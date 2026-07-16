@props(['theme' => 'shop']) {{-- 👈 Defaults to 'shop' if not specified --}}

<!DOCTYPE html>
<html lang="en" class="h-full {{ $theme === 'admin' ? 'bg-stone-100' : 'bg-stone-50' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CozyCart {{ $theme === 'admin' ? 'Admin 👑' : '- Premium Plushies 🧸' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col h-screen overflow-hidden font-sans antialiased text-stone-800">

    <nav class="{{ $theme === 'admin' ? 'bg-blue-900 text-white' : 'bg-white text-stone-800 border-b border-stone-100' }} h-16 flex items-center px-6 justify-between shadow-xs shrink-0 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            @if(!request()->is('/', 'login', 'register'))
                <button onclick="toggleDynamicSidebar()" class="md:hidden p-2 {{ $theme === 'admin' ? 'hover:bg-blue-800 text-white' : 'hover:bg-stone-50 text-stone-600' }} rounded-lg cursor-pointer focus:outline-none">
                    <span class="text-xl">☰</span>
                </button>
            @endif
            
            <div class="flex items-center gap-2">
                <span class="text-2xl">🧸</span>
                <span class="text-xl font-bold {{ $theme === 'admin' ? 'bg-gradient-to-r from-blue-400 to-indigo-300' : 'bg-gradient-to-r from-pink-600 to-rose-500' }} bg-clip-text text-transparent">
                    CozyCart {{ $theme === 'admin' ? 'Admin' : '' }}
                </span>
            </div>
        </div>
        
        <div class="flex items-center gap-4 text-sm">
            @guest
                <a href="{{ url('/login') }}" class="text-sm font-semibold text-stone-600 hover:text-pink-600 transition">Log In</a>
                <a href="{{ url('/register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 rounded-lg shadow-sm transition">Sign Up</a>
            @endguest

            @auth
                <span class="{{ $theme === 'admin' ? 'text-blue-200' : 'text-stone-600' }} hidden sm:inline">Hello, <strong>{{ Auth::user()->name }}</strong>! 👋</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="{{ $theme === 'admin' ? 'text-blue-300 hover:text-red-400' : 'text-red-500 hover:text-red-700' }} font-semibold cursor-pointer transition">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden relative">
        
        @if(!request()->is('/', 'login', 'register'))
            <aside id="dynamic-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-stone-200 h-full flex flex-col justify-between p-6 transform -translate-x-full md:translate-x-0 md:static md:h-auto transition-transform duration-200 ease-in-out shrink-0">
                <div class="space-y-6">
                    <div class="flex justify-between items-center md:hidden border-b border-stone-100 pb-3">
                        <span class="font-bold text-stone-700">Navigation</span>
                        <button onclick="toggleDynamicSidebar()" class="text-stone-400 hover:text-stone-600 font-bold p-1">✕</button>
                    </div>

                    @if($theme === 'admin' && Auth::check() && Auth::user()->role === 'admin')
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest px-3 mb-3">Management</p>
                            <nav class="space-y-1">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-stone-600 hover:text-blue-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>📊</span> Dashboard
                                </a>
                                <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('admin.analytics') ? 'bg-blue-50 text-blue-600' : 'text-stone-600 hover:text-blue-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>📈</span> Analytics Stats
                                </a>
                                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('admin.products.*') ? 'bg-blue-50 text-blue-600' : 'text-stone-600 hover:text-blue-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>🧸</span> Manage Products
                                </a>
                                <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('admin.categories') ? 'bg-blue-50 text-blue-600' : 'text-stone-600 hover:text-blue-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>🏷️</span> Categories
                                </a>
                            </nav>
                        </div>
                    @else
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest px-3 mb-3">Shop Menu</p>
                            <nav class="space-y-1">
                                <a href="{{ route('shop.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('shop.index') ? 'bg-pink-50 text-pink-600' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>🛍️</span> Shop Catalog
                                </a>
                                
                                <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('cart.index') ? 'bg-pink-50 text-pink-600' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                    <span>🛒</span> View Cart
                                </a>
                                
                                @auth
                                    <a href="{{ route('orders.index') }}" 
                                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('orders.index') ? 'bg-pink-50 text-pink-600' : 'text-stone-600 hover:text-pink-600 hover:bg-stone-50' }} rounded-xl transition">
                                        <span>📦</span> View Orders
                                    </a>
                                @else
                                    <button onclick="alert('Please log in to track and view your order history! 🔐')" 
                                            class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-semibold text-stone-400 hover:bg-stone-100 rounded-xl transition cursor-pointer text-left">
                                        <span class="flex items-center gap-3">
                                            <span>📦</span> View Orders
                                        </span>
                                        <span class="text-xs">🔒</span>
                                    </button>
                                @endauth
                            </nav>
                        </div>
                    @endif
                </div>

                <div class="text-xs text-stone-400 px-3">
                    @auth
                        Mode: <span class="{{ $theme === 'admin' ? 'text-blue-600' : 'text-pink-500' }} font-semibold uppercase">{{ $theme }}</span>
                    @else
                        Mode: <span class="text-amber-500 font-semibold uppercase">Guest</span>
                    @endauth
                </div>
            </aside>
        @endif

        @if(!request()->is('/', 'login', 'register'))
            <div id="sidebar-overlay" onclick="toggleDynamicSidebar()" class="fixed inset-0 bg-stone-900/30 backdrop-blur-xs z-30 hidden md:hidden"></div>
        @endif

        <main class="flex-1 overflow-y-auto p-4 sm:p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-sm font-semibold flex justify-between items-center shadow-xs" id="flash-banner-success">
                    <span>🎉 {{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-banner-success').remove()" class="text-emerald-400 hover:text-emerald-600 cursor-pointer font-bold">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl text-sm font-semibold flex justify-between items-center shadow-xs" id="flash-banner-error">
                    <span>⚠️ {{ session('error') }}</span>
                    <button onclick="document.getElementById('flash-banner-error').remove()" class="text-rose-400 hover:text-rose-600 cursor-pointer font-bold">✕</button>
                </div>
            @endif

            {{ $slot }}  
        </main>

    </div>

    <script>
        function toggleDynamicSidebar() {
            const sidebar = document.getElementById('dynamic-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (!sidebar) return; // Guard clause in case sidebar isn't rendered
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
</body>
</html>