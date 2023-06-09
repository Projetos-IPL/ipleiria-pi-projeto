<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Recibo;

class ReciboController extends Controller
{
    public static function createPDF(int $id)
    {
        $recibo = Recibo::findOrFail($id);
        $bilhetes = $recibo->bilhetes;

        $reciboName = 'recibo_' . $recibo->id . '.pdf';

        $pdf = PDF::loadView('admin::pdf.recibo', compact('recibo', 'bilhetes'))->setPaper(['0', '0', '280', '800'], 'portrait');

        $recibo->recibo_pdf_url = $reciboName;
        $recibo->save();

        $pdf->save(storage_path('app/pdf_recibos/' . $reciboName));

        return;
    }

    public function showPDF(int $id)
    {
        if (auth()->user()->tipo !== 'A' && auth()->user()->tipo !== 'C') {
            return;
        }

        $recibo = Recibo::findOrFail($id);

        return response()->download(storage_path('app/pdf_recibos/' . $recibo->recibo_pdf_url));
    }
}
