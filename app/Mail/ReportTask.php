<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Calendar;

class ReportTask extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
    private $path;

    public function __construct($user,$path)
    {
        $this->path = $path;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $month = date('m');
        $year = date('Y');
        return $this->view('email.reportTask')->with(['date' => Calendar::indonesiaMonth($month,true).' '.$year,'user' => $this->user])
                    ->subject("[REPORT] Laporan Tugas Karyawan ".Calendar::indonesiaMonth($month,true).' '.$year)
                    ->attach(storage_path('app/'.$this->path));
    }

}
