<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #666; text-align: center; margin-top: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #2563eb; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Permohonan Validasi Aset</h2>
        </div>
        <div class="content">
            <p>Yth. Bapak/Ibu Kepala Desa,</p>
            
            <p>
                @if($tipe == 'BARU')
                    Terdapat data aset tanah <strong>baru</strong> yang telah diinput oleh Admin dan menunggu persetujuan Anda.
                @else
                    Terdapat perubahan data pada aset tanah yang memerlukan <strong>validasi ulang</strong> dari Anda.
                @endif
            </p>

            <table style="width: 100%; text-align: left; margin-top: 10px;">
                <tr>
                    <th width="120">Kode Barang</th>
                    <td>: {{ $aset->kode_barang }}</td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>: {{ $aset->nama_barang }}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>: {{ $aset->lokasi }}</td>
                </tr>
                <tr>
                    <th>Diinput Oleh</th>
                    <td>: {{ $aset->diinput_oleh_user->nama_lengkap ?? 'Admin' }}</td>
                </tr>
            </table>

            <p>Silakan login ke aplikasi SITANAS untuk melakukan pemeriksaan dan validasi.</p>

            <a href="{{ route('login') }}" class="btn">Buka Aplikasi SITANAS</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Sistem Tanah Kas Desa (SITANAS).
        </div>
    </div>
</body>
</html>