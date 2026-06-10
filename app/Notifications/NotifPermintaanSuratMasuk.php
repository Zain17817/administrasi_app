<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifPermintaanSuratMasuk extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;
    public $nomorPengajuan;

    public function __construct(array $data, string $nomorPengajuan)
    {
        $this->data = $data;
        $this->nomorPengajuan = $nomorPengajuan;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengajuan Surat Baru - ' . $this->data['nama'])
            ->markdown('emails.pengajuan-baru', [
                'data'  => $this->data,
                'nomor' => $this->nomorPengajuan,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'nomor_pengajuan' => $this->nomorPengajuan,
            'nama' => $this->data['nama'],
            'jenis_surat' => $this->data['jenis_surat'],
        ];
    }
}
