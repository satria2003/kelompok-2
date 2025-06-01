<?php
namespace App\Mail;

use App\Models\Pengguna;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifikasiEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengguna;

    public function __construct(Pengguna $pengguna)
    {
        $this->pengguna = $pengguna;
    }

    public function build()
    {
        return $this->subject('Verifikasi Email Anda')
                    ->view('emails.verifikasi_email')
                    ->with([
                        'token' => $this->pengguna->verifikasi_token,
                        'username' => $this->pengguna->username,
                    ]);
    }
}
