<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItRequestRequest;
use App\Models\ItRequest;
use App\Models\ItRequestApproval;
use App\Models\MstAsset;
use App\Models\MstJenisPermintaan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ItRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $user = auth()->user();

        $query = ItRequest::query()
            ->with([
                'pemohon.karyawan.departemen',
                'penyelesai.karyawan',
                'jenisPermintaan',
                'assets',
                'relatedUsers.karyawan.departemen',
                'approval.kepalaBagian',
            ]);

        if (!$user->hasAnyRole([
            'staff_it',
            'super_admin',
        ])) {
            $query->where(function ($query) use ($user) {

                // Request sendiri
                $query->where(
                    'UserPemohonID',
                    $user->id
                );

                // Request dimana user menjadi related user
                $query->orWhereHas(
                    'relatedUsers',
                    function ($query) use ($user) {
                        $query->where(
                            'users.id',
                            $user->id
                        );
                    }
                );
            });
        }

        $requests = $query
            ->latest('IDRequest')
            ->paginate(15)
            ->withQueryString();

        return view(
            'it_requests.index',
            compact('requests')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $jenisPermintaans = MstJenisPermintaan::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $assets = MstAsset::query()
            ->orderBy('NoAssetIT')
            ->get();

        $users = User::query()
            ->whereNotNull('NIK')
            ->with([
                'karyawan.departemen',
                'kepalaBagian',
            ])
            ->orderBy('name')
            ->get();

        return view(
            'it_requests.create',
            compact(
                'jenisPermintaans',
                'assets',
                'users'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(
        StoreItRequestRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $user = $request->user();

        $kepalaBagian = $user->kepalaBagian;

        if (!$kepalaBagian) {
            return back()
                ->withInput()
                ->withErrors([
                    'Permintaan' =>
                        'User Anda belum memiliki Kepala Bagian. ' .
                        'Silakan hubungi Super Admin sebelum mengajukan permintaan IT.',
                ]);
        }

        $requestModel = DB::transaction(
            function () use (
                $validated,
                $user,
                $kepalaBagian
            ) {
                $requestModel = ItRequest::create([
                    'NoRequest' =>
                        'TEMP-' . uniqid(),

                    'UserPemohonID' =>
                        $user->id,

                    'Permintaan' =>
                        $validated['Permintaan'],

                    'Keterangan' =>
                        $validated['Keterangan'] ?? null,

                    'Status' =>
                        'diajukan',
                ]);

                $requestModel->update([
                    'NoRequest' =>
                        'IT-' .
                        now()->format('Ymd') .
                        '-' .
                        str_pad(
                            (string) $requestModel->IDRequest,
                            6,
                            '0',
                            STR_PAD_LEFT
                        ),
                ]);

                // Jenis permintaan
                $requestModel
                    ->jenisPermintaan()
                    ->sync(
                        $validated['jenis_permintaan']
                    );

                // Asset
                $requestModel
                    ->assets()
                    ->sync(
                        $validated['assets'] ?? []
                    );

                // User terkait
                $requestModel
                    ->relatedUsers()
                    ->sync(
                        $validated['related_users'] ?? []
                    );

                // Approval Kepala Bagian
                ItRequestApproval::create([
                    'it_request_id' =>
                        $requestModel->IDRequest,

                    'kepala_bagian_id' =>
                        $kepalaBagian->id,

                    'status' =>
                        ItRequestApproval::STATUS_PENDING,

                    'catatan' =>
                        null,

                    'approved_at' =>
                        null,
                ]);

                return $requestModel;
            }
        );

        return redirect()
            ->route(
                'it-requests.show',
                $requestModel
            )
            ->with(
                'success',
                'Permintaan IT berhasil diajukan dan menunggu persetujuan Kepala Bagian.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(
        ItRequest $itRequest
    ): View {
        $user = auth()->user();

        $allowed =
            $itRequest->UserPemohonID === $user->id
            ||
            $itRequest
                ->relatedUsers()
                ->where('users.id', $user->id)
                ->exists();

        if (
            !$allowed
            &&
            !$user->hasAnyRole([
                'staff_it',
                'super_admin',
            ])
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK PEMOHON + STATUS UNTUK EDIT / DELETE
        |--------------------------------------------------------------------------
        |
        | Sama persis dengan logic pada index:
        |
        | Hanya pemohon asli
        | DAN
        | status masih "diajukan"
        |
        */

        $isPemohon =
            (int) $itRequest->UserPemohonID ===
            (int) $user->id;

        $canModify =
            $isPemohon &&
            strtolower(
                (string) $itRequest->Status
            ) === 'diajukan';

        $itRequest->load([
            'pemohon.karyawan.departemen',
            'pemohon.kepalaBagian',
            'penyelesai.karyawan',
            'jenisPermintaan',
            'assets',
            'relatedUsers.karyawan.departemen',
            'approval.kepalaBagian',
        ]);

        return view(
            'it_requests.show',
            compact(
                'itRequest',
                'canModify'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    |
    | Hanya PEMOHON asli yang boleh mengakses halaman edit.
    |
    | Syarat:
    | 1. User login adalah pemohon.
    | 2. Status request harus "diajukan".
    |
    | User terkait TIDAK memiliki akses edit.
    | Staff IT dan Super Admin juga tidak otomatis memiliki akses edit.
    |
    */

    public function edit(
        ItRequest $itRequest
    ): View {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | CEK PEMOHON
        |--------------------------------------------------------------------------
        */

        if (
            $itRequest->UserPemohonID !== $user->id
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK STATUS
        |--------------------------------------------------------------------------
        |
        | Hanya request dengan status "diajukan"
        | yang dapat diedit.
        |
        */

        if (
            strtolower(
                (string) $itRequest->Status
            ) !== 'diajukan'
        ) {
            abort(
                403,
                'Permintaan IT ini sudah tidak dapat diedit karena statusnya bukan lagi diajukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA FORM
        |--------------------------------------------------------------------------
        */

        $jenisPermintaans = MstJenisPermintaan::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $assets = MstAsset::query()
            ->orderBy('NoAssetIT')
            ->get();

        $users = User::query()
            ->whereNotNull('NIK')
            ->where(
                'id',
                '!=',
                $user->id
            )
            ->with([
                'karyawan.departemen',
                'kepalaBagian',
            ])
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | LOAD RELATION YANG DIPERLUKAN
        |--------------------------------------------------------------------------
        */

        $itRequest->load([
            'jenisPermintaan',
            'assets',
            'relatedUsers',
        ]);

        return view(
            'it_requests.edit',
            compact(
                'itRequest',
                'jenisPermintaans',
                'assets',
                'users'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    |
    | Hanya PEMOHON asli dan hanya ketika status "diajukan".
    |
    */

    public function update(
        StoreItRequestRequest $request,
        ItRequest $itRequest
    ): RedirectResponse {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | CEK PEMOHON
        |--------------------------------------------------------------------------
        */

        if (
            $itRequest->UserPemohonID !== $user->id
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK STATUS
        |--------------------------------------------------------------------------
        |
        | Tidak boleh mengubah request yang sudah:
        | - disetujui
        | - ditolak
        | - diproses
        | - selesai
        | - atau status lainnya.
        |
        */

        if (
            strtolower(
                (string) $itRequest->Status
            ) !== 'diajukan'
        ) {
            return back()
                ->with(
                    'error',
                    'Permintaan IT hanya dapat diedit ketika status masih diajukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | UPDATE DALAM TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $validated,
                $itRequest,
                $user
            ) {

                /*
                |--------------------------------------------------------------------------
                | UPDATE DATA UTAMA
                |--------------------------------------------------------------------------
                */

                $itRequest->update([
                    'Permintaan' =>
                        $validated['Permintaan'],

                    'Keterangan' =>
                        $validated['Keterangan'] ?? null,

                    /*
                    |--------------------------------------------------------------------------
                    | Pastikan pemohon tidak pernah berubah
                    |--------------------------------------------------------------------------
                    */

                    'UserPemohonID' =>
                        $user->id,

                    /*
                    |--------------------------------------------------------------------------
                    | Status tetap diajukan
                    |--------------------------------------------------------------------------
                    */

                    'Status' =>
                        'diajukan',
                ]);

                /*
                |--------------------------------------------------------------------------
                | UPDATE JENIS PERMINTAAN
                |--------------------------------------------------------------------------
                */

                $itRequest
                    ->jenisPermintaan()
                    ->sync(
                        $validated['jenis_permintaan']
                    );

                /*
                |--------------------------------------------------------------------------
                | UPDATE ASSET
                |--------------------------------------------------------------------------
                */

                $itRequest
                    ->assets()
                    ->sync(
                        $validated['assets'] ?? []
                    );

                /*
                |--------------------------------------------------------------------------
                | UPDATE USER TERKAIT
                |--------------------------------------------------------------------------
                */

                /*
                | User pemohon sendiri tidak dimasukkan
                | sebagai related user.
                */

                $relatedUsers =
                    collect(
                        $validated['related_users'] ?? []
                    )
                    ->reject(
                        fn ($id) =>
                            (int) $id === (int) $user->id
                    )
                    ->values()
                    ->all();

                $itRequest
                    ->relatedUsers()
                    ->sync(
                        $relatedUsers
                    );
            }
        );

        return redirect()
            ->route(
                'it-requests.show',
                $itRequest
            )
            ->with(
                'success',
                'Permintaan IT berhasil diperbarui.'
            );
    }

    /*
|--------------------------------------------------------------------------
| SERAH TERIMA
|--------------------------------------------------------------------------
|
| Pemohon melakukan konfirmasi bahwa request sudah diterima.
|
| Syarat:
|
| 1. User harus login.
| 2. User harus merupakan pemohon asli.
| 3. Status request harus selesai.
| 4. Request belum pernah dikonfirmasi sebelumnya.
|
| TanggalSerahTerima tidak berasal dari form.
| Sistem otomatis mengisi dengan now().
|
*/

public function serahTerima(
    ItRequest $itRequest
): RedirectResponse {
    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | CEK PEMOHON
    |--------------------------------------------------------------------------
    |
    | Hanya user yang membuat request yang boleh melakukan
    | konfirmasi serah terima.
    |
    */

    if (
        (int) $itRequest->UserPemohonID !==
        (int) $user->id
    ) {
        abort(
            403,
            'Anda tidak memiliki hak untuk melakukan konfirmasi serah terima pada permintaan ini.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK STATUS
    |--------------------------------------------------------------------------
    |
    | Serah terima hanya dapat dilakukan apabila request
    | sudah selesai.
    |
    */

    if (
        !in_array(
            strtolower((string) $itRequest->Status),
            [
                'selesai',
                'completed',
                'done',
            ],
            true
        )
    ) {
        return back()
            ->with(
                'error',
                'Serah terima hanya dapat dilakukan setelah permintaan berstatus selesai.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK SUDAH SERAH TERIMA
    |--------------------------------------------------------------------------
    |
    | Mencegah request dikonfirmasi berkali-kali.
    |
    */

    if ($itRequest->SerahTerima === true) {
        return back()
            ->with(
                'error',
                'Permintaan ini sudah dikonfirmasi serah terima sebelumnya.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN SERAH TERIMA
    |--------------------------------------------------------------------------
    |
    | Tidak ada tanggal dari input user.
    |
    | Sistem otomatis:
    |
    | SerahTerima        = true
    | TanggalSerahTerima = now()
    |
    */

    $itRequest->update([
        'SerahTerima' => true,
        'TanggalSerahTerima' => now(),
    ]);

    return redirect()
        ->route(
            'it-requests.show',
            $itRequest
        )
        ->with(
            'success',
            'Serah terima berhasil dikonfirmasi. Terima kasih.'
        );
}


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    |
    | Hanya PEMOHON asli dan hanya ketika status "diajukan".
    |
    */

    public function destroy(
        ItRequest $itRequest
    ): RedirectResponse {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | CEK PEMOHON
        |--------------------------------------------------------------------------
        */

        if (
            $itRequest->UserPemohonID !== $user->id
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK STATUS
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                (string) $itRequest->Status
            ) !== 'diajukan'
        ) {
            return back()
                ->with(
                    'error',
                    'Permintaan IT hanya dapat dihapus ketika status masih diajukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use ($itRequest) {

                /*
                |--------------------------------------------------------------------------
                | Hapus relasi terlebih dahulu
                |--------------------------------------------------------------------------
                |
                | Ini penting apabila tabel pivot tidak menggunakan
                | foreign key cascade.
                |
                */

                $itRequest
                    ->jenisPermintaan()
                    ->detach();

                $itRequest
                    ->assets()
                    ->detach();

                $itRequest
                    ->relatedUsers()
                    ->detach();

                /*
                |--------------------------------------------------------------------------
                | Hapus approval
                |--------------------------------------------------------------------------
                */

                ItRequestApproval::query()
                    ->where(
                        'it_request_id',
                        $itRequest->IDRequest
                    )
                    ->delete();

                /*
                |--------------------------------------------------------------------------
                | Hapus request utama
                |--------------------------------------------------------------------------
                */

                $itRequest->delete();
            }
        );

        return redirect()
            ->route('it-requests.index')
            ->with(
                'success',
                'Permintaan IT berhasil dihapus.'
            );
    }
}
