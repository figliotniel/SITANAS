<nav class="flex flex-1 flex-col gap-y-6">
    
    {{-- GRUP 1: MENU UTAMA --}}
    <div>
        <div class="px-3 text-[10px] font-black uppercase tracking-wider text-emerald-800/70 mb-2 flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            <span>Menu Utama</span>
        </div>
        <ul role="list" class="space-y-1.5">
            
            {{-- Dashboard --}}
            <li>
                <a href="{{ route('dashboard') }}" 
                   wire:navigate 
                   class="group flex items-center gap-x-3 rounded-2xl px-3.5 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-700 to-emerald-800 text-white shadow-md shadow-emerald-900/20' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-900' }}">
                    <div class="w-7 h-7 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700' }}">
                        <i class="fas fa-chart-pie text-xs"></i>
                    </div>
                    <span>Dashboard Aset</span>
                </a>
            </li>

            {{-- Laporan --}}
            <li>
                <a href="{{ route('laporan') }}" 
                   wire:navigate 
                   class="group flex items-center gap-x-3 rounded-2xl px-3.5 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('laporan') ? 'bg-gradient-to-r from-emerald-700 to-emerald-800 text-white shadow-md shadow-emerald-900/20' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-900' }}">
                    <div class="w-7 h-7 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('laporan') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700' }}">
                        <i class="fas fa-file-invoice text-xs"></i>
                    </div>
                    <span>Laporan & Rekap</span>
                </a>
            </li>

            {{-- Portal Publik --}}
            <li>
                <a href="{{ route('publik') }}" 
                   wire:navigate 
                   class="group flex items-center gap-x-3 rounded-2xl px-3.5 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('publik') ? 'bg-gradient-to-r from-emerald-700 to-emerald-800 text-white shadow-md shadow-emerald-900/20' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-900' }}">
                    <div class="w-7 h-7 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('publik') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700' }}">
                        <i class="fas fa-globe text-xs"></i>
                    </div>
                    <span>Portal Publik</span>
                    <i class="fas fa-arrow-up-right-from-square text-[9px] text-slate-400 ml-auto group-hover:text-emerald-600"></i>
                </a>
            </li>

        </ul>
    </div>

    {{-- GRUP 2: INVENTARISASI KIB A --}}
    @if(auth()->user()->role_id == 1)
        <div>
            <div class="px-3 text-[10px] font-black uppercase tracking-wider text-emerald-800/70 mb-2 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Inventarisasi</span>
            </div>
            <ul role="list" class="space-y-1.5">
                <li>
                    <a href="{{ route('aset.tambah') }}" 
                       wire:navigate 
                       class="group flex items-center gap-x-3 rounded-2xl px-3.5 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('aset.tambah') ? 'bg-gradient-to-r from-emerald-700 to-emerald-800 text-white shadow-md shadow-emerald-900/20' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <div class="w-7 h-7 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('aset.tambah') ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-700 group-hover:bg-emerald-200' }}">
                            <i class="fas fa-plus text-xs"></i>
                        </div>
                        <span>Tambah Tanah Baru</span>
                    </a>
                </li>
            </ul>
        </div>
    @endif

    {{-- GRUP 3: ADMINISTRASI DESA (Hanya untuk Role 1 - Admin Desa) --}}
    @if(auth()->user()->role_id == 1)
        <div>
            <div class="px-3 text-[10px] font-black uppercase tracking-wider text-emerald-800/70 mb-2 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Administrasi Desa</span>
            </div>
            <ul role="list" class="space-y-1.5">
                
                {{-- Manajemen User --}}
                <li>
                    <a href="{{ route('admin.users') }}" 
                       wire:navigate 
                       class="group flex items-center gap-x-3 rounded-2xl px-3.5 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-emerald-700 to-emerald-800 text-white shadow-md shadow-emerald-900/20' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <div class="w-7 h-7 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('admin.users') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700' }}">
                            <i class="fas fa-users-gear text-xs"></i>
                        </div>
                        <span>Manajemen User</span>
                    </a>
                </li>

                {{-- Arsip Aset --}}
                <li>
                    <a href="{{ route('admin.arsip') }}" 
                       wire:navigate 
                       class="group flex items-center gap-x-3 rounded-2xl px-3.5 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('admin.arsip') ? 'bg-gradient-to-r from-emerald-700 to-emerald-800 text-white shadow-md shadow-emerald-900/20' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <div class="w-7 h-7 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('admin.arsip') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700' }}">
                            <i class="fas fa-box-archive text-xs"></i>
                        </div>
                        <span>Arsip Aset (Tong Sampah)</span>
                    </a>
                </li>

                {{-- Log Aktivitas --}}
                <li>
                    <a href="{{ route('admin.log') }}" 
                       wire:navigate 
                       class="group flex items-center gap-x-3 rounded-2xl px-3.5 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('admin.log') ? 'bg-gradient-to-r from-emerald-700 to-emerald-800 text-white shadow-md shadow-emerald-900/20' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <div class="w-7 h-7 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('admin.log') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700' }}">
                            <i class="fas fa-clock-rotate-left text-xs"></i>
                        </div>
                        <span>Log Aktivitas (Audit)</span>
                    </a>
                </li>

                {{-- Pengaturan Desa --}}
                <li>
                    <a href="{{ route('admin.pengaturan') }}" 
                       wire:navigate 
                       class="group flex items-center gap-x-3 rounded-2xl px-3.5 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('admin.pengaturan') ? 'bg-gradient-to-r from-emerald-700 to-emerald-800 text-white shadow-md shadow-emerald-900/20' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <div class="w-7 h-7 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('admin.pengaturan') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700' }}">
                            <i class="fas fa-sliders text-xs"></i>
                        </div>
                        <span>Pengaturan Desa</span>
                    </a>
                </li>

            </ul>
        </div>
    @endif

</nav>
