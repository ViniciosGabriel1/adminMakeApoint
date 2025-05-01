<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

        public function build()
        {
            return $this->subject('Notificação de agendamento!')
                        ->view('emails.teste')
                        ->with([
                            'data' => $this->emailData,
                        ]);
        }
}
