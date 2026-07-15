<x-layout theme="admin">
    <div class="max-w-5xl mx-auto px-4 py-10">
        
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900">Toy Categories Panel 📁</h1>
            <p class="text-slate-500 text-sm">Create and manage the categories used to organize your plushies shop.</p>
        </div>

        <!-- Success Toast Alert -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <!-- Responsive Grid Layout: Stacks on mobile, 3 columns wide on screens past 768px (md) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Left Column: Add New Category Card (Takes 1 column) -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs h-fit">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Add New Category</h2>
                
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf <!-- 🔒 Essential token to prevent 419 Session Expired errors -->
                    
                    <div class="mb-4">
                        <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                            Category Name
                        </label>
                        <input type="text" name="name" id="name" placeholder="e.g., Giant Teddy Bears" 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-hidden focus:border-indigo-500 transition text-sm @error('name') border-red-500 @enderror"
                               value="{{ old('name') }}" required>
                        
                        @error('name')
                            <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-medium text-sm rounded-xl shadow-xs transition cursor-pointer">
                        Save Category
                    </button>
                </form>
            </div>

            <!-- Right Column: Live Categories Database List (Spans across 2 columns) -->
            <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Current Active Categories</h2>
                
                @if($categories->isEmpty())
                    <div class="text-center py-10 border border-dashed border-slate-200 rounded-xl">
                        <p class="text-3xl mb-2">🧸</p>
                        <p class="text-slate-400 text-sm italic">No categories created yet. Use the form on the left to add your first one!</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($categories as $category)
                            <div class="py-3.5 flex justify-between items-center group">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ $category->name }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        URL Slug: <code class="bg-slate-50 px-1.5 py-0.5 rounded text-indigo-600 font-mono text-xs">{{ $category->slug }}</code>
                                    </p>
                                </div>
                                <span class="text-xs font-semibold px-2.5 py-1 bg-slate-50 text-slate-500 rounded-lg border border-slate-100">
                                    ID: #{{ $category->id }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-layout>