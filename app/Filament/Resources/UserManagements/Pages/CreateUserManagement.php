<?php

namespace App\Filament\Resources\UserManagements\Pages;

use App\Filament\Resources\UserManagements\UserManagementResource;
use App\Models\MstKaryawan;

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
        | VALIDASI NIK
        |--------------------------------------------------------------------------
        |
        | NIK harus berasal dari master karyawan.
        |
        */

        if (
            blank($data['NIK'] ?? null)
        ) {

            Notification::make()
                ->title('Karyawan wajib dipilih')
                ->body(
                    'Silakan pilih karyawan terlebih dahulu.'
                )
                ->danger()
                ->send();

            return $data;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL KARYAWAN
        |--------------------------------------------------------------------------
        */

        $karyawan =
            MstKaryawan::query()
                ->with([
                    'kepalaBagian',
                    'departemen',
                    'perusahaan',
                ])
                ->where(
                    'NIK',
                    $data['NIK']
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | KARYAWAN TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (! $karyawan) {

            Notification::make()
                ->title('Karyawan tidak ditemukan')
                ->body(
                    'NIK yang dipilih tidak ditemukan pada Master Karyawan.'
                )
                ->danger()
                ->send();

            return $data;
        }


        /*
        |--------------------------------------------------------------------------
        | NAMA USER
        |--------------------------------------------------------------------------
        |
        | Nama user mengikuti nama karyawan.
        |
        */

        $data['name'] =
            $karyawan->Nama;


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
        | HAPUS FIELD FORM NON-USERS
        |--------------------------------------------------------------------------
        |
        | Field berikut hanya digunakan oleh form:
        |
        | - role
        | - permissions_mst
        | - permissions_trx
        |
        | Kepala Bagian TIDAK dihapus dari mstKaryawan karena
        | sekarang Kepala Bagian disimpan melalui:
        |
        | mstkaryawan.NIKKepalaBagian
        |
        */

        unset(

            $data['role'],

            $data['permissions_mst'],

            $data['permissions_trx'],

            /*
            |--------------------------------------------------------------------------
            | KEPALA BAGIAN LAMA
            |--------------------------------------------------------------------------
            |
            | Jika masih ada field ini dari form/cache lama,
            | jangan sampai masuk ke users.
            |
            */

            $data['kepala_bagian_id']

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
        | AMBIL KARYAWAN + KEPALA BAGIAN
        |--------------------------------------------------------------------------
        |
        | Kepala Bagian sekarang berasal dari:
        |
        | users.NIK
        |      ↓
        | mstkaryawan.NIK
        |      ↓
        | mstkaryawan.NIKKepalaBagian
        |      ↓
        | mstkaryawan.NIK
        |
        */

        $karyawan =
            MstKaryawan::query()
                ->with([
                    'kepalaBagian',
                    'departemen',
                    'perusahaan',
                ])
                ->where(
                    'NIK',
                    $this->record->NIK
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | DATA KEPALA BAGIAN
        |--------------------------------------------------------------------------
        */

        $kepalaBagian =
            $karyawan
                ?->kepalaBagian;


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

                /*
                |--------------------------------------------------------------------------
                | KEPALA BAGIAN
                |--------------------------------------------------------------------------
                |
                | Tidak lagi menggunakan:
                |
                | users.kepala_bagian_id
                |
                | tetapi:
                |
                | mstkaryawan.NIKKepalaBagian
                |
                */

                'kepala_bagian_nik' =>
                    $karyawan
                        ?->NIKKepalaBagian,

                'kepala_bagian_name' =>
                    $kepalaBagian
                        ?->Nama,

                'kepala_bagian_email' =>
                    $kepalaBagian
                        ?->user
                        ?->email,

                'departemen' =>
                    $karyawan
                        ?->departemen
                        ?->NamaDept,

                'perusahaan' =>
                    $karyawan
                        ?->perusahaan
                        ?->NamaPerusahaan,

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

        $kepalaBagianText =
            $kepalaBagian
                ?->Nama
            ?? 'Belum ditentukan';


        Notification::make()

            ->title(
                'User berhasil dibuat'
            )

            ->body(
                'Akun user berhasil dibuat. Kepala Bagian: '
                . $kepalaBagianText
                . '.'
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
