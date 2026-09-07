<?php

namespace App\Filament\Resources\UserPermissions\Pages;

use App\Filament\Resources\UserPermissions\UserPermissionResource;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

use Spatie\Permission\PermissionRegistrar;


class EditUserPermission extends EditRecord
{
    protected static string $resource =
        UserPermissionResource::class;


    protected array $selectedPermissions = [];


    protected array $oldPermissions = [];


    /**
     * ==========================================================
     * BEFORE FILL
     * ==========================================================
     */

    protected function mutateFormDataBeforeFill(
        array $data
    ): array {

        $this->oldPermissions =
            $this->record
                ->getDirectPermissions()
                ->pluck('name')
                ->sort()
                ->values()
                ->toArray();


        $data['permissions'] =
            $this->oldPermissions;


        return $data;
    }


    /**
     * ==========================================================
     * BEFORE SAVE
     * ==========================================================
     */

    protected function mutateFormDataBeforeSave(
        array $data
    ): array {

        $this->selectedPermissions =
            collect(
                $data['permissions'] ?? []
            )
                ->map(
                    fn ($permission) =>
                        (string) $permission
                )
                ->sort()
                ->values()
                ->toArray();


        unset(
            $data['permissions']
        );


        return $data;
    }


    /**
     * ==========================================================
     * AFTER SAVE
     * ==========================================================
     */

    protected function afterSave(): void
    {
        /**
         * ======================================================
         * SECURITY
         * ======================================================
         */

        if (
            $this->record
                ->hasRole('super_admin')
        ) {

            Notification::make()
                ->title(
                    'Tidak dapat mengubah Super Admin'
                )
                ->body(
                    'Super Admin memiliki akses penuh secara otomatis.'
                )
                ->danger()
                ->send();

            return;
        }


        /**
         * ======================================================
         * SYNC
         * ======================================================
         */

        $this->record->syncPermissions(
            $this->selectedPermissions
        );


        /**
         * ======================================================
         * CLEAR CACHE
         * ======================================================
         */

        app(
            PermissionRegistrar::class
        )->forgetCachedPermissions();


        /**
         * ======================================================
         * OLD / NEW
         * ======================================================
         */

        $oldPermissions =
            collect(
                $this->oldPermissions
            );


        $newPermissions =
            collect(
                $this->selectedPermissions
            );


        /**
         * ======================================================
         * ADDED
         * ======================================================
         */

        $added =
            $newPermissions
                ->diff($oldPermissions)
                ->values()
                ->toArray();


        /**
         * ======================================================
         * REMOVED
         * ======================================================
         */

        $removed =
            $oldPermissions
                ->diff($newPermissions)
                ->values()
                ->toArray();


        /**
         * ======================================================
         * ACTIVITY LOG
         * ======================================================
         */

        if (
            count($added) > 0 ||
            count($removed) > 0
        ) {

            activity('permission')
                ->causedBy(
                    auth()->user()
                )
                ->performedOn(
                    $this->record
                )
                ->withProperties([

                    'user_id' =>
                        $this->record->id,

                    'user_name' =>
                        $this->record->name,

                    'user_email' =>
                        $this->record->email,

                    'old_permissions' =>
                        $oldPermissions
                            ->values()
                            ->toArray(),

                    'new_permissions' =>
                        $newPermissions
                            ->values()
                            ->toArray(),

                    'added' =>
                        $added,

                    'removed' =>
                        $removed,

                    'ip_address' =>
                        request()->ip(),

                    'user_agent' =>
                        request()->userAgent(),

                ])
                ->log(
                    'Permission user diperbarui'
                );
        }


        /**
         * ======================================================
         * NOTIFICATION
         * ======================================================
         */

        Notification::make()
            ->title(
                'Hak akses berhasil diperbarui'
            )
            ->body(
                'Permission user telah berhasil disimpan.'
            )
            ->success()
            ->send();
    }


    /**
     * ==========================================================
     * TITLE
     * ==========================================================
     */

    public function getTitle(): string
    {
        return 'Atur Hak Akses: ' .
            $this->record->name;
    }


    /**
     * ==========================================================
     * HEADER
     * ==========================================================
     */

    protected function getHeaderActions(): array
    {
        return [];
    }
}
