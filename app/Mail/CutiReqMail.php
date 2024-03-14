<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CutiReqMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
    private $cuti;

    public function __construct($user,$cuti)
    {
        $this->user = $user;
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
        return $this->view('email.cutiReq')
                    ->subject("[REQUEST CUTI] ".$this->cuti->karyawan->nama_lengkap." mengirimkan permintaan cuti")
                    ->with(['user' => $this->user,'cuti' => $this->cuti]);
    }
}
