<?php

namespace App\Filament\Resources\UserManagements\Pages;

use App\Filament\Resources\UserManagements\UserManagementResource;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

use Spatie\Permission\PermissionRegistrar;


class EditUserManagement extends EditRecord
{
    protected static string $resource =
        UserManagementResource::class;


    protected array $selectedRole = [];


    protected array $selectedPermissions = [];


    protected array $oldPermissions = [];


    protected ?string $oldRole = null;


    /**
     * ==========================================================
     * BEFORE FILL
     * ==========================================================
     */

    protected function mutateFormDataBeforeFill(
        array $data
    ): array {

        /**
         * ======================================================
         * ROLE
         * ======================================================
         */

        $this->oldRole =
            $this->record
                ->roles()
                ->where(
                    'guard_name',
                    'web'
                )
                ->value('name');


        $data['role'] =
            $this->oldRole
            ?? 'user';


        /**
         * ======================================================
         * DIRECT PERMISSION
         * ======================================================
         *
         * Hanya permission yang langsung dimiliki user.
         *
         * Bukan permission dari role.
         */

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

        $this->selectedRole = [

            (string) (
                $data['role']
                ?? 'user'
            ),

        ];


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
            $data['role'],
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
                    'Super Admin tidak dapat dikelola melalui halaman ini.'
                )

                ->danger()

                ->send();

            return;
        }


        /**
         * ======================================================
         * ROLE
         * ======================================================
         */

        $role =
            collect(
                $this->selectedRole
            )
                ->first();


        if (
            $role === 'super_admin'
            || blank($role)
        ) {

            $role = 'user';
        }


        $this->record->syncRoles([
            $role,
        ]);


        /**
         * ======================================================
         * PERMISSION
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
         * OLD / NEW ROLE
         * ======================================================
         */

        $oldRole =
            $this->oldRole;


        $newRole =
            $role;


        /**
         * ======================================================
         * OLD / NEW PERMISSION
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

                ->diff(
                    $oldPermissions
                )

                ->values()

                ->toArray();


        /**
         * ======================================================
         * REMOVED
         * ======================================================
         */

        $removed =
            $oldPermissions

                ->diff(
                    $newPermissions
                )

                ->values()

                ->toArray();


        /**
         * ======================================================
         * ACTIVITY LOG
         * ======================================================
         */

        if (
            $oldRole !== $newRole
            || count($added) > 0
            || count($removed) > 0
        ) {

            activity('user_management')

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

                    'old_role' =>
                        $oldRole,

                    'new_role' =>
                        $newRole,

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
                    'User role dan permission diperbarui'
                );
        }


        /**
         * ======================================================
         * NOTIFICATION
         * ======================================================
         */

        Notification::make()

            ->title(
                'User berhasil diperbarui'
            )

            ->body(
                'Role dan permission user berhasil disimpan.'
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
        return 'Edit User: ' .
            $this->record->name;
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
