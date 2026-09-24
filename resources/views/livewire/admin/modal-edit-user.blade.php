<div class="fixed inset-0 z-[1001] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity" aria-hidden="true"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-emerald-100">
            
            {{-- Modal Header Beraksen Hijau Zamrud --}}
            <div class="bg-gradient-to-r from-emerald-900 via-emerald-850 to-teal-900 p-6 text-white relative">
                <button wire:click="$dispatch('user-updated')" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer">
                    <i class="fas fa-times text-sm"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-lg font-black shadow-xs">
                        {{ substr($nama_lengkap ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white" id="modal-title">
                            Edit Akun Pengguna
                        </h3>
                        <p class="text-xs text-emerald-200 mt-0.5">Kelola identitas profil atau reset kata sandi</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 space-y-6">
                {{-- SEKSI 1: DATA PROFIL --}}
                <div class="bg-emerald-50/30 p-5 rounded-2xl border border-emerald-100 space-y-4">
                    <h4 class="text-xs font-black text-emerald-950 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-id-card text-emerald-600"></i> Informasi Profil
                    </h4>
                    
                    <form wire:submit="updateData" class="space-y-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                            <input type="text" 
                                   wire:model.live="nama_lengkap" 
                                   class="block w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm focus:border-emerald-600 focus:ring-4 focus:ring-emerald-500/15 font-medium transition">
                            @error('nama_lengkap') <span class="text-xs text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email</label>
                            <input type="email" 
                                   wire:model.live="email" 
                                   class="block w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm focus:border-emerald-600 focus:ring-4 focus:ring-emerald-500/15 font-medium transition">
                            @error('email') <span class="text-xs text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Peran / Otoritas</label>
                            <select wire:model.live="role_id" class="block w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm focus:border-emerald-600 focus:ring-4 focus:ring-emerald-500/15 font-bold text-slate-800 transition cursor-pointer">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-700 hover:to-emerald-900 text-white text-xs font-black rounded-xl shadow-md shadow-emerald-700/20 transition active:scale-[0.98] cursor-pointer">
                            Simpan Perubahan Profil
                        </button>
                    </form>
                </div>

                {{-- SEKSI 2: RESET PASSWORD --}}
                <div class="bg-amber-50/40 p-5 rounded-2xl border border-amber-200/80 space-y-4">
                    <h4 class="text-xs font-black text-amber-950 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-key text-amber-600"></i> Reset Kata Sandi
                    </h4>
                    
                    @if (session('success_pass'))
                        <div class="p-3 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-xl border border-emerald-300">
                            {{ session('success_pass') }}
                        </div>
                    @endif

                    <form wire:submit="updatePassword" class="space-y-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Sandi Baru (Min. 6 Karakter)</label>
                            <input type="password" 
                                   wire:model="new_password" 
                                   class="block w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition" 
                                   placeholder="Ketik password baru...">
                            @error('new_password') <span class="text-xs text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ulangi Sandi Baru</label>
                            <input type="password" 
                                   wire:model="new_password_confirmation" 
                                   class="block w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition" 
                                   placeholder="Ulangi konfirmasi...">
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 bg-white border-2 border-amber-300 text-amber-900 hover:bg-amber-100 text-xs font-black rounded-xl shadow-xs transition active:scale-[0.98] cursor-pointer">
                            Reset Password User Ini
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="bg-slate-50 px-6 py-4 flex justify-end border-t border-slate-200">
                <button wire:click="$dispatch('user-updated')" type="button" class="px-5 py-2 rounded-xl bg-white border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-100 transition cursor-pointer">
                    Selesai & Tutup
                </button>
            </div>
        </div>
    </div>
</div>