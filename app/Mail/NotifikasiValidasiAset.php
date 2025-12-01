<?php

namespace App\Mail;

use App\Models\TanahKasDesa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiValidasiAset extends Mailable
{
    use Queueable, SerializesModels;

    public $aset;
    public $tipe; // 'BARU' atau 'UPDATE'

    public function __construct(TanahKasDesa $aset, $tipe = 'BARU')
    {
        $this->aset = $aset;
        $this->tipe = $tipe;
    }

    public function envelope(): Envelope
    {
        $subject = $this->tipe == 'BARU' 
            ? 'Menunggu Validasi: Aset Tanah Baru Ditambahkan' 
            : 'Menunggu Validasi Ulang: Data Aset Diperbarui';

        return new Envelope(
            subject: '[SITANAS] ' . $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi-validasi',
        );
    }
}