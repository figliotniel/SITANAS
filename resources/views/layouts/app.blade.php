<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITANAS - Sistem Informasi Tanah Kas Desa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        
        /* Custom scrollbar untuk navigasi */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @livewireStyles
</head>
<body class="h-full font-sans antialiased text-slate-900 selection:bg-emerald-500 selection:text-white bg-slate-100/80">

    @auth
        {{-- LAYOUT UNTUK PENGGUNA TERAUTENTIKASI (LEFT SIDEBAR ARCHITECTURE) --}}
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-100/80 flex">
            
            {{-- 1. LEFT SIDEBAR COMPONENT --}}
            <livewire:navigasi.sidebar />

            {{-- 2. MAIN CONTENT WRAPPER --}}
            <div class="flex-1 flex flex-col min-w-0 lg:pl-64 transition-all">
                
                {{-- Top Utility Bar Tipis (Header Pengawas & Toggle Mobile) --}}
                <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/80 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 transition-all">
                    
                    {{-- Sisi Kiri Header --}}
                    <div class="flex items-center gap-3">
                        {{-- Tombol Buka Sidebar Mobile (Hamburger) --}}
                        <button type="button" 
                                @click="sidebarOpen = true" 
                                class="lg:hidden p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition focus:outline-none cursor-pointer"
                                aria-label="Buka Navigasi">
                            <i class="fas fa-bars text-lg"></i>
                        </button>

                        {{-- Identitas Header di Mobile --}}
                        <div class="lg:hidden flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-emerald-700 text-white flex items-center justify-center text-xs">
                                <i class="fas fa-landmark"></i>
                            </div>
                            <span class="font-extrabold text-slate-900 text-sm tracking-tight">SITANAS</span>
                        </div>

                        {{-- Breadcrumb Ringkas di Layar Besar --}}
                        <div class="hidden lg:flex items-center gap-2 text-xs text-slate-500 font-medium">
                            <span class="text-slate-400">Portal Kalurahan</span>
                            <span>/</span>
                            <span class="text-emerald-800 font-bold">
                                {{ request()->is('tanah/baru') ? 'Tambah Aset' : (request()->is('tanah/*/edit') ? 'Edit Aset' : (request()->is('tanah/*') ? 'Detail Aset' : (request()->is('admin*') ? 'Administrasi' : (request()->is('laporan') ? 'Laporan' : 'Dashboard')))) }}
                            </span>
                        </div>
                    </div>

                    {{-- Sisi Kanan Header (Akses Cepat & Identitas Login) --}}
                    <div class="flex items-center gap-4">
                        
                        {{-- Tautan ke Portal Publik --}}
                        <a href="{{ route('publik') }}" 
                           wire:navigate 
                           class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-700 hover:text-emerald-800 bg-slate-100/80 hover:bg-emerald-50 border border-slate-200/80 transition shadow-2xs">
                            <i class="fas fa-globe text-emerald-600 text-xs"></i>
                            <span>Lihat Portal Warga</span>
                        </a>

                        <div class="h-5 w-px bg-slate-200 hidden sm:block"></div>

                        {{-- Profil Singkat di Header --}}
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-emerald-700 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                                {{ substr(auth()->user()->nama_lengkap ?? 'A', 0, 1) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-xs font-bold text-slate-900 leading-tight">{{ auth()->user()->nama_lengkap }}</p>
                                <span class="text-[10px] font-medium text-emerald-800">{{ auth()->user()->role->nama_role ?? 'Pengguna' }}</span>
                            </div>
                        </div>

                    </div>

                </header>

                {{-- Slot Konten Halaman --}}
                <main class="flex-1 w-full">
                    {{ $slot }}
                </main>

            </div>

        </div>
    @else
        {{-- LAYOUT UNTUK GUEST (LOGIN / PUBLIK) --}}
        <main class="flex-1 w-full min-h-screen">
            {{ $slot }}
        </main>
    @endauth

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    @livewireScripts
</body>
</html>