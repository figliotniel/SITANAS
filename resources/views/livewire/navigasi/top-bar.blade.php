<nav class="sticky top-0 z-50 w-full bg-slate-900 border-b border-slate-800 shadow-lg" x-data="{ mobileMenuOpen: false }">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex-shrink-0 flex items-center gap-3 group">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-blue-500/50 shadow-lg group-hover:scale-105 transition-transform">
                        <i class="fas fa-landmark text-sm"></i>
                    </div>
                    <span class="font-bold text-xl text-white tracking-tight">SITANAS</span>
                </a>

                <div class="hidden md:ml-10 md:flex md:items-center md:space-x-4">

                    @auth
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
                                <div x-show="open" x-cloak class="absolute left-0 mt-2 w-56 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 py-1 z-50 overflow-hidden">
                                    <a href="{{ route('admin.users') }}" wire:navigate class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50">Manajemen User</a>
                                    <a href="{{ route('admin.arsip') }}" wire:navigate class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50">Arsip Aset</a>
                                    <a href="{{ route('admin.log') }}" wire:navigate class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50">Log Aktivitas</a>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden md:flex items-center ml-6 pl-6 border-l border-slate-700">
                @auth
                    <div class="flex flex-col text-right mr-4">
                        <span class="text-sm font-semibold text-white">{{ auth()->user()->nama_lengkap }}</span>
                        <span class="text-xs text-slate-400">{{ auth()->user()->role->nama_role }}</span>
                    </div>
                    <button wire:click="logout" class="p-2 rounded-full bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all" title="Logout">
                        <i class="fas fa-power-off"></i>
                    </button>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </a>
                @endauth
            </div>

            <div class="-mr-2 flex md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none">
                    <span class="sr-only">Open main menu</span>
                    <i class="fas fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-xl" x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>
        </div>
    </div>

    <div class="md:hidden bg-slate-900 border-b border-slate-800" x-show="mobileMenuOpen" x-collapse x-cloak>
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            @auth
                <a href="{{ route('dashboard') }}" wire:navigate class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-slate-800">
                    <i class="fas fa-tachometer-alt w-6 text-center"></i> Dashboard
                </a>
                <a href="{{ route('laporan') }}" wire:navigate class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">
                    <i class="fas fa-file-invoice w-6 text-center"></i> Laporan
                </a>

                @if(auth()->user()->role_id == 1)
                    <div class="mt-2 pt-2 border-t border-slate-800">
                        <div class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Admin</div>
                        <a href="{{ route('admin.users') }}" wire:navigate class="block px-3 py-2 rounded-md text-base text-slate-300 hover:bg-slate-800">Manajemen User</a>
                        <a href="{{ route('admin.arsip') }}" wire:navigate class="block px-3 py-2 rounded-md text-base text-slate-300 hover:bg-slate-800">Arsip Aset</a>
                        <a href="{{ route('admin.log') }}" wire:navigate class="block px-3 py-2 rounded-md text-base text-slate-300 hover:bg-slate-800">Log Aktivitas</a>
                    </div>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-4 border-t border-slate-800">
            @auth
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                            {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ auth()->user()->nama_lengkap }}</div>
                        <div class="text-sm font-medium text-slate-400">{{ auth()->user()->email }}</div>
                    </div>
                    <button wire:click="logout" class="ml-auto bg-red-600 p-1 rounded-full text-white hover:bg-red-700">
                        <i class="fas fa-power-off h-6 w-6 flex items-center justify-center"></i>
                    </button>
                </div>
            @else
                <div class="px-5">
                    <a href="{{ route('login') }}" wire:navigate class="block w-full text-center px-4 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">
                        Login Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>