<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderAbsenKeluar extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = (object) $this->jsonConfigParser('jam_pulang');
        return $this->view('email.reminderAbsenKeluar')->with(['data' => $data,'user' => $this->user])
                    ->subject("[PENGINGAT] Jangan lupa 30 menit lagi untuk absen keluar");
    }

    private function jsonConfigParser($name)
    {
    	$jsonString = file_get_contents(storage_path('app/config/'.$name.'.json'));
		$data = json_decode($jsonString, true);

		return $data;
    }
}
