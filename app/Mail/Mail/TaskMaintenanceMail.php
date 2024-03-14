<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskMaintenanceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $taskMT;

    public function __construct($taskMT)
    {
        $this->taskMT = $taskMT;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.taskMT')
                    ->subject("[TASK-MAINTENANCE] Penugasan Maintenance")
                    ->with(['taskMT' => $this->taskMT]);
    }
}
