<?php

namespace App\Filament\Resources\ItRequests\Pages;

use App\Filament\Resources\ItRequests\ItRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditItRequest extends EditRecord
{
    protected static string $resource =
        ItRequestResource::class;

    /*
    |--------------------------------------------------------------------------
    | HEADER ACTIONS
    |--------------------------------------------------------------------------
    */

    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make()

                ->visible(
                    fn ($record) =>
                        ItRequestResource::canDelete(
                            $record
                        )
                ),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI SEBELUM SAVE
    |--------------------------------------------------------------------------
    |
    | Ini adalah pengaman server-side.
    |
    | Jangan hanya mengandalkan disabled() pada form,
    | karena disabled pada UI bukan security boundary.
    |
    */

    protected function mutateFormDataBeforeSave(
        array $data
    ): array {

        $record =
            $this->record;

        /*
        |--------------------------------------------------------------------------
        | STATUS LAMA
        |--------------------------------------------------------------------------
        */

        $oldStatus =
            $record->Status;

        /*
        |--------------------------------------------------------------------------
        | STATUS BARU DARI FORM
        |--------------------------------------------------------------------------
        */

        $newStatus =
            $data['Status']
            ?? $oldStatus;

        /*
        |--------------------------------------------------------------------------
        | STATUS APPROVAL
        |--------------------------------------------------------------------------
        */

        $approvalStatus =
            $record
                ->approval
                ?->status;

        /*
        |--------------------------------------------------------------------------
        | BELUM APPROVED
        |--------------------------------------------------------------------------
        |
        | Kalau approval masih pending / belum ada,
        | Admin/Staff IT tidak boleh mengubah status.
        |
        */

        if (
            $approvalStatus !== 'approved'
            &&
            $newStatus !== $oldStatus
        ) {

            Notification::make()
                ->danger()
                ->title(
                    'Status tidak dapat diubah'
                )
                ->body(
                    match ($approvalStatus) {

                        'pending' =>
                            'Permintaan masih menunggu persetujuan Kepala Bagian.',

                        'rejected' =>
                            'Permintaan telah ditolak oleh Kepala Bagian.',

                        default =>
                            'Permintaan belum mendapatkan persetujuan Kepala Bagian.',

                    }
                )
                ->persistent()
                ->send();

            /*
            |--------------------------------------------------------------------------
            | KEMBALIKAN STATUS LAMA
            |--------------------------------------------------------------------------
            */

            $data['Status'] =
                $oldStatus;

        }

        /*
        |--------------------------------------------------------------------------
        | APPROVAL REJECTED
        |--------------------------------------------------------------------------
        |
        | Jika sudah ditolak, jangan izinkan IT mengubah
        | status menjadi diproses/selesai.
        |
        */

        if (
            $approvalStatus === 'rejected'
            &&
            in_array(
                $newStatus,
                [
                    'diproses',
                    'selesai',
                ],
                true
            )
        ) {

            Notification::make()
                ->danger()
                ->title(
                    'Request ditolak'
                )
                ->body(
                    'Request yang ditolak Kepala Bagian tidak dapat diproses oleh IT.'
                )
                ->persistent()
                ->send();

            $data['Status'] =
                $oldStatus;

        }

        /*
        |--------------------------------------------------------------------------
        | APPROVAL APPROVED
        |--------------------------------------------------------------------------
        |
        | Kalau approved, Admin/Staff IT boleh memproses.
        |
        */

        if (
            $approvalStatus === 'approved'
            &&
            in_array(
                $newStatus,
                [
                    'disetujui',
                    'diproses',
                    'selesai',
                    'dibatalkan',
                ],
                true
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | PENYELESAI
            |--------------------------------------------------------------------------
            |
            | Jika status berubah untuk diproses/selesai,
            | otomatis isi user yang sedang login.
            |
            */

            if (
                in_array(
                    $newStatus,
                    [
                        'diproses',
                        'selesai',
                    ],
                    true
                )
                &&
                auth()->check()
            ) {

                $data['UserPenyelesaiID'] =
                    auth()->id();

            }

            /*
            |--------------------------------------------------------------------------
            | TANGGAL SELESAI
            |--------------------------------------------------------------------------
            */

            if (
                $newStatus === 'selesai'
            ) {

                $data['TanggalSelesai'] =
                    $data['TanggalSelesai']
                    ?? now()->format('Y-m-d');

            }

        }

        return $data;
    }
}
