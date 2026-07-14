 <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition flex flex-col group">
    
    <div class="aspect-square bg-slate-100 overflow-hidden relative">
        @if($product->image_path)
            <img 
                src="{{ asset('storage/' . $product->image_path) }}" 
                alt="{{ $product->name }}" 
                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
            >
        @else
            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 animate-pulse">
                <svg class="w-16 h-16 text-slate-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2a3 3 0 0 0-3 3c0 .35.06.69.17 1H9a5 5 0 0 0-5 5c0 1.25.46 2.39 1.22 3.27C4.47 14.86 4 15.87 4 17a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3c0-1.13-.47-2.14-1.22-2.73.76-.88 1.22-2.02 1.22-3.27a5 5 0 0 0-5-5h-.17c.11-.31.17-.65.17-1a3 3 0 0 0-3-3zm-4 7a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm8 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm-4 4a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/>
                </svg>
                <span class="mt-2 text-xs font-semibold text-slate-400 tracking-wider">No Image Uploaded</span>
            </div>
        @endif
    </div>

    <div class="p-4 flex flex-col flex-grow">
        <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-1">
            {{ $product->category->name ?? 'Plushie' }}
        </span>
        <h3 class="font-bold text-slate-900 mb-1 text-base group-hover:text-indigo-600 transition">
            {{ $product->name }}
        </h3>
        <p class="text-slate-500 text-xs line-clamp-2 mb-4 flex-grow">
            {{ $product->description }}
        </p>
        
        <div class="flex items-center justify-between pt-2 border-t border-slate-50">
            <span class="text-lg font-black text-slate-950">${{ number_format($product->price, 2) }}</span>
            
            <a href="{{ route('shop.show', $product->id) }}" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition">
                View Details
            </a>
        </div>
    </div>
</div> 










