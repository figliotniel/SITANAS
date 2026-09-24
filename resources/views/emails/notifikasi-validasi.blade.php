<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #1e293b; background-color: #f8fafc; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .header { background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%); color: #ffffff; padding: 24px 28px; text-align: left; }
        .header h2 { margin: 0; font-size: 18px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { margin: 4px 0 0 0; font-size: 12px; color: #a7f3d0; }
        .content { padding: 28px; font-size: 13.5px; line-height: 1.6; color: #334155; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: bold; background: #d1fae5; color: #065f46; margin-bottom: 12px; }
        .table-data { width: 100%; border-collapse: collapse; margin: 16px 0; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; }
        .table-data td, .table-data th { padding: 10px 14px; font-size: 13px; text-align: left; }
        .table-data th { color: #64748b; font-weight: 600; width: 140px; border-bottom: 1px solid #edf2f7; }
        .table-data td { color: #0f172a; font-weight: 600; border-bottom: 1px solid #edf2f7; }
        .table-data tr:last-child th, .table-data tr:last-child td { border-bottom: none; }
        .btn-wrapper { text-align: center; margin: 24px 0 10px 0; }
        .btn { display: inline-block; padding: 12px 28px; background: #059669; color: #ffffff !important; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 13px; box-shadow: 0 4px 10px rgba(5, 150, 105, 0.25); }
        .footer { font-size: 11px; color: #94a3b8; text-align: center; padding: 16px 28px; background: #f8fafc; border-top: 1px solid #f1f5f9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>SITANAS • Permohonan Validasi Aset</h2>
            <p>Sistem Informasi Tanah Kas Desa</p>
        </div>
        <div class="content">
            <span class="badge">
                {{ $tipe == 'BARU' ? 'Aset Baru Masuk' : 'Pembaruan Data Aset' }}
            </span>

            <p style="margin-top: 0;">Yth. Bapak/Ibu <strong>Kepala Desa / Lurah</strong>,</p>
            
            <p>
                @if($tipe == 'BARU')
                    Terdapat berkas inventarisasi persil tanah kas desa <strong>baru</strong> yang telah selesai diinput oleh operator dan membutuhkan peninjauan serta tanda tangan digital/validasi Anda.
                @else
                    Terdapat perubahan/revisi data pada aset tanah kas desa yang memerlukan <strong>pemeriksaan ulang</strong> sebelum dicetak pada KIB A resmi.
                @endif
            </p>

            <table class="table-data">
                <tr>
                    <th>Kodefikasi Barang</th>
                    <td>{{ $aset->kode_barang ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nama / Jenis Barang</th>
                    <td>{{ $aset->nama_barang ?? 'Tanah Kas Desa' }}</td>
                </tr>
                <tr>
                    <th>Lokasi Persil</th>
                    <td>{{ $aset->lokasi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Luas Fisik</th>
                    <td>{{ number_format($aset->luas ?? 0, 0, ',', '.') }} m²</td>
                </tr>
                <tr>
                    <th>Petugas Penginput</th>
                    <td>{{ $aset->diinput_oleh_user->nama_lengkap ?? 'Operator Desa' }}</td>
                </tr>
            </table>

            <p>Silakan masuk ke portal SITANAS untuk menelaah dokumen legalitas dan memberikan persetujuan atau catatan revisi.</p>

            <div class="btn-wrapper">
                <a href="{{ route('aset.detail', ['aset' => $aset->id]) }}" class="btn">
                    Periksa & Validasi Persil Ini
                </a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Sistem Informasi Tanah Kas Desa (SITANAS). Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>
</html>