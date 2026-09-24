<div class="flex items-center justify-between gap-3">
    
    {{-- Avatar & Nama Pengguna --}}
    <div class="flex items-center gap-2.5 min-w-0">
        <div class="relative flex-shrink-0">
            <div class="w-9 h-9 rounded-xl bg-emerald-700 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                {{ substr(auth()->user()->nama_lengkap ?? 'A', 0, 1) }}
            </div>
            <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
        </div>
        
        <div class="min-w-0 flex-1">
            <p class="text-xs font-bold text-slate-900 truncate leading-tight">
                {{ auth()->user()->nama_lengkap }}
            </p>
            <span class="inline-block text-[10px] font-medium text-emerald-800 bg-emerald-50 px-1.5 py-0.2 rounded border border-emerald-200/60 truncate max-w-[120px] mt-0.5">
                {{ auth()->user()->role->nama_role ?? 'Pengguna' }}
            </span>
        </div>
    </div>

    {{-- Tombol Logout --}}
    <button type="button" 
            wire:click="logout" 
            class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer flex-shrink-0"
            title="Keluar dari Sistem">
        <i class="fas fa-arrow-right-from-bracket text-sm"></i>
    </button>

</div>
