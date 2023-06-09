<?php

namespace App\Mail;

use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Recibo;

class SendReciboEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $recibo;

    /**
     * Create a new message instance.
     */
    public function __construct($id)
    {
        $this->recibo = Recibo::findOrFail($id);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $this->subject('Envio de Recibo - Recibo #' . $this->recibo->id);

        $this->attach(storage_path('app/pdf_recibos/' . $this->recibo->recibo_pdf_url));

        return $this->view('emails.recibo');
    }
}
