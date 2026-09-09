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
    */

    public function index(Request $request): View
{
    $kepalaBagian = auth('kepala_bagian')->user();

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
    | QUERY
    |--------------------------------------------------------------------------
    */

    $query = ItRequest::query()
        ->with([
            'pemohon.karyawan.departemen',
            'pemohon.kepalaBagian',
            'jenisPermintaan',
            'assets',
            'relatedUsers.karyawan.departemen',
            'approval',
        ])
        ->whereHas(
            'pemohon',
            function ($query) use ($kepalaBagian) {

                $query->where(
                    'kepala_bagian_id',
                    $kepalaBagian->id
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

            $query->where(
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

                    $query->where(
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

                            $query->where(
                                'Nama',
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
    */

    if (filled($status)) {

        $query->whereHas(
            'approval',
            function ($query) use ($status) {

                $query->where(
                    'status',
                    $status
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
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    $requests = $query
        ->paginate(15)
        ->withQueryString();


    return view(
        'kepala_bagian.it_requests.index',
        compact('requests')
    );
}


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(ItRequest $itRequest): View
    {
        $kepalaBagian = auth('kepala_bagian')->user();

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN REQUEST MILIK BAWAHANNYA
        |--------------------------------------------------------------------------
        */

        $isOwner = $itRequest
            ->pemohon()
            ->where(
                'kepala_bagian_id',
                $kepalaBagian->id
            )
            ->exists();

        if (!$isOwner) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | LOAD RELATIONS
        |--------------------------------------------------------------------------
        */

        $itRequest->load([
            'pemohon.karyawan.departemen',
            'pemohon.kepalaBagian',
            'jenisPermintaan',
            'assets',
            'relatedUsers.karyawan.departemen',
            'penyelesai.karyawan',
            'approval.kepalaBagian',
        ]);

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
        $validated = $request->validate([
            'catatan' => [
                'nullable',
                'string',
                'max:65535',
            ],
        ]);

        $kepalaBagian = auth('kepala_bagian')->user();

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
                'kepala_bagian_id',
                $kepalaBagian->id
            )
            ->first();

        if (!$approval) {
            abort(403);
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
        | UPDATE APPROVAL
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $approval,
            $itRequest,
            $validated
        ) {
            $approval->update([
                'status' => ItRequestApproval::STATUS_APPROVED,
                'catatan' => $validated['catatan'] ?? null,
                'approved_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | UPDATE STATUS REQUEST
            |--------------------------------------------------------------------------
            |
            | Request sekarang sudah disetujui Kepala Bagian
            | dan siap diproses Staff IT.
            |
            */

            $itRequest->update([
                'Status' => 'disetujui',
            ]);
        });

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

        $kepalaBagian = auth('kepala_bagian')->user();

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
                'kepala_bagian_id',
                $kepalaBagian->id
            )
            ->first();

        if (!$approval) {
            abort(403);
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
        | UPDATE APPROVAL
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $approval,
            $itRequest,
            $validated
        ) {
            $approval->update([
                'status' => ItRequestApproval::STATUS_REJECTED,
                'catatan' => $validated['catatan'],
                'approved_at' => now(),
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
