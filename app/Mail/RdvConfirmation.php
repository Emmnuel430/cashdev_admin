<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RdvConfirmation extends Mailable
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
        return $this->subject('Confirmation de votre rendez-vous')
            ->view('emails.rdv.validated')
            ->text('emails.rdv.validated_plain');
    }

}
