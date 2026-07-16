<x-layout theme="admin">
    <div class="flex-grow max-w w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900">Toy Categories Panel 📁</h1>
            <p class="text-slate-500 text-sm">Create and manage the categories used to organize your plushies shop.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs h-fit">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Add New Category</h2>
                
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf 
                    
                    <div class="mb-4">
                        <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                            Category Name
                        </label>
                        <input type="text" name="name" id="name" placeholder="e.g., Giant Teddy Bears" 
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') || $errors->has('slug') ? 'border-red-500 focus:border-red-500' : 'border-slate-200 focus:border-indigo-500' }} transition text-sm"
                            value="{{ old('name') }}" required>
                        
                        @error('name')
                            <span class="text-xs text-red-500 mt-1.5 block font-semibold">⚠️ {{ $message }}</span>
                        @enderror

                        @error('slug')
                            <span class="text-xs text-red-500 mt-1.5 block font-semibold">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-medium text-sm rounded-xl shadow-xs transition cursor-pointer">
                        Save Category
                    </button>
                </form>
            </div>

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
                                    <div class="flex items-center gap-2">
                                        <p class="font-bold text-slate-800 text-sm">{{ $category->name }}</p>
                                        <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-50 text-slate-400 rounded-lg border border-slate-100">
                                            ID: #{{ $category->id }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        URL Slug: <code class="bg-slate-50 px-1.5 py-0.5 rounded text-indigo-600 font-mono text-xs">{{ $category->slug }}</code>
                                    </p>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <button onclick="openEditModal('{{ $category->id }}', '{{ addslashes($category->name) }}')" 
                                            class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition cursor-pointer"
                                            title="Edit Category">
                                        ⚙️
                                    </button>

                                    <button type="button" 
                                            onclick="openDeleteModal('{{ $category->id }}', '{{ addslashes($category->name) }}')" 
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition cursor-pointer" 
                                            title="Delete Category">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 backdrop-blur-xs p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-black text-slate-900">Edit Category 🛠️</h2>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 text-lg font-bold p-1 cursor-pointer">✕</button>
            </div>

            <form id="edit-category-form" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="edit-name-input" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        New Category Name
                    </label>
                    <input type="text" name="name" id="edit-name-input" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-hidden focus:border-indigo-500 transition text-sm">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeEditModal()" class="w-1/2 py-3 border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 transition cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" class="w-1/2 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md transition cursor-pointer">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 backdrop-blur-xs p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-100 text-center">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-rose-50 mb-6 border border-rose-100">
                <span class="text-2xl">⚠️</span>
            </div>

            <h2 class="text-xl font-black text-slate-900 mb-2">Delete Category?</h2>
            <p class="text-slate-500 text-sm mb-6 px-2">
                Are you sure you want to delete <strong id="delete-category-name" class="text-slate-800"></strong>? Any associated products will need to be reassigned.
            </p>

            <form id="delete-category-form" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                
                <button type="button" onclick="closeDeleteModal()" class="w-1/2 py-3 border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="w-1/2 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-md transition cursor-pointer">
                    Yes, Delete 🗑️
                </button>
            </form>
        </div>
    </div>

    <script>
        // --- Edit Modal Controls ---
        function openEditModal(id, name) {
            const modal = document.getElementById('edit-modal');
            const form = document.getElementById('edit-category-form');
            const nameInput = document.getElementById('edit-name-input');
            
            form.action = `/admin/categories/${id}`;
            nameInput.value = name;
            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        // --- Delete Confirmation Card Controls ---
        function openDeleteModal(id, name) {
            const modal = document.getElementById('delete-modal');
            const form = document.getElementById('delete-category-form');
            const nameSpan = document.getElementById('delete-category-name');
            
            form.action = `/admin/categories/${id}`;
            nameSpan.innerText = `"${name}"`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }
    </script>
</x-layout>