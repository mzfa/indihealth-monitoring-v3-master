<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectAssign extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $data;

    public function __construct($pr)
    {
        $this->data = $pr;
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
        $is_pm = $this->data->is_pm ? "Project Manager/Leader" : "Member";
        return $this->view('email.projectAssign')
                    ->subject("[PROJECT] Anda telah ditambahkan sebagai ". $is_pm." pada Project ".$this->data->project->name)
                    ->with(['pr' => $this->data,'member_type' => $is_pm]);
    }
}
