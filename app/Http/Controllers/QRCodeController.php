<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public static function generateQRCode($data, $size = 100)
    {
        $qrCode = QrCode::format('png')->size(100)->generate($data);

        return $qrCode;
    }
}
