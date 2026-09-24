<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Database\Seeders\RoleSeeder;
use App\Models\User;
use App\Models\TanahKasDesa;
use App\Models\PemanfaatanTanah;
use App\Models\LogAktivitas;
use App\Models\ProfilDesa;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Aset\TambahAset;
use App\Livewire\Aset\EditAset;
use App\Livewire\Aset\DetailPage;
use App\Livewire\Dashboard\DashboardPage;
use App\Livewire\Public\HalamanPublik;
use App\Livewire\Admin\ArsipAset;
use App\Livewire\Admin\PengaturanDesa;
use App\Livewire\Laporan\LaporanPage;

class AlurBisnisTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $kades;
    protected User $bpd;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();

        // 1. Seed Roles
        $this->seed(RoleSeeder::class);

        // 2. Buat User untuk tiap peran bisnis
        $this->admin = User::create([
            'nama_lengkap' => 'Admin Desa Penguji',
            'email' => 'admin@desa.test',
            'password' => Hash::make('password123'),
            'role_id' => 1, // Admin Desa
            'status' => 'aktif',
        ]);

        $this->kades = User::create([
            'nama_lengkap' => 'Bapak Kepala Desa',
            'email' => 'kades@desa.test',
            'password' => Hash::make('password123'),
            'role_id' => 2, // Kepala Desa (Validator)
            'status' => 'aktif',
        ]);

        $this->bpd = User::create([
            'nama_lengkap' => 'Anggota BPD',
            'email' => 'bpd@desa.test',
            'password' => Hash::make('password123'),
            'role_id' => 3, // BPD
            'status' => 'aktif',
        ]);

        // 3. Inisialisasi Profil Desa
        ProfilDesa::create([
            'nama_desa' => 'Desa Sukamaju',
            'kode_desa' => '32.01.01.2001',
            'kecamatan' => 'Kecamatan Ceria',
            'kabupaten' => 'Kabupaten Makmur',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40123',
            'alamat_kantor' => 'Jl. Raya Desa No. 10',
            'telepon' => '08123456789',
            'email' => 'sukamaju@desa.id',
            'nama_kepala_desa' => 'H. Ahmad Subarjo',
            'nip_kepala_desa' => '197501012000031001',
        ]);
    }

    /**
     * ALUR 1: Autentikasi & Kontrol Hak Akses (RBAC)
     */
    public function test_alur_1_autentikasi_dan_kontrol_hak_akses(): void
    {
        // A. Tamu (guest) berhasil melihat portal publik
        $this->get('/publik')->assertStatus(200);

        // B. Tamu mengakses dashboard dialihkan ke login
        $this->get('/')->assertRedirect('/login');

        // C. Login dengan kredensial yang salah
        Livewire::test(LoginPage::class)
            ->set('email', 'admin@desa.test')
            ->set('password', 'passwordsalah')
            ->call('login')
            ->assertSee('Kombinasi Email atau Password salah');
        $this->assertGuest();

        // D. Login dengan user non-aktif ditolak
        User::create([
            'nama_lengkap' => 'User Nonaktif',
            'email' => 'nonaktif@desa.test',
            'password' => Hash::make('password123'),
            'role_id' => 1,
            'status' => 'nonaktif',
        ]);
        Livewire::test(LoginPage::class)
            ->set('email', 'nonaktif@desa.test')
            ->set('password', 'password123')
            ->call('login')
            ->assertSee('Kombinasi Email atau Password salah');
        $this->assertGuest();

        // E. Login berhasil dengan akun aktif
        Livewire::test(LoginPage::class)
            ->set('email', 'admin@desa.test')
            ->set('password', 'password123')
            ->call('login')
            ->assertRedirect('/');

        // F. Role Non-Admin (Kepala Desa & BPD) dilarang mengakses rute khusus Admin
        $this->actingAs($this->kades)->get('/tanah/baru')->assertStatus(403);
        $this->actingAs($this->kades)->get('/admin/users')->assertStatus(403);
        $this->actingAs($this->kades)->get('/admin/arsip')->assertStatus(403);
        $this->actingAs($this->kades)->get('/admin/log')->assertStatus(403);
        $this->actingAs($this->kades)->get('/admin/pengaturan')->assertStatus(403);

        $this->actingAs($this->bpd)->get('/tanah/baru')->assertStatus(403);

        // G. Admin diperbolehkan mengakses seluruh rute tersebut
        $this->actingAs($this->admin)->get('/tanah/baru')->assertStatus(200);
        $this->actingAs($this->admin)->get('/admin/users')->assertStatus(200);
        $this->actingAs($this->admin)->get('/admin/arsip')->assertStatus(200);
        $this->actingAs($this->admin)->get('/admin/log')->assertStatus(200);
        $this->actingAs($this->admin)->get('/admin/pengaturan')->assertStatus(200);
    }

    /**
     * ALUR 2: Pencatatan Aset Baru oleh Admin & Perekaman Audit Log
     */
    public function test_alur_2_pencatatan_aset_baru_dan_audit_log(): void
    {
        $this->actingAs($this->admin);

        // A. Validasi form aset baru (gagal bila field mandatory kosong)
        Livewire::test(TambahAset::class)
            ->set('kode_barang', '')
            ->call('simpan')
            ->assertHasErrors(['kode_barang', 'nama_barang', 'harga_perolehan', 'luas']);

        // B. Simpan data aset baru yang valid
        Livewire::test(TambahAset::class)
            ->set('kode_barang', 'TKD-001-TEST')
            ->set('nama_barang', 'Tanah Carik Desa Blok A')
            ->set('nup', '0001')
            ->set('asal_perolehan', 'Hak Milik Adat / Kas Desa')
            ->set('tanggal_perolehan', '2020-01-15')
            ->set('harga_perolehan', 150000000)
            ->set('bukti_perolehan', 'Sertifikat')
            ->set('nomor_sertifikat', 'HP.0012/2020')
            ->set('tanggal_sertifikat', '2020-02-10')
            ->set('status_sertifikat', 'Sertifikat Hak Pakai')
            ->set('luas', 2500)
            ->set('lokasi', 'Dusun Krajan RT 01 RW 02')
            ->set('penggunaan', 'Pertanian')
            ->set('kondisi', 'Baik')
            ->set('koordinat', '-6.9175, 107.6191')
            ->set('batas_utara', 'Jalan Desa')
            ->set('batas_selatan', 'Sungai Citarum')
            ->set('batas_timur', 'Tanah Warga')
            ->set('batas_barat', 'Saluran Irigasi')
            ->set('keterangan', 'Dikelola kas desa untuk kas produktif')
            ->call('simpan')
            ->assertRedirect(route('dashboard'));

        // C. Pastikan aset masuk database dengan status 'Diproses'
        $aset = TanahKasDesa::where('kode_barang', 'TKD-001-TEST')->first();
        $this->assertNotNull($aset);
        $this->assertEquals('Diproses', $aset->status_validasi);
        $this->assertEquals($this->admin->id, $aset->diinput_oleh);

        // D. Pastikan Log Aktivitas otomatis mencatat aksi 'TAMBAH'
        $log = LogAktivitas::where('subject_id', $aset->id)
            ->where('aksi', 'TAMBAH')
            ->first();
        $this->assertNotNull($log);
        $this->assertEquals($this->admin->id, $log->user_id);
    }

    /**
     * ALUR 3: Siklus Validasi oleh Kepala Desa (Tolak -> Revisi oleh Admin -> Setujui)
     */
    public function test_alur_3_siklus_validasi_penolakan_revisi_dan_persetujuan(): void
    {
        // 1. Buat Aset awal berstatus Diproses
        $aset = TanahKasDesa::create([
            'kode_barang' => 'TKD-002-VAL',
            'nama_barang' => 'Tanah Kas Desa Blok B',
            'nup' => '0002',
            'asal_perolehan' => 'Pemerintah',
            'tanggal_perolehan' => '2021-03-01',
            'harga_perolehan' => 200000000,
            'bukti_perolehan' => 'Letter C',
            'status_sertifikat' => 'Letter C / Girik',
            'luas' => 1800,
            'lokasi' => 'Jl. Pramuka No. 4',
            'kondisi' => 'Baik',
            'penggunaan' => 'Perkantoran',
            'status_validasi' => 'Diproses',
            'diinput_oleh' => $this->admin->id,
        ]);

        // A. Admin TIDAK BISA memvalidasi aset di Dashboard (bukan role_id 2)
        $this->actingAs($this->admin);
        Livewire::test(DashboardPage::class)
            ->set('validasiAsetId', $aset->id)
            ->set('validasiStatus', 'Disetujui')
            ->call('prosesValidasi')
            ->assertSee('Anda tidak memiliki hak akses untuk memvalidasi');
        $this->assertEquals('Diproses', $aset->fresh()->status_validasi);

        // B. Kepala Desa melakukan validasi PENOLAKAN dengan catatan revisi
        $this->actingAs($this->kades);
        Livewire::test(DashboardPage::class)
            ->set('validasiAsetId', $aset->id)
            ->set('validasiStatus', 'Ditolak')
            ->set('validasiCatatan', 'Nomor persil dan batas timur belum dilengkapi')
            ->call('prosesValidasi');

        $aset->refresh();
        $this->assertEquals('Ditolak', $aset->status_validasi);
        $this->assertEquals('Nomor persil dan batas timur belum dilengkapi', $aset->catatan_validasi);
        $this->assertEquals($this->kades->id, $aset->divalidasi_oleh);

        // Pastikan Log Aktivitas mencatat aksi 'VALIDASI'
        $this->assertTrue(
            LogAktivitas::where('subject_id', $aset->id)
                ->where('aksi', 'VALIDASI')
                ->where('properties->new->status_validasi', 'Ditolak')
                ->exists()
        );

        // C. Admin melakukan revisi / edit data
        $this->actingAs($this->admin);
        Livewire::test(EditAset::class, ['aset' => $aset])
            ->set('batas_timur', 'Tanah Kas Desa Blok C')
            ->set('keterangan', 'Sudah diperbaiki sesuai catatan Kepala Desa')
            ->call('simpan')
            ->assertRedirect(route('dashboard'));

        // Pastikan status otomatis kembali menjadi 'Diproses' dan catatan direset
        $aset->refresh();
        $this->assertEquals('Diproses', $aset->status_validasi);
        $this->assertNull($aset->catatan_validasi);
        $this->assertNull($aset->divalidasi_oleh);

        // D. Kepala Desa melakukan PERSETUJUAN (Approval) dari Detail Page
        $this->actingAs($this->kades);
        Livewire::test(DetailPage::class, ['aset' => $aset])
            ->call('setujuiAset');

        $aset->refresh();
        $this->assertEquals('Disetujui', $aset->status_validasi);
        $this->assertEquals($this->kades->id, $aset->divalidasi_oleh);
    }

    /**
     * ALUR 4: Pencatatan Pemanfaatan/Kerjasama Tanah Kas Desa & Early Warning
     */
    public function test_alur_4_pencatatan_pemanfaatan_dan_early_warning(): void
    {
        $this->actingAs($this->admin);

        $aset = TanahKasDesa::create([
            'kode_barang' => 'TKD-003-SEWA',
            'nama_barang' => 'Tanah Kas Desa Bengkok',
            'asal_perolehan' => 'Kas Desa',
            'tanggal_perolehan' => '2019-01-01',
            'harga_perolehan' => 100000000,
            'bukti_perolehan' => 'Sertifikat',
            'status_sertifikat' => 'Sertifikat Hak Pakai',
            'luas' => 5000,
            'lokasi' => 'Blok Sawah Lor',
            'kondisi' => 'Baik',
            'penggunaan' => 'Sawah Kas Desa',
            'status_validasi' => 'Disetujui',
            'diinput_oleh' => $this->admin->id,
        ]);

        // A. Validasi tanggal pemanfaatan (selesai tidak boleh sebelum mulai)
        Livewire::test(DetailPage::class, ['aset' => $aset])
            ->set('p_pihak_ketiga', 'Kelompok Tani Makmur')
            ->set('p_bentuk_pemanfaatan', 'Sewa')
            ->set('p_tanggal_mulai', '2026-10-01')
            ->set('p_tanggal_selesai', '2026-09-01') // Invalid: sebelum mulai
            ->set('p_nilai_kontribusi', 12000000)
            ->set('p_status_pembayaran', 'Lunas')
            ->call('simpanPemanfaatan')
            ->assertHasErrors(['p_tanggal_selesai']);

        // B. Simpan pemanfaatan kontrak yang valid (akan jatuh tempo dalam 15 hari)
        $mulai = now()->subDays(350)->format('Y-m-d');
        $selesai = now()->addDays(15)->format('Y-m-d'); // Dalam rentang 30 hari -> Early Warning

        Livewire::test(DetailPage::class, ['aset' => $aset])
            ->set('p_pihak_ketiga', 'Kelompok Tani Makmur')
            ->set('p_bentuk_pemanfaatan', 'Sewa')
            ->set('p_tanggal_mulai', $mulai)
            ->set('p_tanggal_selesai', $selesai)
            ->set('p_nilai_kontribusi', 15000000)
            ->set('p_status_pembayaran', 'Lunas')
            ->set('p_keterangan', 'Sewa lahan pertanian musim tanam 2025/2026')
            ->call('simpanPemanfaatan');

        $this->assertEquals(1, $aset->pemanfaatan()->count());

        // C. Proteksi tumpang tindih kontrak (Overlap Contract Protection)
        Livewire::test(DetailPage::class, ['aset' => $aset])
            ->set('p_pihak_ketiga', 'CV Mitra Desa')
            ->set('p_bentuk_pemanfaatan', 'Kerjasama Usaha')
            ->set('p_tanggal_mulai', now()->subDays(10)->format('Y-m-d'))
            ->set('p_tanggal_selesai', now()->addDays(40)->format('Y-m-d'))
            ->set('p_nilai_kontribusi', 20000000)
            ->set('p_status_pembayaran', 'Belum Lunas')
            ->call('simpanPemanfaatan')
            ->assertSee('Gagal: Tanggal kontrak tumpang tindih');

        // Pastikan kontrak kedua tidak masuk karena overlap
        $this->assertEquals(1, $aset->pemanfaatan()->count());

        // D. Verifikasi Early Warning muncul di Dashboard
        Livewire::test(DashboardPage::class)
            ->assertViewHas('earlyWarnings', function ($warnings) use ($aset) {
                return $warnings->contains('tanah_id', $aset->id);
            });
    }

    /**
     * ALUR 5: Transparansi Publik (Hanya Aset Disetujui yang Tampil)
     */
    public function test_alur_5_transparansi_portal_publik(): void
    {
        // 1. Aset Disetujui (Harus tampil di publik)
        $asetDisetujui = TanahKasDesa::create([
            'kode_barang' => 'PUB-001',
            'nama_barang' => 'Tanah Kas Lapangan Desa',
            'asal_perolehan' => 'Kas Desa',
            'tanggal_perolehan' => '2015-05-10',
            'harga_perolehan' => 300000000,
            'bukti_perolehan' => 'Sertifikat',
            'status_sertifikat' => 'Sertifikat Hak Pakai',
            'luas' => 8000,
            'lokasi' => 'Jl. Lapangan Olahraga No. 1',
            'kondisi' => 'Baik',
            'penggunaan' => 'Fasilitas Umum',
            'status_validasi' => 'Disetujui',
            'diinput_oleh' => $this->admin->id,
        ]);

        // 2. Aset Diproses (TIDAK BOLEH tampil di publik)
        TanahKasDesa::create([
            'kode_barang' => 'DRAFT-002',
            'nama_barang' => 'Tanah Belum Disetujui',
            'asal_perolehan' => 'Kas Desa',
            'tanggal_perolehan' => '2024-01-01',
            'harga_perolehan' => 50000000,
            'bukti_perolehan' => 'Letter C',
            'status_sertifikat' => 'Letter C / Girik',
            'luas' => 1000,
            'lokasi' => 'Blok Rahasia',
            'kondisi' => 'Baik',
            'penggunaan' => 'Kebun',
            'status_validasi' => 'Diproses',
            'diinput_oleh' => $this->admin->id,
        ]);

        // 3. Aset Ditolak (TIDAK BOLEH tampil di publik)
        TanahKasDesa::create([
            'kode_barang' => 'REJECT-003',
            'nama_barang' => 'Tanah Ditolak Kades',
            'asal_perolehan' => 'Kas Desa',
            'tanggal_perolehan' => '2024-02-01',
            'harga_perolehan' => 70000000,
            'bukti_perolehan' => 'Letter C',
            'status_sertifikat' => 'Letter C / Girik',
            'luas' => 1200,
            'lokasi' => 'Blok Batas Sengketa',
            'kondisi' => 'Rusak Ringan',
            'penggunaan' => 'Sengketa',
            'status_validasi' => 'Ditolak',
            'diinput_oleh' => $this->admin->id,
        ]);

        // Uji Halaman Publik
        Livewire::test(HalamanPublik::class)
            ->assertSee('PUB-001')
            ->assertSee('Tanah Kas Lapangan Desa')
            ->assertDontSee('DRAFT-002')
            ->assertDontSee('Tanah Belum Disetujui')
            ->assertDontSee('REJECT-003')
            ->assertDontSee('Tanah Ditolak Kades');

        // Uji fitur pencarian publik
        Livewire::test(HalamanPublik::class)
            ->set('search', 'Lapangan')
            ->assertSee('PUB-001')
            ->set('search', 'TidakAdaDiDatabase')
            ->assertDontSee('PUB-001');
    }

    /**
     * ALUR 6: Pengarsipan (Soft Delete), Pemulihan (Restore), & Proteksi Hapus Permanen
     */
    public function test_alur_6_pengarsipan_pemulihan_dan_proteksi_hapus_permanen(): void
    {
        $this->actingAs($this->admin);

        // A. Buat aset yang telah Disetujui
        $asetResmi = TanahKasDesa::create([
            'kode_barang' => 'ARSIP-RESMI-01',
            'nama_barang' => 'Tanah Kantor Desa',
            'asal_perolehan' => 'Kas Desa',
            'tanggal_perolehan' => '2010-01-01',
            'harga_perolehan' => 500000000,
            'bukti_perolehan' => 'Sertifikat',
            'status_sertifikat' => 'Sertifikat Hak Pakai',
            'luas' => 3000,
            'lokasi' => 'Pusat Pemerintahan Desa',
            'kondisi' => 'Baik',
            'penggunaan' => 'Perkantoran',
            'status_validasi' => 'Disetujui',
            'diinput_oleh' => $this->admin->id,
        ]);

        // B. Arsipkan aset resmi dari Dashboard
        Livewire::test(DashboardPage::class)
            ->call('arsipkan', $asetResmi->id);

        $this->assertSoftDeleted('tanah_kas_desa', ['id' => $asetResmi->id]);

        // Pastikan Log Aktivitas mencatat 'ARSIP'
        $this->assertTrue(
            LogAktivitas::where('subject_id', $asetResmi->id)
                ->where('aksi', 'ARSIP')
                ->exists()
        );

        // C. Proteksi: Aset yang statusnya Disetujui TIDAK DAPAT dihapus permanen
        Livewire::test(ArsipAset::class)
            ->call('hapusPermanen', $asetResmi->id)
            ->assertSee('tidak dapat dihapus secara permanen');

        // Data tetap ada di trash (tidak terhapus permanen)
        $this->assertSoftDeleted('tanah_kas_desa', ['id' => $asetResmi->id]);

        // D. Pulihkan (restore) aset dari arsip
        Livewire::test(ArsipAset::class)
            ->call('pulihkan', $asetResmi->id);

        $this->assertNotSoftDeleted('tanah_kas_desa', ['id' => $asetResmi->id]);

        // E. Aset Ditolak atau Diproses BISA dihapus permanen jika diarsipkan
        $asetDraft = TanahKasDesa::create([
            'kode_barang' => 'ARSIP-DRAFT-02',
            'nama_barang' => 'Tanah Salah Input',
            'asal_perolehan' => 'Kas Desa',
            'tanggal_perolehan' => '2024-01-01',
            'harga_perolehan' => 10000000,
            'bukti_perolehan' => 'Letter C',
            'status_sertifikat' => 'Letter C / Girik',
            'luas' => 500,
            'lokasi' => 'Lokasi Salah',
            'kondisi' => 'Baik',
            'penggunaan' => 'Kebun',
            'status_validasi' => 'Ditolak',
            'diinput_oleh' => $this->admin->id,
        ]);
        $asetDraft->delete();

        Livewire::test(ArsipAset::class)
            ->call('hapusPermanen', $asetDraft->id);

        $this->assertDatabaseMissing('tanah_kas_desa', ['id' => $asetDraft->id]);
    }

    /**
     * ALUR 7: Laporan, Filter, & Ekspor PDF / CSV
     */
    public function test_alur_7_laporan_filter_dan_ekspor(): void
    {
        $this->actingAs($this->admin);

        TanahKasDesa::create([
            'kode_barang' => 'LAP-001',
            'nama_barang' => 'Tanah Bengkok A',
            'asal_perolehan' => 'Kas Desa',
            'tanggal_perolehan' => '2022-01-01',
            'harga_perolehan' => 100000000,
            'bukti_perolehan' => 'Sertifikat',
            'status_sertifikat' => 'Sertifikat Hak Pakai',
            'luas' => 2000,
            'lokasi' => 'Wilayah Barat',
            'kondisi' => 'Baik',
            'penggunaan' => 'Sawah',
            'status_validasi' => 'Disetujui',
            'diinput_oleh' => $this->admin->id,
        ]);

        TanahKasDesa::create([
            'kode_barang' => 'LAP-002',
            'nama_barang' => 'Tanah Kuburan Umum',
            'asal_perolehan' => 'Hibah',
            'tanggal_perolehan' => '2023-01-01',
            'harga_perolehan' => 50000000,
            'bukti_perolehan' => 'Letter C',
            'status_sertifikat' => 'Letter C / Girik',
            'luas' => 1500,
            'lokasi' => 'Wilayah Timur',
            'kondisi' => 'Rusak Ringan',
            'penggunaan' => 'Makam',
            'status_validasi' => 'Diproses',
            'diinput_oleh' => $this->admin->id,
        ]);

        // A. Filter status pada Laporan
        Livewire::test(LaporanPage::class)
            ->set('filterStatus', 'Disetujui')
            ->assertSee('LAP-001')
            ->assertDontSee('LAP-002');

        // B. Ekspor CSV
        $component = Livewire::test(LaporanPage::class);
        $responseCsv = $component->call('exportCsv');
        $this->assertNotNull($responseCsv);

        // C. Ekspor PDF
        $responsePdf = $component->call('exportPdf');
        $this->assertNotNull($responsePdf);
    }

    /**
     * ALUR 8: Pengaturan Profil Desa & KOP Surat Resmi
     */
    public function test_alur_8_pengaturan_profil_desa(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PengaturanDesa::class)
            ->set('nama_desa', 'Desa Maju Mandiri')
            ->set('kode_desa', '32.01.01.2002')
            ->set('kecamatan', 'Kecamatan Sentosa')
            ->set('kabupaten', 'Kabupaten Bandung Barat')
            ->set('provinsi', 'Jawa Barat')
            ->set('nama_kepala_desa', 'Drs. H. Mulyadi, M.Si.')
            ->set('nip_kepala_desa', '198001012005011002')
            ->call('simpan')
            ->assertSee('Profil desa berhasil disimpan!');

        $profil = ProfilDesa::getProfil();
        $this->assertEquals('Desa Maju Mandiri', $profil->nama_desa);
        $this->assertEquals('Drs. H. Mulyadi, M.Si.', $profil->nama_kepala_desa);
        $this->assertEquals('198001012005011002', $profil->nip_kepala_desa);
    }
}
