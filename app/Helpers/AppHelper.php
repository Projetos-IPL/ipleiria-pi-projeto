<?php

namespace App\Helpers;

use NumberFormatter;
use App\Models\Genero;

class AppHelper
{
    public static function instance()
    {
        return new AppHelper();
    }

    public function getGeneroPrettyName(string $generoCode): string
    {
        return Genero::where('code', $generoCode)->first()->nome;
    }

    public function formatCurrencyValue(string $value): string
    {
        $formatter = new NumberFormatter('pt_PT', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency(floatval($value), 'EUR');
    }
}
