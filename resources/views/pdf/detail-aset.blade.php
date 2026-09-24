<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detail Persil Aset - {{ $aset->kode_barang ?? 'Tanpa Kode' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 15mm 15mm 15mm;
        }
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 8.5pt; 
            color: #222;
            line-height: 1.35;
        }
        
        /* Kop Surat Resmi Kedinasan */
        .kop-surat {
            text-align: center;
            margin-bottom: 8px;
        }
        .kop-surat .instansi-tinggi {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .kop-surat .nama-desa {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 2px 0;
        }
        .kop-surat .alamat-kontak {
            font-size: 7.5pt;
            color: #444;
            margin: 0;
        }
        .garis-kop {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-top: 5px;
            margin-bottom: 14px;
        }

        .judul-halaman {
            text-align: center;
            margin-bottom: 15px;
        }
        .judul-halaman h2 {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .judul-halaman p {
            font-size: 8pt;
            color: #555;
            margin: 2px 0 0 0;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 12px; 
            page-break-inside: avoid;
        }
        th, td { 
            border: 1px solid #444; 
            padding: 5px 7px; 
            text-align: left; 
            vertical-align: top;
        }
        th { 
            background-color: #f1f5f3; 
            font-size: 8pt; 
            font-weight: bold;
            width: 25%;
            color: #111;
        }
        td {
            width: 25%;
        }

        h4 { 
            margin-top: 10px; 
            margin-bottom: 6px;
            font-size: 9pt; 
            font-weight: bold;
            text-transform: uppercase;
            color: #064e3b;
            border-bottom: 1px solid #064e3b;
            padding-bottom: 2px;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
        }
        .status-disetujui { background-color: #d1fae5; color: #065f46; }
        .status-diproses { background-color: #fef3c7; color: #92400e; }
        .status-ditolak { background-color: #fee2e2; color: #991b1b; }

        .text-right { text-align: right; }
        .font-mono { font-family: Courier, monospace; }

        .tanda-tangan-wrapper {
            margin-top: 20px;
            width: 100%;
            page-break-inside: avoid;
        }
        .ttd-kanan {
            float: right;
            width: 45%;
            text-align: center;
        }
        .clear { clear: both; }
    </style>
</head>
<body>

    {{-- KOP SURAT RESMI KEDINASAN --}}
    <div class="kop-surat">
        <p class="instansi-tinggi">
            PEMERINTAH KABUPATEN {{ strtoupper($desa?->kabupaten ?? 'BANTUL') }}
        </p>
        <p class="instansi-tinggi" style="font-size: 8.5pt; font-weight: normal;">
            KECAMATAN {{ strtoupper($desa?->kecamatan ?? 'KASIHAN') }}
        </p>
        <h2 class="nama-desa">
            PEMERINTAH KALURAHAN {{ strtoupper($desa?->nama_desa ?? 'NGESTIHARJO') }}
        </h2>
        <p class="alamat-kontak">
            {{ $desa?->alamat_kantor ?? 'Alamat Kantor Pemerintahan Desa' }}
            @if($desa?->telepon) | Telp: {{ $desa->telepon }} @endif
            @if($desa?->email) | Email: {{ $desa->email }} @endif
            @if($desa?->kode_pos) | Kode Pos: {{ $desa->kode_pos }} @endif
        </p>
    </div>
    
    <div class="garis-kop"></div>

    <div class="judul-halaman">
        <h2>LEMBAR DOKUMEN PERSIL TANAH KAS DESA</h2>
        <p>Kodefikasi Barang: <strong class="font-mono">{{ $aset->kode_barang ?? 'TANPA KODE' }}</strong> | Register NUP: {{ $aset->nup ?? '-' }}</p>
    </div>

    <h4>1. Informasi Identitas & Perolehan Aset</h4>
    <table>
        <tr>
            <th>Kode Barang</th>
            <td class="font-mono"><strong>{{ $aset->kode_barang ?? '-' }}</strong></td>
            <th>NUP (No. Register)</th>
            <td class="font-mono">{{ $aset->nup ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nama / Jenis Barang</th>
            <td><strong>{{ $aset->nama_barang ?? 'Tanah Kas Desa' }}</strong></td>
            <th>Tgl. Perolehan</th>
            <td>{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d-m-Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Asal Usul Perolehan</th>
            <td>{{ $aset->asal_perolehan ?? '-' }}</td>
            <th>Nilai Perolehan</th>
            <td class="font-mono"><strong>Rp {{ number_format($aset->harga_perolehan, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <th>Luas Fisik (m²)</th>
            <td class="font-mono"><strong>{{ number_format($aset->luas, 0, ',', '.') }} m²</strong></td>
            <th>Kondisi Fisik</th>
            <td>{{ $aset->kondisi ?? '-' }}</td>
        </tr>
    </table>

    <h4>2. Legalitas Kepemilikan & Peruntukan</h4>
    <table>
        <tr>
            <th>Status Hak Tanah</th>
            <td><strong>{{ $aset->status_sertifikat ?? '-' }}</strong></td>
            <th>Nomor Sertifikat</th>
            <td class="font-mono">{{ $aset->nomor_sertifikat ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jenis Bukti Hak</th>
            <td>{{ $aset->bukti_perolehan ?? '-' }}</td>
            <th>Peruntukan Lahan</th>
            <td>{{ $aset->penggunaan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Letak / Alamat Lokasi</th>
            <td colspan="3">{{ $aset->lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Titik Koordinat GPS</th>
            <td colspan="3" class="font-mono">{{ $aset->koordinat ?? '-' }}</td>
        </tr>
    </table>

    <h4>3. Batas Sempadan Wilayah</h4>
    <table>
        <tr>
            <th>Batas Utara</th>
            <td>{{ $aset->batas_utara ?? '-' }}</td>
            <th>Batas Timur</th>
            <td>{{ $aset->batas_timur ?? '-' }}</td>
        </tr>
        <tr>
            <th>Batas Selatan</th>
            <td>{{ $aset->batas_selatan ?? '-' }}</td>
            <th>Batas Barat</th>
            <td>{{ $aset->batas_barat ?? '-' }}</td>
        </tr>
    </table>
    
    <h4>4. Otoritas Pengesahan & Validasi</h4>
    <table>
        <tr>
            <th>Status Validasi</th>
            <td colspan="3">
                <span class="status-badge status-{{ strtolower($aset->status_validasi) }}">
                    {{ $aset->status_validasi }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Petugas Penginput</th>
            <td colspan="3">
                {{ $aset->diinput_oleh_user?->nama_lengkap ?? 'Admin Desa' }} 
                ({{ $aset->created_at ? $aset->created_at->format('d-m-Y H:i') : '-' }} WIB)
            </td>
        </tr>
        @if ($aset->divalidasi_oleh)
        <tr>
            <th>Divalidasi Oleh</th>
            <td colspan="3">
                <strong>{{ $aset->divalidasi_oleh_user?->nama_lengkap ?? '-' }}</strong> 
                pada tanggal {{ $aset->updated_at->format('d-m-Y H:i') }} WIB
            </td>
        </tr>
        @if($aset->catatan_validasi)
        <tr>
            <th>Catatan Validasi</th>
            <td colspan="3">{{ $aset->catatan_validasi }}</td>
        </tr>
        @endif
        @endif
        <tr>
            <th>Keterangan / Warkah</th>
            <td colspan="3">{{ $aset->keterangan ?? 'Tidak ada catatan tambahan.' }}</td>
        </tr>
    </table>

    {{-- TANDA TANGAN KEPALA DESA --}}
    <div class="tanda-tangan-wrapper">
        <div class="ttd-kanan">
            <p>{{ $desa?->kabupaten ?? 'Wilayah' }}, {{ now()->format('d F Y') }}<br>Mengetahui & Mengesahkan,<br>Lurah / Kepala Desa</p>
            <br><br><br><br>
            <p style="margin: 0;"><strong><u>{{ $desa?->nama_kepala_desa ?? '( .................................................... )' }}</u></strong></p>
            <p style="margin: 2px 0 0 0; font-size: 7.5pt; color: #555;">NIP / NRPDes: {{ $desa?->nip_kepala_desa ?? '-' }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <div style="margin-top: 15px; font-size: 7pt; text-align: left; color: #888;">
        <i>Dokumen resmi dicetak melalui Sistem Informasi Tanah Kas Desa (SITANAS) pada {{ date('d-m-Y H:i:s') }} WIB</i>
    </div>
</body>
</html>