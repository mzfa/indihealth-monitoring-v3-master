<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CutiAccMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
    private $cuti;

    public function __construct($cuti)
    {
       
        $this->cuti = $cuti;
        // dd($this->data);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      // dd($this->cuti->jumlah);
        return $this->view('email.cutiacc')
                    ->subject("[CUTI] Permintaan Cuti Anda Telah disetujui")
                    ->with(['cuti' => $this->cuti]);
    }
}
