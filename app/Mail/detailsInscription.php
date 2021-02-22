<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class detailsInscription extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pdf;
    public $name;
    public $message;
    public function __construct($pdf,$name,$message)
    {
        $this->pdf = $pdf;
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->message;
        return $this->view('mails.detailsInscription',compact('data'))
        ->attachData($this->pdf, ['as' => $this->name,
                    'mime' => 'application/pdf']);
    }
}
