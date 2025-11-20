<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Log Aktivitas Sistem</h1>
            <p class="text-sm text-slate-500 mt-1">Rekaman jejak digital seluruh aktivitas pengguna.</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-600 shadow-sm">
            <i class="fas fa-clock mr-2 text-blue-500"></i> Server Time: {{ date('d M Y H:i') }}
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Waktu & Tanggal</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4 text-center">Jenis Aksi</th>
                        <th class="px-6 py-4">Deskripsi Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-slate-100 text-slate-500 mr-3">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">{{ date('d M Y', strtotime($log->timestamp)) }}</p>
                                        <p class="text-xs text-slate-400 font-mono">{{ date('H:i:s', strtotime($log->timestamp)) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-xs font-bold mr-3 shadow-sm">
                                        {{ substr($log->user->nama_lengkap ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $log->user->nama_lengkap ?? 'User Terhapus' }}</p>
                                        <p class="text-xs text-slate-500">{{ $log->user->role->nama_role ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $badgeColor = match($log->aksi) {
                                        'HAPUS PERMANEN' => 'bg-red-100 text-red-700 border-red-200',
                                        'HAPUS (ARSIP)'  => 'bg-orange-100 text-orange-700 border-orange-200',
                                        'VALIDASI'       => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'TAMBAH'         => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'UPDATE'         => 'bg-amber-100 text-amber-700 border-amber-200',
                                        default          => 'bg-slate-100 text-slate-600 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border {{ $badgeColor }}">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-700 leading-relaxed">{{ $log->deskripsi }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <i class="fas fa-history text-4xl mb-3 opacity-30"></i>
                                <p>Belum ada aktivitas yang tercatat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $logs->links() }}
        </div>
    </div>
</div>