<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RdvNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $rdv;
    /**
     * Create a new message instance.
     */
    public function __construct($rdv)
    {
        $this->rdv = $rdv;
    }

    public function build()
    {
        return $this->subject('Nouvelle prise de rendez-vous')
            ->view('emails.rdv.notifs')
            ->text('emails.rdv.notifs_plain');
    }

}
