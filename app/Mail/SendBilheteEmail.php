<?php

namespace App\Mail;

use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\QRCodeController;

class SendBilheteEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $bilhetesData;

    /**
     * Create a new message instance.
     */
    public function __construct($bilhetesData)
    {
        $this->bilhetesData = $bilhetesData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        foreach ($this->bilhetesData as $sessao) {
            $qrCodeImage = QRCodeController::generateQRCode($sessao->id);

            $pdf = PDF::loadView('admin::pdf.bilhete', ['bilhete' => $sessao, 'qrCodeImage' => $qrCodeImage]);
            $pdf->setPaper(['0', '0', '1200', '388.5'], 'portrait');

            $this->subject('Envio de Bilhete - Sessão #' . $sessao->id);

            $this->attachData($pdf->output(), 'bilhete-' . $sessao->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
        }

        return $this->view('emails.bilhetes');
    }
}
