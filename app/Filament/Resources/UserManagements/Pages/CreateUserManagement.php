<?php

namespace App\Filament\Resources\UserManagements\Pages;

use App\Filament\Resources\UserManagements\UserManagementResource;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;


class CreateUserManagement extends CreateRecord
{
    protected static string $resource =
        UserManagementResource::class;


    protected array $selectedRole = [];


    protected array $selectedPermissions = [];


    /*
    |--------------------------------------------------------------------------
    | BEFORE CREATE
    |--------------------------------------------------------------------------
    */

    protected function mutateFormDataBeforeCreate(
        array $data
    ): array {

        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        $this->selectedRole = [

            (string) (
                $data['role']
                ?? 'user'
            ),

        ];


        /*
        |--------------------------------------------------------------------------
        | PERMISSION
        |--------------------------------------------------------------------------
        */

        $permissions = collect([

            ...(
                $data['permissions_mst']
                ?? []
            ),

            ...(
                $data['permissions_trx']
                ?? []
            ),

        ]);


        $this->selectedPermissions =
            $this->normalizePermissions(
                $permissions->toArray()
            );


        /*
        |--------------------------------------------------------------------------
        | HAPUS FIELD NON-USERS
        |--------------------------------------------------------------------------
        |
        | NIK dan kepala_bagian_id TIDAK dihapus.
        |
        | Keduanya adalah kolom valid pada tabel users.
        |
        |--------------------------------------------------------------------------
        */

        unset(

            $data['role'],

            $data['permissions_mst'],

            $data['permissions_trx']

        );


        return $data;
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE PERMISSIONS
    |--------------------------------------------------------------------------
    */

    protected function normalizePermissions(
        array $permissions
    ): array {

        return collect($permissions)

            ->map(
                function ($permission) {

                    /*
                    |--------------------------------------------------------------------------
                    | PERMISSION MODEL
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $permission
                            instanceof Permission
                    ) {

                        return $permission->name;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | DATABASE ID
                    |--------------------------------------------------------------------------
                    */

                    if (
                        is_numeric($permission)
                    ) {

                        return Permission::query()

                            ->where(
                                'guard_name',
                                'web'
                            )

                            ->whereKey(
                                $permission
                            )

                            ->value(
                                'name'
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PERMISSION NAME
                    |--------------------------------------------------------------------------
                    */

                    return (string) $permission;
                }
            )

            ->filter()

            ->unique()

            ->values()

            ->toArray();
    }


    /*
    |--------------------------------------------------------------------------
    | AFTER CREATE
    |--------------------------------------------------------------------------
    */

    protected function afterCreate(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        $role =
            collect(
                $this->selectedRole
            )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | SECURITY
        |--------------------------------------------------------------------------
        */

        if (
            $role === 'super_admin'
            || blank($role)
        ) {

            $role = 'user';
        }


        /*
        |--------------------------------------------------------------------------
        | ASSIGN ROLE
        |--------------------------------------------------------------------------
        */

        $this->record->syncRoles([

            $role,

        ]);


        /*
        |--------------------------------------------------------------------------
        | ASSIGN DIRECT PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $this->record->syncPermissions(

            $this->selectedPermissions

        );


        /*
        |--------------------------------------------------------------------------
        | CLEAR SPATIE CACHE
        |--------------------------------------------------------------------------
        */

        app(
            PermissionRegistrar::class
        )->forgetCachedPermissions();


        /*
        |--------------------------------------------------------------------------
        | ACTIVITY LOG
        |--------------------------------------------------------------------------
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

                'user_nik' =>
                    $this->record->NIK,

                'user_email' =>
                    $this->record->email,

                'kepala_bagian_id' =>
                    $this->record->kepala_bagian_id,

                'kepala_bagian_name' =>
                    $this->record
                        ->kepalaBagian
                        ?->name,

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


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION
        |--------------------------------------------------------------------------
        */

        Notification::make()

            ->title(
                'User berhasil dibuat'
            )

            ->body(
                'Akun user, NIK, Kepala Bagian, role, dan permission berhasil disimpan.'
            )

            ->success()

            ->send();
    }


    /*
    |--------------------------------------------------------------------------
    | TITLE
    |--------------------------------------------------------------------------
    */

    public function getTitle(): string
    {
        return 'Tambah User';
    }
}
