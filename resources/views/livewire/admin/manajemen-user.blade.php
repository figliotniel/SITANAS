<div class="max-w-7xl mx-auto space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Pengguna</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola akun, hak akses, dan status pengguna aplikasi.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-6 md:p-8 sticky top-24">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Buat Akun Baru</h3>
                </div>

                @if (session('success_user'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        <p class="text-sm text-emerald-800 font-medium">{{ session('success_user') }}</p>
                    </div>
                @endif

                <form wire:submit="simpanUserBaru" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" wire:model="nama_lengkap" class="block w-full px-4 py-3 rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Nama Pegawai/Staff">
                        @error('nama_lengkap') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                        <input type="email" wire:model="email" class="block w-full px-4 py-3 rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="email@desa.id">
                        @error('email') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Peran (Role)</label>
                        <select wire:model="role_id" class="block w-full px-4 py-3 rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Pilih Akses --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Password</label>
                        <input type="password" wire:model="password" class="block w-full px-4 py-3 rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="••••••••">
                        @error('password') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Konfirmasi Password</label>
                        <input type="password" wire:model="password_confirmation" class="block w-full px-4 py-3 rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/30 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:-translate-y-1">
                        Buat Akun Pengguna
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Daftar Pengguna Terdaftar</h3>
                    <span class="bg-white border border-slate-200 px-3 py-1 rounded-lg text-xs font-bold text-slate-600">Total: {{ count($users) }}</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Identitas</th>
                                <th class="px-6 py-4">Peran</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-sm mr-3">
                                            {{ substr($user->nama_lengkap, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $user->nama_lengkap }}</div>
                                            <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800">
                                        {{ $user->role?->nama_role ?? 'Tanpa Role' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $user->status == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $user->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button wire:click="openEditModal({{ $user->id }})" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        @if($user->id != auth()->id())
                                            @if($user->status == 'aktif')
                                                <button 
                                                    wire:click="toggleStatus({{ $user->id }})" 
                                                    wire:confirm="Nonaktifkan akun {{ $user->nama_lengkap }}?"
                                                    class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" 
                                                    title="Nonaktifkan User">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button 
                                                    wire:click="toggleStatus({{ $user->id }})"
                                                    wire:confirm="Aktifkan kembali akun {{ $user->nama_lengkap }}?"
                                                    class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition" 
                                                    title="Aktifkan User">
                                                    <i class="fas fa-check-circle"></i>
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