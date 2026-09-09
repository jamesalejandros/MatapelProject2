<?php

namespace App\Filament\Resources\ItRequests\Pages;

use App\Filament\Resources\ItRequests\ItRequestResource;

use Filament\Resources\Pages\CreateRecord;


class CreateItRequest extends CreateRecord
{
    protected static string $resource =
        ItRequestResource::class;


    protected function mutateFormDataBeforeCreate(
        array $data
    ): array {

        /*
        |--------------------------------------------------------------------------
        | PEMOHON
        |--------------------------------------------------------------------------
        |
        | Pemohon diambil dari user yang login.
        |
        */

        $data['UserPemohonID'] =
            auth()->id();


        /*
        |--------------------------------------------------------------------------
        | NOMOR SEMENTARA
        |--------------------------------------------------------------------------
        */

        $data['NoRequest'] =
            'TEMP-' . uniqid();


        return $data;
    }


    protected function afterCreate(): void
    {
        $record =
            $this->record;


        /*
        |--------------------------------------------------------------------------
        | NOMOR REQUEST FINAL
        |--------------------------------------------------------------------------
        */

        $record->update([

            'NoRequest' =>
                'IT-'
                . now()->format('Ymd')
                . '-'
                . str_pad(
                    (string) $record->IDRequest,
                    6,
                    '0',
                    STR_PAD_LEFT
                ),

        ]);

    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl(
            'index'
        );
    }
}
