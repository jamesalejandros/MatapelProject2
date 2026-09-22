<?php

namespace App\Filament\Resources\ItRequests\Pages;

use App\Filament\Resources\ItRequests\ItRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateItRequest extends CreateRecord
{
    protected static string $resource =
        ItRequestResource::class;

    /*
    |--------------------------------------------------------------------------
    | MUTATE DATA SEBELUM CREATE
    |--------------------------------------------------------------------------
    */

    protected function mutateFormDataBeforeCreate(
        array $data
    ): array {

        /*
        |--------------------------------------------------------------------------
        | PEMOHON
        |--------------------------------------------------------------------------
        |
        | Selalu menggunakan user yang sedang login.
        |
        */

        $data['UserPemohonID'] =
            auth()->id();

        /*
        |--------------------------------------------------------------------------
        | STATUS AWAL
        |--------------------------------------------------------------------------
        |
        | Semua request baru wajib masuk sebagai:
        |
        | diajukan
        |
        | Approval Kepala Bagian nantinya yang menentukan
        | apakah request boleh dilanjutkan.
        |
        */

        $data['Status'] =
            'diajukan';

        /*
        |--------------------------------------------------------------------------
        | NOMOR SEMENTARA
        |--------------------------------------------------------------------------
        */

        $data['NoRequest'] =
            'TEMP-' . uniqid();

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | AFTER CREATE
    |--------------------------------------------------------------------------
    */

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
