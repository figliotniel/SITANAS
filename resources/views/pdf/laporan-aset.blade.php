<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan KIB A - Tanah Kas Desa {{ $desa?->nama_desa ?? '' }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm 15mm 15mm 15mm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            color: #111;
            line-height: 1.3;
        }
        
        /* Kop Surat Resmi Kedinasan */
        .kop-surat {
            text-align: center;
            margin-bottom: 10px;
        }
        .kop-surat .instansi-tinggi {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .kop-surat .nama-desa {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
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
            margin-top: 6px;
            margin-bottom: 12px;
        }

        /* Judul Dokumen */
        .judul-dokumen {
            text-align: center;
            margin-bottom: 12px;
        }
        .judul-dokumen h3 {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .judul-dokumen p {
            font-size: 8pt;
            margin: 2px 0 0 0;
            color: #555;
        }
        
        /* Tabel KIB A */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid #333;
            padding: 4px 5px;
            vertical-align: middle;
        }
        th {
            background-color: #e8f0eb;
            text-align: center;
            font-weight: bold;
            font-size: 7.5pt;
            text-transform: uppercase;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-mono { font-family: Courier, monospace; }
        
        .badge {
            display: inline-block;
            padding: 1px 4px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 7pt;
        }
        .badge-disetujui { background-color: #d1fae5; color: #065f46; }
        .badge-diproses { background-color: #fef3c7; color: #92400e; }
        .badge-ditolak { background-color: #fee2e2; color: #991b1b; }

        /* Rekapitulasi Bawah */
        .rekap-box {
            margin-top: 10px;
            padding: 6px 10px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            font-size: 8pt;
        }

        /* Lembar Pengesahan Tanda Tangan */
        .tanda-tangan-wrapper {
            margin-top: 25px;
            width: 100%;
            page-break-inside: avoid;
        }
        .ttd-kiri {
            float: left;
            width: 40%;
            text-align: center;
        }
        .ttd-kanan {
            float: right;
            width: 40%;
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

    {{-- JUDUL LAPORAN --}}
    <div class="judul-dokumen">
        <h3>KARTU INVENTARIS BARANG (KIB) A - TANAH KAS DESA</h3>
        <p>Klasifikasi: Aset Tetap Milik Desa | Dicetak pada: {{ date('d-m-Y H:i') }} WIB</p>
    </div>

    {{-- TABEL INVENTARIS --}}
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="14%">Nama / Jenis Barang</th>
                <th width="11%">Kode / NUP</th>
                <th width="7%">Luas (m²)</th>
                <th width="5%">Tahun</th>
                <th width="16%">Letak / Alamat Lokasi</th>
                <th width="14%">Status Hak & Sertifikat</th>
                <th width="10%">Penggunaan</th>
                <th width="10%">Asal Usul</th>
                <th width="10%">Nilai Perolehan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataAset as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item->nama_barang ?? 'Tanah Kas Desa' }}</strong>
                </td>
                <td>
                    <span class="font-mono">{{ $item->kode_barang ?? '-' }}</span><br>
                    <small style="color: #666;">NUP: {{ $item->nup ?? '-' }}</small>
                </td>
                <td class="text-right font-mono">{{ number_format($item->luas, 0, ',', '.') }}</td>
                <td class="text-center">
                    {{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('Y') : '-' }}
                </td>
                <td>{{ Str::limit($item->lokasi, 45) }}</td>
                <td>
                    <strong>{{ $item->status_sertifikat ?? '-' }}</strong><br>
                    <small style="color: #555;">No: {{ $item->nomor_sertifikat ?? '-' }}</small>
                </td>
                <td>{{ $item->penggunaan ?? '-' }}</td>
                <td>{{ $item->asal_perolehan ?? '-' }}</td>
                <td class="text-right font-mono">
                    {{ number_format($item->harga_perolehan, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 20px; color: #888;">
                    Tidak ada data inventaris tanah kas desa yang sesuai dengan kriteria cetak.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- REKAPITULASI RINGKAS --}}
    <div class="rekap-box">
        <table style="border: none; margin: 0; width: 100%;">
            <tr style="border: none;">
                <td style="border: none; width: 33%;">
                    <strong>Jumlah Persil:</strong> {{ $dataAset->count() }} Bidang
                </td>
                <td style="border: none; width: 33%; text-align: center;">
                    <strong>Akumulasi Luas:</strong> {{ number_format($dataAset->sum('luas'), 0, ',', '.') }} m²
                </td>
                <td style="border: none; width: 34%; text-align: right;">
                    <strong>Total Nilai Perolehan:</strong> Rp {{ number_format($dataAset->sum('harga_perolehan'), 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    {{-- LEMBAR TANDA TANGAN KEDINASAN --}}
    <div class="tanda-tangan-wrapper">
        <div class="ttd-kiri">
            <p>Pengurus / Pengelola Barang Desa,</p>
            <br><br><br><br>
            <p style="margin: 0;"><strong>( .................................................... )</strong></p>
            <p style="margin: 2px 0 0 0; font-size: 7.5pt; color: #555;">Petugas Pengadministrasi Aset</p>
        </div>

        <div class="ttd-kanan">
            <p>{{ $desa?->kabupaten ?? 'Wilayah' }}, {{ now()->format('d F Y') }}<br>Mengetahui, Lurah / Kepala Desa</p>
            <br><br><br><br>
            <p style="margin: 0;"><strong><u>{{ $desa?->nama_kepala_desa ?? '( .................................................... )' }}</u></strong></p>
            <p style="margin: 2px 0 0 0; font-size: 7.5pt; color: #555;">NIP / NRPDes: {{ $desa?->nip_kepala_desa ?? '-' }}</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>