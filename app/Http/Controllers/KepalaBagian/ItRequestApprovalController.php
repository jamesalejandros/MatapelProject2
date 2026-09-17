<?php
namespace App\Http\Controllers\KepalaBagian;

use App\Http\Controllers\Controller;
use App\Models\ItRequest;
use App\Models\ItRequestApproval;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ItRequestApprovalController extends Controller
{
/*
|--------------------------------------------------------------------------
| INDEX
|--------------------------------------------------------------------------
|
| Menampilkan semua request dari user yang berada
| di bawah Kepala Bagian yang sedang login.
|
| Semua user menggunakan guard "web".
| Kepala Bagian dibedakan berdasarkan role:
| "kepala_bagian".
|
*/

public function index(Request $request): View
{
    $kepalaBagian = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN USER SUDAH LOGIN
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian) {
        abort(401);
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN ROLE
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian->hasRole('kepala_bagian')) {
        abort(403, 'Anda tidak memiliki akses sebagai Kepala Bagian.');
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN TERHUBUNG DENGAN KARYAWAN
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian->NIK || !$kepalaBagian->karyawan) {
        abort(
            403,
            'Akun Kepala Bagian belum terhubung dengan data karyawan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI FILTER
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([
        'search' => [
            'nullable',
            'string',
            'max:100',
        ],

        'status' => [
            'nullable',
            'in:pending,approved,rejected',
        ],

        'sort' => [
            'nullable',
            'in:IDRequest,created_at,NoRequest',
        ],

        'direction' => [
            'nullable',
            'in:asc,desc',
        ],
    ]);

    $search = $validated['search'] ?? null;

    $status = $validated['status'] ?? null;

    $sort = $validated['sort'] ?? 'IDRequest';

    $direction = $validated['direction'] ?? 'desc';

    /*
    |--------------------------------------------------------------------------
    | QUERY REQUEST
    |--------------------------------------------------------------------------
    */

    $query = ItRequest::query()
        ->with([
            'pemohon.karyawan.departemen',
            'pemohon.karyawan.kepalaBagian.user',
            'jenisPermintaan',
            'assets',
            'relatedUsers.karyawan.departemen',
            'approval.approver.karyawan',
        ])

        /*
        |--------------------------------------------------------------------------
        | HANYA REQUEST DARI BAWAHAN KEPALA BAGIAN
        |--------------------------------------------------------------------------
        */

        ->whereHas(
            'pemohon.karyawan',
            function ($query) use ($kepalaBagian) {
                $query->where(
                    'NIKKepalaBagian',
                    $kepalaBagian->NIK
                );
            }
        );

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    if (filled($search)) {
        $query->where(function ($query) use ($search) {

            $query
                ->where(
                    'NoRequest',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'Permintaan',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas(
                    'pemohon',
                    function ($query) use ($search) {

                        $query
                            ->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'NIK',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhereHas(
                                'karyawan',
                                function ($query) use ($search) {

                                    $query
                                        ->where(
                                            'Nama',
                                            'like',
                                            "%{$search}%"
                                        )

                                        ->orWhere(
                                            'NIK',
                                            'like',
                                            "%{$search}%"
                                        )

                                        ->orWhereHas(
                                            'departemen',
                                            function ($query) use ($search) {

                                                $query->where(
                                                    'NamaDept',
                                                    'like',
                                                    "%{$search}%"
                                                );
                                            }
                                        );
                                }
                            );
                    }
                );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER STATUS APPROVAL
    |--------------------------------------------------------------------------
    |
    | Approval harus milik Kepala Bagian yang sedang login.
    |
    */

    if (filled($status)) {
        $query->whereHas(
            'approval',
            function ($query) use (
                $status,
                $kepalaBagian
            ) {
                $query
                    ->where(
                        'status',
                        $status
                    )
                    ->where(
                        'approver_id',
                        $kepalaBagian->id
                    );
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SORTING
    |--------------------------------------------------------------------------
    */

    $query->orderBy(
        $sort,
        $direction
    );

    /*
|--------------------------------------------------------------------------
| TOTAL REQUEST YANG HARUS DI-APPROVE
|--------------------------------------------------------------------------
|
| Hanya menghitung approval milik Kepala Bagian yang sedang login
| dengan status pending.
|
*/

$totalPendingApproval = (clone $query)
    ->whereHas(
        'approval',
        function ($query) use ($kepalaBagian) {
            $query
                ->where(
                    'approver_id',
                    $kepalaBagian->id
                )
                ->where(
                    'status',
                    ItRequestApproval::STATUS_PENDING
                );
        }
    )
    ->count();


    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    $requests = $query
        ->paginate(15)
        ->withQueryString();

    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    return view(
    'kepala_bagian.it_requests.index',
    compact(
        'requests',
        'totalPendingApproval'
    )
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
    $kepalaBagian = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN LOGIN
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian) {
        abort(401);
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN ROLE
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian->hasRole('kepala_bagian')) {
        abort(
            403,
            'Anda tidak memiliki akses sebagai Kepala Bagian.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN TERHUBUNG DENGAN KARYAWAN
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian->NIK || !$kepalaBagian->karyawan) {
        abort(
            403,
            'Akun Kepala Bagian belum terhubung dengan data karyawan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN REQUEST MILIK BAWAHANNYA
    |--------------------------------------------------------------------------
    */

    $isOwner = $itRequest
        ->pemohon()
        ->whereHas(
            'karyawan',
            function ($query) use ($kepalaBagian) {
                $query->where(
                    'NIKKepalaBagian',
                    $kepalaBagian->NIK
                );
            }
        )
        ->exists();

    if (!$isOwner) {
        abort(
            403,
            'Anda tidak memiliki akses ke permintaan ini.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD RELATIONS
    |--------------------------------------------------------------------------
    |
    | Approval hanya diambil untuk Kepala Bagian yang sedang login.
    |
    */

    $itRequest->load([
        'pemohon.karyawan.departemen',
        'pemohon.karyawan.kepalaBagian.user',
        'jenisPermintaan',
        'assets',
        'relatedUsers.karyawan.departemen',
        'penyelesai.karyawan',
    ]);

    /*
    |--------------------------------------------------------------------------
    | LOAD APPROVAL MILIK KEPALA BAGIAN LOGIN
    |--------------------------------------------------------------------------
    */

    $itRequest->setRelation(
        'approval',
        $itRequest->approval()
            ->where(
                'approver_id',
                $kepalaBagian->id
            )
            ->with([
                'approver.karyawan',
            ])
            ->first()
    );

    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'kepala_bagian.it_requests.show',
        compact('itRequest')
    );
}


/*
|--------------------------------------------------------------------------
| APPROVE
|--------------------------------------------------------------------------
*/

public function approve(
    Request $request,
    ItRequest $itRequest
): RedirectResponse {
    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([
        'catatan' => [
            'nullable',
            'string',
            'max:65535',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | USER LOGIN
    |--------------------------------------------------------------------------
    */

    $kepalaBagian = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN LOGIN
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian) {
        abort(401);
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN ROLE
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian->hasRole('kepala_bagian')) {
        abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN TERHUBUNG DENGAN KARYAWAN
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian->NIK || !$kepalaBagian->karyawan) {
        abort(
            403,
            'Akun Kepala Bagian belum terhubung dengan data karyawan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN REQUEST MILIK BAWAHANNYA
    |--------------------------------------------------------------------------
    */

    $isOwner = $itRequest
        ->pemohon()
        ->whereHas(
            'karyawan',
            function ($query) use ($kepalaBagian) {
                $query->where(
                    'NIKKepalaBagian',
                    $kepalaBagian->NIK
                );
            }
        )
        ->exists();

    if (!$isOwner) {
        abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL APPROVAL
    |--------------------------------------------------------------------------
    */

    $approval = ItRequestApproval::query()
        ->where(
            'it_request_id',
            $itRequest->IDRequest
        )
        ->where(
            'approver_id',
            $kepalaBagian->id
        )
        ->first();

    if (!$approval) {
        abort(
            403,
            'Approval untuk Kepala Bagian ini tidak ditemukan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK STATUS
    |--------------------------------------------------------------------------
    */

    if (
        $approval->status !==
        ItRequestApproval::STATUS_PENDING
    ) {
        return back()->with(
            'error',
            'Request ini sudah diproses sebelumnya.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSACTION
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use (
        $approval,
        $itRequest,
        $validated
    ) {

        /*
        |--------------------------------------------------------------------------
        | UPDATE APPROVAL
        |--------------------------------------------------------------------------
        */

        $approval->update([
            'status' =>
                ItRequestApproval::STATUS_APPROVED,

            'catatan' =>
                $validated['catatan'] ?? null,

            'approved_at' =>
                now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS REQUEST
        |--------------------------------------------------------------------------
        */

        $itRequest->update([
            'Status' => 'disetujui',
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'kepala-bagian.it-requests.show',
            $itRequest
        )
        ->with(
            'success',
            'Permintaan IT berhasil disetujui.'
        );
}

/*
|--------------------------------------------------------------------------
| REJECT
|--------------------------------------------------------------------------
*/

public function reject(
    Request $request,
    ItRequest $itRequest
): RedirectResponse {
    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate(
        [
            'catatan' => [
                'required',
                'string',
                'max:65535',
            ],
        ],
        [
            'catatan.required' =>
                'Catatan penolakan wajib diisi.',
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | USER LOGIN
    |--------------------------------------------------------------------------
    */

    $kepalaBagian = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN LOGIN
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian) {
        abort(401);
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN ROLE
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian->hasRole('kepala_bagian')) {
        abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN TERHUBUNG DENGAN KARYAWAN
    |--------------------------------------------------------------------------
    */

    if (!$kepalaBagian->NIK || !$kepalaBagian->karyawan) {
        abort(
            403,
            'Akun Kepala Bagian belum terhubung dengan data karyawan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PASTIKAN REQUEST MILIK BAWAHANNYA
    |--------------------------------------------------------------------------
    */

    $isOwner = $itRequest
        ->pemohon()
        ->whereHas(
            'karyawan',
            function ($query) use ($kepalaBagian) {
                $query->where(
                    'NIKKepalaBagian',
                    $kepalaBagian->NIK
                );
            }
        )
        ->exists();

    if (!$isOwner) {
        abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL APPROVAL
    |--------------------------------------------------------------------------
    */

    $approval = ItRequestApproval::query()
        ->where(
            'it_request_id',
            $itRequest->IDRequest
        )
        ->where(
            'approver_id',
            $kepalaBagian->id
        )
        ->first();

    if (!$approval) {
        abort(
            403,
            'Approval untuk Kepala Bagian ini tidak ditemukan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK STATUS
    |--------------------------------------------------------------------------
    */

    if (
        $approval->status !==
        ItRequestApproval::STATUS_PENDING
    ) {
        return back()->with(
            'error',
            'Request ini sudah diproses sebelumnya.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSACTION
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use (
        $approval,
        $itRequest,
        $validated
    ) {

        /*
        |--------------------------------------------------------------------------
        | UPDATE APPROVAL
        |--------------------------------------------------------------------------
        */

        $approval->update([
            'status' =>
                ItRequestApproval::STATUS_REJECTED,

            'catatan' =>
                $validated['catatan'],

            'approved_at' =>
                now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS REQUEST
        |--------------------------------------------------------------------------
        */

        $itRequest->update([
            'Status' => 'ditolak',
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'kepala-bagian.it-requests.show',
            $itRequest
        )
        ->with(
            'success',
            'Permintaan IT berhasil ditolak.'
        );
}

}