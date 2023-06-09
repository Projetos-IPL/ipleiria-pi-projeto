<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Bilhete;

class BilheteController extends Controller
{
    public function showPDF(int $id)
    {
        $bilhete = Bilhete::findOrFail($id);
        $qrCodeImage = QRCodeController::generateQRCode($bilhete->id);

        $pdf = PDF::loadView('admin::pdf.bilhete', compact('bilhete', 'qrCodeImage'))->setPaper(['0', '0', '1200', '388.5'], 'portrait');

        return $pdf->download('bilhete_' . $bilhete->id . '.pdf');
    }
}
