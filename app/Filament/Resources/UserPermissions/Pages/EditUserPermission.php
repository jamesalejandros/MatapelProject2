<?php

namespace App\Filament\Resources\UserPermissions\Pages;

use App\Filament\Resources\UserPermissions\UserPermissionResource;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;


class EditUserPermission extends EditRecord
{
    protected static string $resource =
        UserPermissionResource::class;


    /**
     * ==========================================================
     * PERMISSION YANG AKAN DI-SYNC
     * ==========================================================
     *
     * Field "permissions" bukan kolom di tabel users.
     *
     * Kita simpan sementara permission yang dipilih
     * sebelum proses save dijalankan.
     */

    protected array $selectedPermissions = [];


    /**
     * ==========================================================
     * MUTATE FORM DATA BEFORE SAVE
     * ==========================================================
     */

    protected function mutateFormDataBeforeSave(
        array $data
    ): array {

        $this->selectedPermissions =
            $data['permissions'] ?? [];


        /**
         * "permissions" bukan kolom users.
         *
         * Jangan sampai Laravel mencoba menyimpannya
         * ke tabel users.
         */
        unset($data['permissions']);


        return $data;
    }


    /**
     * ==========================================================
     * AFTER SAVE
     * ==========================================================
     *
     * Setelah user berhasil disimpan, permission user
     * langsung disinkronkan menggunakan Spatie Permission.
     */

    protected function afterSave(): void
    {
        /**
         * ======================================================
         * SECURITY
         * ======================================================
         *
         * Super admin tidak boleh diubah permission-nya.
         *
         * Super admin mendapatkan akses penuh melalui
         * Gate::before().
         */
        if ($this->record->hasRole('super_admin')) {

            Notification::make()
                ->title('Tidak dapat mengubah Super Admin')
                ->body(
                    'Super Admin memiliki akses penuh secara otomatis.'
                )
                ->danger()
                ->send();

            return;
        }


        /**
         * ======================================================
         * SYNC PERMISSION
         * ======================================================
         *
         * syncPermissions() akan:
         *
         * - menambahkan permission yang dicentang
         * - menghapus permission yang tidak dicentang
         * - mempertahankan hanya permission yang dipilih
         */

        $this->record->syncPermissions(
            $this->selectedPermissions
        );


        /**
         * ======================================================
         * CLEAR SPATIE CACHE
         * ======================================================
         */

        app(
            \Spatie\Permission\PermissionRegistrar::class
        )->forgetCachedPermissions();


        /**
         * ======================================================
         * NOTIFICATION
         * ======================================================
         */

        Notification::make()
            ->title('Hak akses berhasil diperbarui')
            ->body(
                'Permission user telah berhasil disimpan.'
            )
            ->success()
            ->send();
    }


    /**
     * ==========================================================
     * PAGE TITLE
     * ==========================================================
     */

    public function getTitle(): string
    {
        return 'Atur Hak Akses: ' .
            $this->record->name;
    }


    /**
     * ==========================================================
     * MUTATE FORM DATA BEFORE FILL
     * ==========================================================
     *
     * Ketika halaman edit dibuka, ambil permission yang
     * saat ini dimiliki user.
     */

    protected function mutateFormDataBeforeFill(
        array $data
    ): array {

        $data['permissions'] =
            $this->record
                ->permissions
                ->pluck('name')
                ->toArray();


        return $data;
    }


    /**
     * ==========================================================
     * HEADER ACTIONS
     * ==========================================================
     */

    protected function getHeaderActions(): array
    {
        return [];
    }
}
