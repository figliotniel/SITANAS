<div class="min-h-screen bg-slate-50">
    <div class="bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        <div class="w-full px-4 sm:px-6 lg:px-12 py-20 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-6">
                Transparansi Aset Desa<br>
                <span class="text-blue-400">Untuk Kemajuan Bersama</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-300">
                Sistem informasi terpadu untuk memetakan, memantau, dan mengelola tanah kas desa secara digital dan akuntabel.
            </p>
            
            <div class="mt-10 max-w-xl mx-auto">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-teal-400 rounded-xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative flex items-center bg-white rounded-xl shadow-2xl p-2">
                        <i class="fas fa-search text-slate-400 ml-3 text-lg"></i>
                        <input wire:model.live.debounce.300ms="search" type="text" class="w-full border-0 focus:ring-0 text-slate-700 text-lg placeholder-slate-400 h-12" placeholder="Cari lokasi atau penggunaan tanah...">
                        @auth
                            <a href="{{ route('dashboard') }}" class="hidden sm:block px-6 py-2 bg-slate-900 text-white font-semibold rounded-lg hover:bg-slate-800 transition ml-2">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:block px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition ml-2 whitespace-nowrap">
                                Login Admin
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-4 sm:px-6 lg:px-12 py-12">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Daftar Aset Tanah</h2>
                <p class="text-slate-500 mt-1">Menampilkan data aset yang telah terverifikasi.</p>
            </div>
            <div class="text-sm text-slate-500">
                Total Aset: <span class="font-bold text-slate-900">{{ $aset->total() }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 lg:gap-8">
            @forelse($aset as $item)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-lg transition-all duration-300 group flex flex-col h-full">
                    <div class="h-40 bg-slate-100 relative overflow-hidden rounded-t-2xl border-b border-slate-100">
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-200 text-slate-400">
                            <i class="fas fa-map-marked-alt text-4xl opacity-50"></i>
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-xs font-bold text-slate-700 shadow-sm border border-slate-100">
                                {{ $item->kode_barang ?? 'Tanpa Kode' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-slate-900 line-clamp-1 group-hover:text-blue-600 transition-colors">
                                {{ $item->lokasi }}
                            </h3>
                            <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $item->keterangan ?? 'Tidak ada keterangan khusus.' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                            <div class="bg-slate-50 p-3 rounded-lg">
                                <p class="text-slate-400 text-xs uppercase font-semibold">Luas</p>
                                <p class="font-mono font-bold text-slate-700">{{ number_format($item->luas, 0, ',', '.') }} m²</p>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-lg">
                                <p class="text-slate-400 text-xs uppercase font-semibold">Penggunaan</p>
                                <p class="font-medium text-slate-700 truncate">{{ $item->penggunaan ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-400">
                                Update: {{ $item->updated_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="bg-slate-50 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900">Tidak ada data ditemukan</h3>
                    <p class="text-slate-500">Coba kata kunci lain atau hubungi admin desa.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $aset->links() }}
        </div>
    </div>
    
    <footer class="bg-white border-t border-slate-200 mt-12 py-8">
        <div class="w-full px-4 text-center text-slate-400 text-sm">
            &copy; {{ date('Y') }} Sistem Informasi Tanah Desa. Dilindungi Undang-Undang.
        </div>
    </footer>
</div>