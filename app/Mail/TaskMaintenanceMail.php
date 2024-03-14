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
    private $data;

    public function __construct($taskMT)
    {
        $this->data = $taskMT;
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
        return $this->view('email.taskMT')
                    ->subject("[TASK-PROJECT] Penugasan Project ".$this->data->task->project->name." (".$this->data->task->planDetail->name.") ")
                    ->with(['taskMT' => $this->data]);
    }
}
