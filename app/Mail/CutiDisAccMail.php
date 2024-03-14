<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CutiDisAccMail extends Mailable
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
        return $this->view('email.cutidisacc')
                    ->subject("[CUTI] Permintaan Cuti Anda ditolak")
                    ->with(['cuti' => $this->cuti]);
    }
}
