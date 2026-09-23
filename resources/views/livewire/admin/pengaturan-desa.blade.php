<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Pengaturan Desa</h1>
        <p class="text-slate-600">Lengkapi data identitas dan profil desa untuk digunakan pada dokumen resmi.</p>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="simpan" class="space-y-6">
        <!-- Data Wilayah -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Informasi Wilayah</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Desa *</label>
                    <input type="text" wire:model="nama_desa" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                    @error('nama_desa') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kode Desa (Kemendagri)</label>
                    <input type="text" wire:model="kode_desa" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kecamatan *</label>
                    <input type="text" wire:model="kecamatan" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                    @error('kecamatan') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kabupaten *</label>
                    <input type="text" wire:model="kabupaten" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                    @error('kabupaten') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Provinsi *</label>
                    <input type="text" wire:model="provinsi" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                    @error('provinsi') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kode Pos</label>
                    <input type="text" wire:model="kode_pos" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <!-- Kontak & Alamat -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Kontak & Alamat Kantor</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Lengkap Kantor Desa</label>
                    <textarea wire:model="alamat_kantor" rows="2" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Telepon</label>
                    <input type="text" wire:model="telepon" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" wire:model="email" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <!-- Pejabat Desa -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Pejabat Desa</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kepala Desa *</label>
                    <input type="text" wire:model="nama_kepala_desa" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                    <span class="text-xs text-slate-500">Akan dicetak di laporan KIB A</span>
                    @error('nama_kepala_desa') <span class="text-sm text-red-600 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">NIP / NRPDes Kepala Desa</label>
                    <input type="text" wire:model="nip_kepala_desa" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium transition shadow-sm">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
