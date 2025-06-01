<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusPesananChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $status;
    public $pesanan;

    public function __construct($username, $status, $pesanan)
    {
        $this->username = $username;
        $this->status = $status;
        $this->pesanan = $pesanan;
    }

    public function build()
    {
        return $this->subject('Status Pesanan Anda Diperbarui')
                    ->view('emails.status_pesanan_changed');
    }
}
