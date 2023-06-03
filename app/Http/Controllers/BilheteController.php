<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Bilhete;
use Illuminate\Http\Request;

class BilheteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bilhete $bilhete)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bilhete $bilhete)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bilhete $bilhete)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bilhete $bilhete)
    {
        //
    }

    public function showPDF(int $id)
    {
        $bilhete = Bilhete::findOrFail($id);
        $qrCodeImage = QRCodeController::generateQRCode($bilhete->id);

        $pdf = PDF::loadView('admin::pdf.bilhete', compact('bilhete', 'qrCodeImage'))->setPaper(['0', '0', '1200', '388.5'], 'portrait');

        return $pdf->download('bilhete_' . $bilhete->id . '.pdf');
    }
}
