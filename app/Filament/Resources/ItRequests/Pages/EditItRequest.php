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
    |
    | HANYA super_admin yang boleh bypass lock.
    |
    | Permission seperti:
    | - itrequest.update
    | - itrequest.view
    |
    | TIDAK membuat user bebas dari business-rule lock.
    |
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
    |
    | Jika sudah selesai:
    |
    | - User biasa       => LOCK
    | - Staff IT         => LOCK
    | - Kepala Bagian    => LOCK
    | - User permission  => LOCK
    | - super_admin      => BOLEH BYPASS
    |
    */

    protected function isCompletedAndLocked(): bool
    {
        /*
        |--------------------------------------------------------------------------
        | HANYA SUPER ADMIN BOLEH BYPASS
        |--------------------------------------------------------------------------
        */

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
    |
    | - User biasa       => LOCK
    | - Staff IT         => LOCK
    | - Kepala Bagian    => LOCK
    | - User permission  => LOCK
    | - super_admin      => BOLEH BYPASS
    |
    */

    protected function isRejectedAndLocked(): bool
    {
        /*
        |--------------------------------------------------------------------------
        | HANYA SUPER ADMIN BOLEH BYPASS
        |--------------------------------------------------------------------------
        */

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
    | Permission tidak mempengaruhi lock.
    | Hanya super_admin yang dapat bypass.
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
                | Hanya super_admin yang dapat bypass lock.
                |
                */

                ->disabled(
                    fn (): bool =>
                        $this->isRequestLocked()
                )

                /*
                |--------------------------------------------------------------------------
                | PERMISSION DELETE TETAP DIHORMATI
                |--------------------------------------------------------------------------
                |
                | Permission menentukan apakah tombol delete boleh muncul.
                | Tetapi permission TIDAK membypass business-rule lock.
                |
                */

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
                                    'Request yang telah ditolak oleh Kepala Bagian tidak dapat dihapus atau diedit. Hanya super_admin yang dapat mengubah atau menghapus request ini.'
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
    | Server-side protection.
    |
    | Walaupun user mempunyai:
    |
    | itrequest.update
    |
    | user tetap TIDAK dapat menyimpan perubahan jika request
    | berada dalam kondisi yang terkunci.
    |
    | KECUALI super_admin.
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
        | LOCK PENUH.
        |
        | User yang memiliki permission itrequest.update sekalipun
        | tetap tidak dapat menyimpan perubahan.
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
                    'Request yang telah ditolak oleh Kepala Bagian tidak dapat diedit lagi. Hanya super_admin yang dapat mengubahnya.'
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
        | status tidak boleh diubah.
        |
        | Ini berlaku untuk:
        |
        | - Staff IT
        | - Kepala Bagian
        | - User dengan permission
        | - User biasa
        |
        | super_admin tetap mengikuti bypass khusus di atas.
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
        | Normalnya sudah dihentikan oleh isRejectedAndLocked().
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
                    'Request yang ditolak Kepala Bagian tidak dapat diproses atau diedit.'
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
        | Setelah approved, status hanya boleh:
        |
        | - diproses
        | - selesai
        | - dibatalkan
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
        | Setelah approval approved:
        |
        | Hanya:
        |
        | - diproses
        | - selesai
        | - dibatalkan
        |
        | yang diperbolehkan.
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
