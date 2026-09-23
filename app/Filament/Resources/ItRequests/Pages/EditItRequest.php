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
    | CEK APPROVAL DITOLAK
    |--------------------------------------------------------------------------
    |
    | Jika approval sudah rejected:
    | - Staff IT tidak boleh mengedit request
    | - super_admin tetap boleh
    |
    */

    protected function isRejectedAndLocked(): bool
    {
        if (
            $this->isSuperAdmin()
        ) {
            return false;
        }

        return
            $this->record
                ?->approval
                ?->status === 'rejected';
    }

    /*
    |--------------------------------------------------------------------------
    | CEK REQUEST TERKUNCI
    |--------------------------------------------------------------------------
    |
    | Request terkunci jika:
    |
    | 1. Sudah selesai
    | ATAU
    | 2. Approval ditolak
    |
    */

    protected function isRequestLocked(): bool
    {
        return
            $this->isCompletedAndLocked()
            ||
            $this->isRejectedAndLocked();
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
                | REQUEST TERKUNCI TIDAK BOLEH DIHAPUS
                |--------------------------------------------------------------------------
                |
                | super_admin tetap boleh.
                |
                */

                ->disabled(
                    fn (): bool =>
                        $this->isRequestLocked()
                )

                ->visible(
                    fn ($record) =>
                        ItRequestResource::canDelete(
                            $record
                        )
                )

                ->before(
                    function (): void {

                        /*
                        |--------------------------------------------------------------------------
                        | REQUEST SUDAH SELESAI
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
                                    'Request yang sudah selesai tidak dapat dihapus. Hanya super_admin yang dapat mengubah atau menghapus request ini.'
                                )
                                ->persistent()
                                ->send();

                            $this->halt();
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | APPROVAL DITOLAK
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $this->isRejectedAndLocked()
                        ) {

                            Notification::make()
                                ->danger()
                                ->title(
                                    'Request telah ditolak'
                                )
                                ->body(
                                    'Request yang telah ditolak oleh Kepala Bagian tidak dapat dihapus atau diedit oleh Staff IT. Hanya super_admin yang dapat mengubah atau menghapus request ini.'
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
    | Jika request sudah selesai atau approval sudah rejected,
    | Staff IT tidak dapat melakukan perubahan apa pun.
    |
    */

    protected function mutateFormDataBeforeSave(
        array $data
    ): array {

        $record =
            $this->record;

        /*
        |--------------------------------------------------------------------------
        | REQUEST SUDAH SELESAI
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

            $this->halt();
        }

        /*
        |--------------------------------------------------------------------------
        | APPROVAL SUDAH DITOLAK
        |--------------------------------------------------------------------------
        |
        | Ini dibuat sebagai LOCK PENUH.
        |
        | Jadi bukan hanya Status yang tidak boleh diubah.
        | Field lain juga tidak boleh disimpan oleh Staff IT.
        |
        */

        if (
            $this->isRejectedAndLocked()
        ) {

            Notification::make()
                ->danger()
                ->title(
                    'Request telah ditolak'
                )
                ->body(
                    'Request yang telah ditolak oleh Kepala Bagian tidak dapat diedit lagi oleh Staff IT. Hanya super_admin yang dapat mengubahnya.'
                )
                ->persistent()
                ->send();

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

            $data['Status'] =
                $oldStatus;
        }

        /*
        |--------------------------------------------------------------------------
        | APPROVAL REJECTED
        |--------------------------------------------------------------------------
        |
        | Pengaman tambahan.
        |
        | Normalnya blok ini sudah tidak akan tercapai karena
        | isRejectedAndLocked() di atas sudah menghentikan save.
        |
        */

        if (
            $approvalStatus === 'rejected'
        ) {

            Notification::make()
                ->danger()
                ->title(
                    'Request ditolak'
                )
                ->body(
                    'Request yang ditolak Kepala Bagian tidak dapat diproses atau diedit oleh Staff IT.'
                )
                ->persistent()
                ->send();

            $this->halt();
        }

        /*
        |--------------------------------------------------------------------------
        | APPROVAL APPROVED
        |--------------------------------------------------------------------------
        |
        | Kalau approved, Admin/Staff IT hanya boleh memilih:
        |
        | - diproses
        | - selesai
        | - dibatalkan
        |
        | Status:
        | - diajukan
        | - disetujui
        | - ditolak
        |
        | tidak boleh dipilih lagi.
        |
        */

        if (
            $approvalStatus === 'approved'
            &&
            in_array(
                $newStatus,
                [
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

        /*
        |--------------------------------------------------------------------------
        | CEGAH STATUS TIDAK VALID SETELAH APPROVED
        |--------------------------------------------------------------------------
        |
        | Ini penting sebagai pengaman server-side.
        |
        */

        if (
            $approvalStatus === 'approved'
            &&
            $newStatus !== $oldStatus
            &&
            !in_array(
                $newStatus,
                [
                    'diproses',
                    'selesai',
                    'dibatalkan',
                ],
                true
            )
        ) {

            Notification::make()
                ->danger()
                ->title(
                    'Status tidak dapat dipilih'
                )
                ->body(
                    'Setelah disetujui Kepala Bagian, status hanya dapat diubah menjadi Diproses, Selesai, atau Dibatalkan.'
                )
                ->persistent()
                ->send();

            $data['Status'] =
                $oldStatus;
        }

        return $data;
    }
}
