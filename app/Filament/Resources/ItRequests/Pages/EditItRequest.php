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
    | CEK SUPER ADMIN
    |--------------------------------------------------------------------------
    */

    protected function isSuperAdmin(): bool
    {
        return
            auth()->check()
            &&
            auth()->user()->hasRole(
                'super_admin'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK REQUEST SUDAH SELESAI
    |--------------------------------------------------------------------------
    */

    protected function isCompletedAndLocked(): bool
    {
        if (
            $this->isSuperAdmin()
        ) {
            return false;
        }

        return
            $this->record?->Status === 'selesai';
    }

    /*
    |--------------------------------------------------------------------------
    | HEADER ACTIONS
    |--------------------------------------------------------------------------
    */

    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make()

                /*
                |--------------------------------------------------------------------------
                | REQUEST SELESAI TIDAK BOLEH DIHAPUS
                |--------------------------------------------------------------------------
                |
                | super_admin tetap boleh.
                |
                */

                ->disabled(
                    fn (): bool =>
                        $this->isCompletedAndLocked()
                )

                ->visible(
                    fn ($record) =>
                        ItRequestResource::canDelete(
                            $record
                        )
                )

                ->before(
                    function (): void {

                        if (
                            $this->isCompletedAndLocked()
                        ) {

                            Notification::make()
                                ->danger()
                                ->title(
                                    'Request sudah selesai'
                                )
                                ->body(
                                    'Request yang sudah selesai tidak dapat dihapus. Hanya super_admin yang dapat mengubah atau menghapus request ini.'
                                )
                                ->persistent()
                                ->send();

                            $this->halt();
                        }
                    }
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
    | Jika request sudah selesai dan bukan super_admin,
    | proses save dihentikan sepenuhnya.
    |
    */

    protected function mutateFormDataBeforeSave(
        array $data
    ): array {

        $record =
            $this->record;

        /*
        |--------------------------------------------------------------------------
        | LOCK REQUEST YANG SUDAH SELESAI
        |--------------------------------------------------------------------------
        */

        if (
            $this->isCompletedAndLocked()
        ) {

            Notification::make()
                ->danger()
                ->title(
                    'Request sudah selesai'
                )
                ->body(
                    'Request yang sudah selesai tidak dapat diedit lagi. Hanya super_admin yang dapat mengubahnya.'
                )
                ->persistent()
                ->send();

            /*
            |--------------------------------------------------------------------------
            | HALT SAVE
            |--------------------------------------------------------------------------
            */

            $this->halt();
        }

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
