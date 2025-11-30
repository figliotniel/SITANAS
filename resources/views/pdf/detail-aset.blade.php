<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detail Aset - {{ $aset->kode_barang ?? 'Tanpa Kode' }}</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 10pt; 
            color: #333;
        }
        
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 { 
            margin: 0; 
            font-size: 16pt; 
            text-transform: uppercase;
        }
        .header p { 
            margin: 5px 0 0; 
            font-size: 10pt; 
            font-weight: bold;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
            page-break-inside: avoid;
        }
        th, td { 
            border: 1px solid #444; 
            padding: 6px 8px; 
            text-align: left; 
            vertical-align: top;
        }
        th { 
            background-color: #e0e0e0; 
            font-size: 10pt; 
            font-weight: bold;
            width: 25%;
        }
        td {
            width: 25%;
        }

        h4 { 
            margin-top: 15px; 
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd; 
            padding-bottom: 5px; 
            font-size: 12pt; 
            color: #222;
        }

        .status-validasi { 
            font-weight: bold; 
            text-transform: uppercase;
        }
        .status-diproses { color: #d39e00; }
        .status-disetujui { color: #28a745; }
        .status-ditolak { color: #dc3545; }

        .text-right { text-align: right; }
        .colspan-3 { width: 75%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Detail Aset Tanah Kas Desa</h1>
        <p>Kode Barang: {{ $aset->kode_barang ?? '-' }}</p>
    </div>

    <h4>Informasi Utama</h4>
    <table>
        <tr>
            <th>Kode Barang</th>
            <td>{{ $aset->kode_barang ?? '-' }}</td>
            <th>NUP</th>
            <td>{{ $aset->nup ?? '-' }}</td>
        </tr>
        <tr>
            <th>Asal Perolehan</th>
            <td>{{ $aset->asal_perolehan ?? '-' }}</td>
            <th>Tgl. Perolehan</th>
            <td>{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d-m-Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Harga Perolehan</th>
            <td>Rp {{ number_format($aset->harga_perolehan, 0, ',', '.') }}</td>
            <th>Bukti Perolehan</th>
            <td>{{ $aset->bukti_perolehan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Luas (m²)</th>
            <td>{{ number_format($aset->luas, 0, ',', '.') }} m²</td>
            <th>Kondisi</th>
            <td>{{ $aset->kondisi ?? '-' }}</td>
        </tr>
    </table>

    <h4>Legalitas dan Lokasi</h4>
    <table>
        <tr>
            <th>Nomor Sertifikat</th>
            <td>{{ $aset->nomor_sertifikat ?? '-' }}</td>
            <th>Tanggal Sertifikat</th>
            <td>{{ $aset->tanggal_sertifikat ? \Carbon\Carbon::parse($aset->tanggal_sertifikat)->format('d-m-Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Status Sertifikat</th>
            <td>{{ $aset->status_sertifikat ?? '-' }}</td>
            <th>Penggunaan</th>
            <td>{{ $aset->penggunaan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td colspan="3">{{ $aset->lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Koordinat</th>
            <td colspan="3">{{ $aset->koordinat ?? '-' }}</td>
        </tr>
    </table>

    <h4>Batas-Batas Tanah</h4>
    <table>
        <tr>
            <th>Utara</th>
            <td>{{ $aset->batas_utara ?? '-' }}</td>
            <th>Timur</th>
            <td>{{ $aset->batas_timur ?? '-' }}</td>
        </tr>
        <tr>
            <th>Selatan</th>
            <td>{{ $aset->batas_selatan ?? '-' }}</td>
            <th>Barat</th>
            <td>{{ $aset->batas_barat ?? '-' }}</td>
        </tr>
    </table>
    
    <h4>Status dan Keterangan</h4>
    <table>
        <tr>
            <th>Status Validasi</th>
            <td colspan="3">
                <span class="status-validasi status-{{ strtolower($aset->status_validasi) }}">
                    {{ $aset->status_validasi }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Diinput Oleh</th>
            <td colspan="3">
                {{ $aset->diinput_oleh_user?->nama_lengkap ?? 'User Tidak Ditemukan' }}
            </td>
        </tr>
        
        @if ($aset->divalidasi_oleh)
        <tr>
            <th>Divalidasi Oleh</th>
            <td colspan="3">
                {{ $aset->divalidasi_oleh_user?->nama_lengkap ?? 'User Tidak Ditemukan' }} 
                <br>
                <small style="color: #666;">
                    pada tanggal {{ $aset->updated_at->format('d-m-Y H:i') }}
                </small>
            </td>
        </tr>
        <tr>
            <th>Catatan Validasi</th>
            <td colspan="3">{{ $aset->catatan_validasi ?? '-' }}</td>
        </tr>
        @endif
        
        <tr>
            <th>Keterangan</th>
            <td colspan="3">{{ $aset->keterangan ?? '-' }}</td>
        </tr>
    </table>
    
    <div style="margin-top: 30px; font-size: 8pt; text-align: right; color: #777;">
        <i>Dicetak pada: {{ date('d-m-Y H:i:s') }}</i>
    </div>
</body>
</html>