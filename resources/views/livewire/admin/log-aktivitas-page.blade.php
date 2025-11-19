<div>
    <div class="content-header">
        <h1>Log Aktivitas Sistem</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td style="white-space: nowrap;">
                                    {{ date('d M Y H:i', strtotime($log->timestamp)) }}
                                </td>
                                <td>
                                    <strong>{{ $log->user->nama_lengkap ?? 'User Terhapus' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $log->user->role->nama_role ?? '-' }}</small>
                                </td>
                                <td>
                                    <span class="badge 
                                        {{ $log->aksi == 'HAPUS PERMANEN' ? 'bg-danger' : 
                                          ($log->aksi == 'VALIDASI' ? 'bg-success' : 
                                          ($log->aksi == 'TAMBAH' ? 'bg-primary' : 'bg-secondary')) }}">
                                        {{ $log->aksi }}
                                    </span>
                                </td>
                                <td>{{ $log->deskripsi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada aktivitas tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>