<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanah_kas_desa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang'); // Contoh: 01.01.01
            $table->string('nama_barang'); // BARU: Contoh "Tanah Kantor Desa"
            $table->string('nup')->nullable();
            $table->string('asal_perolehan'); 
            $table->date('tanggal_perolehan'); 
            $table->decimal('harga_perolehan', 15, 2);
            $table->string('bukti_perolehan')->nullable(); 
            
            // Legalitas
            $table->string('nomor_sertifikat')->nullable();
            $table->date('tanggal_sertifikat')->nullable();
            $table->string('status_sertifikat'); // Hak Pakai/Milik
            
            // Fisik
            $table->double('luas');
            $table->text('lokasi');
            $table->string('penggunaan');
            $table->string('koordinat')->nullable();
            $table->string('kondisi');
            
            // Batas
            $table->string('batas_utara')->nullable();
            $table->string('batas_timur')->nullable();
            $table->string('batas_selatan')->nullable();
            $table->string('batas_barat')->nullable();
            
            $table->text('keterangan')->nullable();
            
            // Sistem
            $table->foreignId('diinput_oleh')->constrained('users');
            $table->enum('status_validasi', ['Diproses', 'Disetujui', 'Ditolak'])->default('Diproses');
            $table->text('catatan_validasi')->nullable();
            $table->foreignId('divalidasi_oleh')->nullable()->constrained('users');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanah_kas_desa');
    }
};