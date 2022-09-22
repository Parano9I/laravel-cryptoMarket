<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CurrenciesEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $currenciesHistory;
    public $subject;
    public $fromEmail;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($currenciesHistory, $subject)
    {
        $this->currenciesHistory = $currenciesHistory;
        $this->subject = $subject;
        $this->fromName = env('MAIL_FROM_NAME');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromEmail, $this->fromName)
            ->subject($this->subject)
            ->markdown('emails.currency-histories')
            ->with(['currencies' => $this->currenciesHistory]);
    }
}
