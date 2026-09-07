<?php

namespace App\Filament\Resources\UserManagements\Pages;

use App\Filament\Resources\UserManagements\UserManagementResource;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

use Spatie\Permission\PermissionRegistrar;


class CreateUserManagement extends CreateRecord
{
    protected static string $resource =
        UserManagementResource::class;


    protected array $selectedRole = [];


    protected array $selectedPermissions = [];


    /**
     * ==========================================================
     * BEFORE CREATE
     * ==========================================================
     *
     * Role dan permission tidak disimpan langsung sebagai
     * kolom users.
     *
     * Kita keluarkan dari data user terlebih dahulu.
     */

    protected function mutateFormDataBeforeCreate(
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
     * AFTER CREATE
     * ==========================================================
     */

    protected function afterCreate(): void
    {
        /**
         * ======================================================
         * SECURITY
         * ======================================================
         *
         * Jangan pernah memberikan super_admin melalui
         * User Management.
         */

        $role =
            collect(
                $this->selectedRole
            )
                ->first();


        if (
            $role === 'super_admin'
        ) {

            $role = 'user';
        }


        /**
         * ======================================================
         * ROLE
         * ======================================================
         */

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
         * ACTIVITY LOG
         * ======================================================
         */

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

                'role' =>
                    $role,

                'permissions' =>
                    $this->selectedPermissions,

                'ip_address' =>
                    request()->ip(),

                'user_agent' =>
                    request()->userAgent(),

            ])

            ->log(
                'User baru dibuat'
            );


        /**
         * ======================================================
         * NOTIFICATION
         * ======================================================
         */

        Notification::make()

            ->title(
                'User berhasil dibuat'
            )

            ->body(
                'Akun user, role, dan permission berhasil disimpan.'
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
        return 'Tambah User';
    }
}
