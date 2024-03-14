<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailAccAbsen extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $data;

    public function __construct($absens)
    {
        $this->data = $absens;
        // dd($this->data);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      // dd($this->data);
        return $this->view('email.accAbsen')
                    ->subject("[PEMBERITAHUAN] Permintaan Absensi keluar Anda disetujui ")
                    ->with(['absen' => $this->data]);
    }
}
