<div class="fixed inset-0 z-[1001] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200">
            
            <button wire:click="$dispatch('user-updated')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="text-center sm:text-left">
                    <h3 class="text-xl font-bold leading-6 text-slate-900 mb-1" id="modal-title">
                        Edit Pengguna
                    </h3>
                    <p class="text-sm text-slate-500 mb-6">Ubah data profil atau reset password untuk <strong>{{ $nama_lengkap }}</strong>.</p>

                    <div class="space-y-6">
                        <div class="bg-slate-50 p-5 rounded-xl border border-slate-100">
                            <h4 class="text-sm font-bold text-slate-800 uppercase mb-4 flex items-center">
                                <i class="fas fa-id-card text-slate-400 mr-2"></i> Data Profil
                            </h4>
                            <form wire:submit="updateData" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                                    <input type="text" wire:model.live="nama_lengkap" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2">
                                    @error('nama_lengkap') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                                    <input type="email" wire:model.live="email" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2">
                                    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Peran</label>
                                    <select wire:model.live="role_id" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm transition">
                                    Simpan Perubahan Profil
                                </button>
                            </form>
                        </div>

                        <div class="bg-red-50 p-5 rounded-xl border border-red-100">
                            <h4 class="text-sm font-bold text-red-800 uppercase mb-4 flex items-center">
                                <i class="fas fa-key text-red-400 mr-2"></i> Reset Password
                            </h4>
                            
                            @if (session('success_pass'))
                                <div class="mb-3 p-2 bg-green-100 text-green-700 text-xs rounded border border-green-200">
                                    {{ session('success_pass') }}
                                </div>
                            @endif

                            <form wire:submit="updatePassword" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-red-700/70 uppercase mb-1">Password Baru (Min. 6 Karakter)</label>
                                    <input type="password" wire:model="new_password" class="block w-full rounded-lg border-red-200 bg-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2" placeholder="Password baru...">
                                    @error('new_password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-red-700/70 uppercase mb-1">Konfirmasi Password</label>
                                    <input type="password" wire:model="new_password_confirmation" class="block w-full rounded-lg border-red-200 bg-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2" placeholder="Ulangi password...">
                                </div>
                                <button type="submit" class="w-full py-2 px-4 bg-white border border-red-300 text-red-700 hover:bg-red-50 text-sm font-bold rounded-lg shadow-sm transition">
                                    Reset Password User Ini
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-200">
                <button wire:click="$dispatch('user-updated')" type="button" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>