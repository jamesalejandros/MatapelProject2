<?php

namespace App\Filament\Resources\MstKepalaBagians\Pages;

use App\Filament\Resources\MstKepalaBagians\MstKepalaBagianResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMstKepalaBagian extends CreateRecord
{
    protected static string $resource =
        MstKepalaBagianResource::class;

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl(
            'index'
        );
    }
}
