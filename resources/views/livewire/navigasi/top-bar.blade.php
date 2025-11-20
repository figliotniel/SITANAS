<nav class="sticky top-0 z-50 w-full bg-slate-900 border-b border-slate-800 shadow-lg" x-data="{ mobileMenuOpen: false }">
    {{-- PERBAIKAN: Mengganti 'max-w-7xl mx-auto' menjadi 'w-full' agar presisi dari ujung ke ujung --}}
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- SISI KIRI (Logo & Menu Utama) --}}
            <div class="flex items-center">
                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" wire:navigate class="flex-shrink-0 flex items-center gap-3 group">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-blue-500/50 shadow-lg group-hover:scale-105 transition-transform">
                        <i class="fas fa-landmark text-sm"></i>
                    </div>
                    <span class="font-bold text-xl text-white tracking-tight">SITANAS</span>
                </a>

                {{-- Menu Desktop --}}
                <div class="hidden md:ml-10 md:flex md:items-center md:space-x-4">
                    <a href="{{ route('dashboard') }}" wire:navigate class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-blue-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>

                    <a href="{{ route('laporan') }}" wire:navigate class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('laporan') ? 'bg-slate-800 text-blue-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-file-invoice mr-2"></i>Laporan
                    </a>

                    @if(auth()->user()->role_id == 1)
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="group inline-flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('admin*') ? 'bg-slate-800 text-blue-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                <i class="fas fa-user-shield mr-2"></i>
                                <span>Admin</span>
                                <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-200" :class="{'rotate-180': open}"></i>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-cloak
                                 class="absolute left-0 mt-2 w-56 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 py-1 focus:outline-none z-50 overflow-hidden">
                                
                                <div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider bg-slate-50 border-b border-slate-100">
                                    Administrator
                                </div>
                                
                                <a href="{{ route('admin.users') }}" wire:navigate class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                    <i class="fas fa-users w-5 opacity-70"></i> Manajemen User
                                </a>
                                <a href="{{ route('admin.arsip') }}" wire:navigate class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                    <i class="fas fa-archive w-5 opacity-70"></i> Arsip Aset
                                </a>
                                <a href="{{ route('admin.log') }}" wire:navigate class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                    <i class="fas fa-history w-5 opacity-70"></i> Log Aktivitas
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- SISI KANAN (User Profile & Logout) --}}
            <div class="hidden md:flex items-center ml-6 pl-6 border-l border-slate-700">
                <div class="flex flex-col text-right mr-4">
                    <span class="text-sm font-semibold text-white">{{ auth()->user()->nama_lengkap }}</span>
                    <span class="text-xs text-slate-400">{{ auth()->user()->role->nama_role }}</span>
                </div>
                <button wire:click="logout" class="p-2 rounded-full bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-200" title="Logout">
                    <i class="fas fa-power-off"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- (Opsional) MENU MOBILE DROPDOWN (Perlu ditambahkan jika belum ada) --}}
    <div class="md:hidden bg-slate-900 border-b border-slate-800" id="mobile-menu" x-show="mobileMenuOpen" x-collapse>
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('dashboard') }}" wire:navigate class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-slate-800">Dashboard</a>
            <a href="{{ route('laporan') }}" wire:navigate class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">Laporan</a>
            {{-- Tambahkan menu admin mobile di sini jika perlu --}}
        </div>
    </div>
</nav>