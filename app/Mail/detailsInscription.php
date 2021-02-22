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
    public function __construct($pdf,$name)
    {
        $this->pdf = $pdf;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $params = array(
            'as' => 'datos.pdf',
            'mime' => 'application/pdf'
        ); 
        return $this->view('mails.detailsInscription')
        ->attachData($this->pdf,'datos_Inscripción_'.getenv("MATRICULAS_PARA").'.pdf');
    }
}
