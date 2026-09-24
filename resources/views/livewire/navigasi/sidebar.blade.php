<div>
    {{-- ======================================================== --}}
    {{-- 1. MOBILE OFF-CANVAS DRAWER (Hanya tampil di Layar Kecil)--}}
    {{-- ======================================================== --}}
    <div x-show="sidebarOpen" 
         x-cloak 
         class="relative z-50 lg:hidden" 
         role="dialog" 
         aria-modal="true">
        
        {{-- Backdrop Gelap --}}
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative mr-16 flex w-full max-w-xs flex-1">
                
                {{-- Tombol Tutup Silang di Luar Drawer --}}
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" @click="sidebarOpen = false" class="-m-2.5 p-2.5 text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                {{-- Konten Navigasi Drawer Mobile --}}
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-6 border-r border-slate-200">
                    
                    {{-- Brand Mobile --}}
                    <div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-100">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 flex items-center justify-center text-white shadow-sm shadow-emerald-700/20">
                            <i class="fas fa-landmark text-sm"></i>
                        </div>
                        <div>
                            <span class="font-extrabold text-base text-slate-900 tracking-tight">SITANAS</span>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 ml-1">Desa</span>
                        </div>
                    </div>

                    {{-- Daftar Menu Mobile --}}
                    @include('livewire.navigasi.partials.menu-links')

                    {{-- Profil & Logout Mobile --}}
                    @include('livewire.navigasi.partials.user-card')

                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- 2. DESKTOP STATIC SIDEBAR (Tertanam Kokoh di Sisi Kiri)   --}}
    {{-- ======================================================== --}}
    <aside class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-64 lg:flex-col bg-white border-r border-slate-200/90 shadow-2xs">
        
        {{-- Brand / Header Sidebar --}}
        <div class="flex h-16 shrink-0 items-center justify-between px-6 border-b border-slate-200/80">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 flex items-center justify-center text-white shadow-sm shadow-emerald-700/25 group-hover:scale-105 transition-transform">
                    <i class="fas fa-landmark text-sm"></i>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-extrabold text-base text-slate-900 tracking-tight group-hover:text-emerald-700 transition-colors">SITANAS</span>
                        <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 uppercase tracking-wider">v2.0</span>
                    </div>
                    <p class="text-[11px] text-slate-400 font-medium truncate max-w-[130px]" title="{{ $desa->nama_desa ?? 'Kalurahan' }}">
                        Kalurahan {{ $desa->nama_desa ?? 'Desa' }}
                    </p>
                </div>
            </a>
        </div>

        {{-- Navigasi Utama (Scrollable jika layar pendek) --}}
        <div class="flex flex-1 flex-col gap-y-6 overflow-y-auto px-4 py-6 custom-scrollbar">
            @include('livewire.navigasi.partials.menu-links')
        </div>

        {{-- Footer Sidebar: Profil User & Logout --}}
        <div class="shrink-0 p-4 border-t border-slate-200/80 bg-slate-50/50">
            @include('livewire.navigasi.partials.user-card')
        </div>

    </aside>
</div>
