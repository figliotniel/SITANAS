<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Aset Tanah Kas Desa</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 9pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 { margin: 0; }
        .header p { margin: 2px 0; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .badge { font-weight: bold; font-size: 8pt; }
        .status-disetujui { color: green; }
        .status-ditolak { color: red; }
        .status-diproses { color: orange; }

        .footer-signature {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN ASET TANAH KAS DESA</h2>
        <p>Pemerintah Desa [Nama Desa]</p>
        <p><small>Dicetak pada: {{ date('d-m-Y H:i') }}</small></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode / NUP</th>
                <th width="20%">Lokasi</th>
                <th width="10%">Luas (m²)</th>
                <th width="10%">Tahun</th>
                <th width="15%">Harga Perolehan</th>
                <th width="10%">Kondisi</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataAset as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item->kode_barang }}</strong><br>
                    <small>NUP: {{ $item->nup ?? '-' }}</small>
                </td>
                <td>{{ $item->lokasi }}</td>
                <td class="text-right">{{ number_format($item->luas, 0, ',', '.') }}</td>
                <td class="text-center">
                    {{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('Y') : '-' }}
                </td>
                <td class="text-right">
                    Rp{{ number_format($item->harga_perolehan, 0, ',', '.') }}
                </td>
                <td class="text-center">{{ $item->kondisi }}</td>
                <td class="text-center">
                    <span class="badge status-{{ strtolower($item->status_validasi) }}">
                        {{ $item->status_validasi }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Data tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <strong>Total Aset: {{ $dataAset->count() }} Item</strong> <br>
        <strong>Total Nilai Aset: Rp{{ number_format($dataAset->sum('harga_perolehan'), 0, ',', '.') }}</strong>
    </div>

    <div class="footer-signature">
        <div class="signature-box">
            <p>Mengetahui,<br>Kepala Desa</p>
            <br><br><br>
            <p>( .................................... )</p>
        </div>
    </div>

</body>
</html>