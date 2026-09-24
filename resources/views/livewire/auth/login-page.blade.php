<div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-12 bg-white selection:bg-emerald-500 selection:text-white">
    
    {{-- ======================================================== --}}
    {{-- PANEL KIRI: VISUAL AGRARIA & SHOWCASE PROFIL DESA       --}}
    {{-- (Tampil 7 Kolom di Desktop, Full Banner di Layar Sedang)  --}}
    {{-- ======================================================== --}}
    <div class="lg:col-span-7 xl:col-span-7 relative min-h-[380px] lg:min-h-screen flex flex-col justify-between p-8 sm:p-12 lg:p-16 text-white overflow-hidden bg-slate-900">
        
        {{-- Background Image Tanah / Lanskap Persawahan Desa Berkualitas Tinggi --}}
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 scale-105"
             style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1932&auto=format&fit=crop');">
        </div>

        {{-- Overlay Gradien Deep Emerald Green Multi-layer --}}
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/85 to-emerald-950/75"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-amber-500/15 via-transparent to-transparent"></div>

        {{-- Konten Atas: Identitas Kalurahan --}}
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold tracking-wide shadow-sm">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                <span>Pemerintah Kalurahan {{ $desa->nama_desa ?? 'Ngestiharjo' }} • {{ $desa->kabupaten ?? 'Kab. Bantul' }}</span>
            </div>
        </div>

        {{-- Konten Tengah: Headline & Value Proposition --}}
        <div class="relative z-10 my-auto py-8">
            <div class="inline-flex items-center gap-2 text-emerald-300 font-semibold text-xs sm:text-sm uppercase tracking-wider mb-3">
                <i class="fas fa-shield-halved text-amber-400"></i>
                <span>Sistem Informasi Tanah Kas Desa</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white max-w-xl">
                Digitalisasi Tata Kelola & Kepastian Hukum Aset Desa
            </h1>

            <p class="mt-4 text-emerald-100/85 text-sm sm:text-base leading-relaxed max-w-lg">
                Mendukung transparansi pencatatan KIB A, aspek legalitas sertifikasi, pencegahan konflik lahan, hingga validasi berjenjang oleh Kepala Desa secara akuntabel.
            </p>

            {{-- 3 Kartu Keunggulan / Fitur Terintegrasi --}}
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-2xl">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3.5 border border-white/15">
                    <div class="text-amber-400 text-lg mb-1.5">
                        <i class="fas fa-book-bookmark"></i>
                    </div>
                    <div class="text-xs font-bold text-white">Standar KIB A</div>
                    <div class="text-[11px] text-emerald-200/80 mt-0.5">Sesuai format resmi inventaris desa</div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3.5 border border-white/15">
                    <div class="text-emerald-300 text-lg mb-1.5">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="text-xs font-bold text-white">Tertib Legalitas</div>
                    <div class="text-[11px] text-emerald-200/80 mt-0.5">Pantau sertifikat & patok batas</div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3.5 border border-white/15">
                    <div class="text-teal-300 text-lg mb-1.5">
                        <i class="fas fa-signature"></i>
                    </div>
                    <div class="text-xs font-bold text-white">Validasi Kades</div>
                    <div class="text-[11px] text-emerald-200/80 mt-0.5">Audit trail & persetujuan berjenjang</div>
                </div>
            </div>
        </div>

        {{-- Konten Bawah: Footer Panel Visual --}}
        <div class="relative z-10 pt-4 border-t border-white/15 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 text-xs text-emerald-200/70">
            <span class="flex items-center gap-1.5">
                <i class="fas fa-server text-emerald-400"></i>
                <span>Database Terenkripsi & Pencadangan Otomatis</span>
            </span>
            <span class="font-mono text-[11px]">SITANAS v2.0 • Tim Biru</span>
        </div>

    </div>

    {{-- ======================================================== --}}
    {{-- PANEL KANAN: FORMULIR LOGIN APARATUR DESA                --}}
    {{-- (5 Kolom di Desktop, Nyaman, Bersih, Ergonomis)          --}}
    {{-- ======================================================== --}}
    <div class="lg:col-span-5 xl:col-span-5 bg-slate-50/60 flex flex-col justify-between p-6 sm:p-10 lg:p-12 xl:p-14 border-l border-slate-200/70">
        
        {{-- Bar Navigasi Mini di Kanan Atas --}}
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 flex items-center justify-center text-white shadow-sm shadow-emerald-700/20">
                    <i class="fas fa-landmark text-sm"></i>
                </div>
                <div>
                    <span class="font-extrabold text-base text-slate-900 tracking-tight">SITANAS</span>
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 ml-1">Desa</span>
                </div>
            </div>

            <a href="{{ route('publik') }}" 
               wire:navigate 
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/80 px-3 py-1.5 rounded-xl transition">
                <i class="fas fa-globe text-[11px]"></i>
                <span>Data Publik</span>
            </a>
        </div>

        {{-- Area Formulir Tengah --}}
        <div class="my-auto max-w-sm w-full mx-auto">
            
            {{-- Header Form --}}
            <div class="mb-7">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Masuk Akun
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1.5 leading-relaxed">
                    Silakan masukkan email dan kata sandi aparatur desa Anda untuk mengelola inventaris.
                </p>
            </div>

            {{-- Alert Error --}}
            @if (session('error'))
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-start gap-2.5 shadow-xs animate-in fade-in">
                    <i class="fas fa-circle-exclamation text-rose-500 mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1 font-medium leading-normal">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- Form Login --}}
            <form wire:submit="login" class="space-y-4">
                
                {{-- Field Email --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                        <input type="email" 
                               id="email" 
                               wire:model="email" 
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 text-sm placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 transition shadow-2xs"
                               placeholder="nama@desa.id" 
                               required 
                               autofocus>
                    </div>
                    @error('email') 
                        <p class="mt-1 text-xs text-rose-600 flex items-center gap-1">
                            <i class="fas fa-circle-xmark"></i> {{ $message }}
                        </p> 
                    @enderror
                </div>

                {{-- Field Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <input type="password" 
                               id="password" 
                               wire:model="password" 
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 text-sm placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 transition shadow-2xs"
                               placeholder="••••••••" 
                               required>
                    </div>
                    @error('password') 
                        <p class="mt-1 text-xs text-rose-600 flex items-center gap-1">
                            <i class="fas fa-circle-xmark"></i> {{ $message }}
                        </p> 
                    @enderror
                </div>

                {{-- Tombol Masuk --}}
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3 px-4 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 shadow-md shadow-emerald-700/20 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 transition-all duration-150 flex items-center justify-center gap-2 group cursor-pointer disabled:opacity-70"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove class="flex items-center gap-2">
                            <span>Masuk Aplikasi</span>
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                        </span>
                        <span wire:loading class="flex items-center gap-2">
                            <i class="fas fa-circle-notch fa-spin"></i>
                            <span>Memverifikasi Akun...</span>
                        </span>
                    </button>
                </div>

            </form>

            {{-- Bantuan Akses Operator --}}
            <div class="mt-6 p-3 rounded-xl bg-slate-100/80 border border-slate-200/70 text-[11px] text-slate-600 flex items-start gap-2.5">
                <i class="fas fa-info-circle text-emerald-600 mt-0.5 flex-shrink-0 text-xs"></i>
                <div class="leading-relaxed">
                    Belum memiliki akun aparatur? Hubungi <strong>Admin Kalurahan</strong> untuk penambahan akun operator atau verifikator.
                </div>
            </div>

        </div>

        {{-- Footer Sisi Kanan --}}
        <div class="mt-8 pt-4 border-t border-slate-200/60 text-center text-xs text-slate-400">
            <p>&copy; {{ date('Y') }} SITANAS • Standar SPBE & Tata Kelola Pertanahan</p>
        </div>

    </div>

</div>