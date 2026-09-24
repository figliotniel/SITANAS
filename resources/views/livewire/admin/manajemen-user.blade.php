<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    {{-- ========================================== --}}
    {{-- 1. HERO BANNER MANAJEMEN USER              --}}
    {{-- ========================================== --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 p-6 sm:p-7 text-white shadow-xl shadow-emerald-950/15 border border-emerald-700/50">
        <div class="absolute -right-8 -top-8 w-64 h-64 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-10 w-48 h-48 rounded-full bg-teal-300/15 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-emerald-200 backdrop-blur-md border border-white/20">
                    <i class="fas fa-users-gear text-emerald-300"></i>
                    <span>Administrasi Hak Akses Sistem</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Manajemen Pengguna & Otoritas
                </h1>
                <p class="text-sm text-emerald-100/90 font-medium max-w-2xl leading-relaxed">
                    Kelola akun operator desa, hak akses penginput data, verifikator Kades/Lurah, serta pengawasan status keaktifan user.
                </p>
            </div>
            
            <div class="shrink-0 flex items-center">
                <span class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-700/60 border border-emerald-500/40 text-emerald-100 text-xs font-bold shadow-xs">
                    <i class="fas fa-user-shield text-emerald-300 text-sm"></i>
                    <span>Terdaftar: {{ count($users) }} Akun</span>
                </span>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. GRID UTAMA: FORM INPUT & TABEL PENGGUNA --}}
    {{-- ========================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- SISI KIRI: FORM REGISTRASI USER (5 KOLOM) --}}
        <div class="lg:col-span-5">
            <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden sticky top-24">
                {{-- Header Kartu Beraksen Hijau --}}
                <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 text-white flex items-center justify-center font-bold shadow-xs">
                            <i class="fas fa-user-plus text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Buat Akun Pegawai Baru</h3>
                            <p class="text-[11px] text-emerald-800 font-medium">Tambahkan staf / petugas pengelola aset</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-7 space-y-5">
                    @if (session('success_user'))
                        <div class="p-4 bg-emerald-50 border-2 border-emerald-300 rounded-2xl flex items-start gap-3 shadow-xs animate-in fade-in">
                            <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-emerald-950">Berhasil Dibuat</h4>
                                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success_user') }}</p>
                            </div>
                        </div>
                    @endif

                    <form wire:submit="simpanUserBaru" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap & Gelar</label>
                            <input type="text" 
                                   wire:model="nama_lengkap" 
                                   class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-medium" 
                                   placeholder="Contoh: Budi Prasetyo, S.Kom">
                            @error('nama_lengkap') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email Resmi</label>
                            <input type="email" 
                                   wire:model="email" 
                                   class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-medium" 
                                   placeholder="pegawai@desa.id">
                            @error('email') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Peran / Otoritas (Role)</label>
                            <select wire:model="role_id" class="block w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition font-bold text-slate-800 cursor-pointer">
                                <option value="">-- Pilih Tingkatan Akses --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                                @endforeach
                            </select>
                            @error('role_id') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi (Password)</label>
                            <input type="password" 
                                   wire:model="password" 
                                   class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition" 
                                   placeholder="••••••••">
                            @error('password') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ulangi Konfirmasi Sandi</label>
                            <input type="password" 
                                   wire:model="password_confirmation" 
                                   class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:border-emerald-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 sm:text-sm transition" 
                                   placeholder="••••••••">
                        </div>

                        <div class="pt-2">
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 rounded-2xl font-black text-sm text-white bg-gradient-to-r from-emerald-600 via-emerald-700 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 shadow-lg shadow-emerald-700/25 transition-all active:scale-[0.98] disabled:opacity-60 cursor-pointer">
                                <span wire:loading.remove wire:target="simpanUserBaru" class="flex items-center gap-2">
                                    <i class="fas fa-user-plus text-emerald-200"></i>
                                    <span>Buat Akun Pegawai</span>
                                </span>
                                <span wire:loading wire:target="simpanUserBaru" class="flex items-center gap-2">
                                    <i class="fas fa-circle-notch fa-spin text-white"></i>
                                    <span>Mendaftarkan Akun...</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: DAFTAR PENGGUNA TERDAFTAR (7 KOLOM) --}}
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl shadow-sm border border-emerald-100/90 overflow-hidden flex flex-col">
                <div class="bg-gradient-to-r from-emerald-50 via-emerald-50/40 to-white px-6 py-4 border-b border-emerald-100 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-700 to-emerald-900 text-white flex items-center justify-center font-bold shadow-xs">
                            <i class="fas fa-users text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Daftar Pengguna Terdaftar</h3>
                            <p class="text-[11px] text-emerald-800 font-medium">Semua akun yang memiliki akses ke aplikasi</p>
                        </div>
                    </div>
                    <span class="bg-emerald-100/90 text-emerald-800 border border-emerald-300 px-3 py-1 rounded-xl text-xs font-black">
                        Total: {{ count($users) }}
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-emerald-900/[0.03] border-b border-emerald-100 text-xs uppercase font-black text-emerald-950">
                            <tr>
                                <th class="px-6 py-4">Identitas Pegawai</th>
                                <th class="px-6 py-4">Peran (Role)</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-800 text-white flex items-center justify-center font-black text-sm mr-3 shadow-xs">
                                            {{ substr($user->nama_lengkap, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900">{{ $user->nama_lengkap }}</div>
                                            <div class="text-xs text-slate-400 font-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $user->role?->nama_role ?? 'Tanpa Role' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black {{ $user->status == 'aktif' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-rose-100 text-rose-800 border border-rose-300' }} uppercase">
                                        {{ $user->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-1.5">
                                        <button wire:click="openEditModal({{ $user->id }})" 
                                                class="w-8 h-8 flex items-center justify-center rounded-xl bg-amber-50 border border-amber-200 text-amber-700 hover:bg-amber-600 hover:text-white transition-all shadow-2xs cursor-pointer" 
                                                title="Edit Profil & Password">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>

                                        @if($user->id != auth()->id())
                                            @if($user->status == 'aktif')
                                                <button 
                                                    wire:click="toggleStatus({{ $user->id }})" 
                                                    wire:confirm="Nonaktifkan akun {{ $user->nama_lengkap }}?"
                                                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-600 hover:text-white transition-all shadow-2xs cursor-pointer" 
                                                    title="Nonaktifkan User">
                                                    <i class="fas fa-ban text-xs"></i>
                                                </button>
                                            @else
                                                <button 
                                                    wire:click="toggleStatus({{ $user->id }})"
                                                    wire:confirm="Aktifkan kembali akun {{ $user->nama_lengkap }}?"
                                                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 hover:bg-emerald-600 hover:text-white transition-all shadow-2xs cursor-pointer" 
                                                    title="Aktifkan User">
                                                    <i class="fas fa-check-circle text-xs"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($showEditModal && $editingUserId)
        <livewire:admin.modal-edit-user :userId="$editingUserId" :key="$editingUserId" />
    @endif
</div>