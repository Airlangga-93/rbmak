<div class="group bg-white rounded-[2rem] p-3 border border-gray-100 hover:shadow-2xl transition-all duration-500" data-aos="fade-up">
    <div class="relative overflow-hidden rounded-[1.5rem]">
        <img src="{{ asset('storage/' . $item->image) }}" class="w-full aspect-square object-cover transition-transform duration-700 group-hover:scale-110">
        <div class="absolute top-3 right-3">
            <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[9px] font-black uppercase text-[#2C3E50]">
                {{ $item->category ?? 'New' }}
            </span>
        </div>
    </div>
    <div class="p-4">
        <h3 class="font-bold text-[#2C3E50] line-clamp-1 group-hover:text-[#FF8C00] transition-colors uppercase text-sm tracking-wide">{{ $item->name }}</h3>
        <div class="mt-4 flex justify-between items-center">
            <div>
                <p class="text-[8px] text-gray-400 font-bold uppercase tracking-widest">Investasi</p>
                <p class="text-[#FF8C00] font-black">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('product.show', $item->id) }}" class="w-10 h-10 bg-[#F4F7FA] text-[#2C3E50] rounded-xl flex items-center justify-center hover:bg-[#2C3E50] hover:text-white transition-all">
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</div>
