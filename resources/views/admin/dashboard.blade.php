<x-layout theme="admin">
      <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
            
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-2xl p-6 sm:p-8 text-white shadow-md mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight mb-2">Welcome Back ! 🧸</h1>
                <p class="text-indigo-100 max-w-xl text-sm sm:text-base">
                    Your role is securely verified as <span class="font-bold underline text-white">{{Auth::user()->name}}</span>. Ready to manage the plushie workshop today?
                </p>
            </div>

            <div class="mb-10">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Workshop Shortcuts</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    
                    <a href="{{ route('admin.products.index') }}" 
                    class="flex items-center gap-4 p-5 bg-white border border-slate-200 rounded-xl hover:border-indigo-500 hover:shadow-md group transition">
                        <div class="w-12 h-12 bg-indigo-50 group-hover:bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-xl transition">
                            📦
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 group-hover:text-indigo-600 transition">View Full Inventory</h3>
                            <p class="text-xs text-slate-500">Browse, edit details, and restock variants</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.categories') }}" 
                    class="flex items-center gap-4 p-5 bg-white border border-slate-200 rounded-xl hover:border-violet-500 hover:shadow-md group transition">
                        <div class="w-12 h-12 bg-violet-50 group-hover:bg-violet-100 text-violet-600 rounded-lg flex items-center justify-center text-xl transition">
                            ➕
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 group-hover:text-violet-600 transition">Add New Catagory </h3>
                            <p class="text-xs text-slate-500">Inject a fresh new categories immediately</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.products.create') }}" 
                    class="flex items-center gap-4 p-5 bg-white border border-slate-200 rounded-xl hover:border-violet-500 hover:shadow-md group transition">
                        <div class="w-12 h-12 bg-violet-50 group-hover:bg-violet-100 text-violet-600 rounded-lg flex items-center justify-center text-xl transition">
                            ➕
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 group-hover:text-violet-600 transition">Add New Plushie</h3>
                            <p class="text-xs text-slate-500">Inject a fresh soft toy into categories immediately</p>
                        </div>
                    </a>
                </div>
            </div>

            <div>
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Live Workshop Metrics</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    
                    <div class="bg-white border border-slate-100 p-5 rounded-xl shadow-xs">
                        <span class="text-xs font-medium text-slate-400 block mb-1">Total Products</span>
                        <span class="text-2xl font-black text-slate-900">{{$totalProducts}}</span>
                    </div>

                    <div class="bg-white border border-slate-100 p-5 rounded-xl shadow-xs">
                        <span class="text-xs font-medium text-slate-400 block mb-1">Total Categories</span>
                        <span class="text-2xl font-black text-slate-900">{{$totalCategories}}</span>
                    </div>

                    <div class="bg-white border border-slate-100 p-5 rounded-xl shadow-xs">
                        <span class="text-xs font-medium text-slate-400 block mb-1">Total Sign in users</span>
                        <span class="text-2xl font-black text-slate-900">{{$totalUsers}}</span>
                    </div>

                </div>
            </div>

      </main>

</x-layout>