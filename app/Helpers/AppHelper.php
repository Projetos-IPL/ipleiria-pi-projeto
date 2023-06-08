<?php

namespace App\Helpers;

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
}
