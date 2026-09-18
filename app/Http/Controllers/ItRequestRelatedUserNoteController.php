<?php

namespace App\Http\Controllers;

use App\Models\ItRequest;
use App\Models\ItRequestRelatedUserNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItRequestRelatedUserNoteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | Menampilkan request beserta catatan dari user terkait.
    |
    */

    public function index(ItRequest $itRequest): View
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | CEK USER TERKAIT
        |--------------------------------------------------------------------------
        |
        | Hanya user yang memang terdaftar sebagai related user
        | yang boleh mengakses fitur catatan ini.
        |
        */

        $isRelatedUser = $itRequest
            ->relatedUsers()
            ->where('users.id', $user->id)
            ->exists();

        abort_unless($isRelatedUser, 403);

        $itRequest->load([
            'pemohon',
            'penyelesai',
            'relatedUsers',
            'relatedUserNotes.user',
        ]);

        return view(
            'it_requests.related_user_notes.index',
            compact('itRequest')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    |
    | Menyimpan catatan baru dari user terkait.
    |
    */

    public function store(
        Request $request,
        ItRequest $itRequest
    ): RedirectResponse {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | CEK USER TERKAIT
        |--------------------------------------------------------------------------
        */

        $isRelatedUser = $itRequest
            ->relatedUsers()
            ->where('users.id', $user->id)
            ->exists();

        abort_unless($isRelatedUser, 403);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'catatan' => [
                'required',
                'string',
                'max:5000',
            ],
        ], [
            'catatan.required' => 'Catatan wajib diisi.',
            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max' => 'Catatan maksimal 5000 karakter.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN CATATAN
        |--------------------------------------------------------------------------
        */

        ItRequestRelatedUserNote::create([
            'it_request_id' => $itRequest->IDRequest,
            'user_id' => $user->id,
            'catatan' => $validated['catatan'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE INDEX PERMINTAAN IT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('it-requests.index')
            ->with(
                'success',
                'Catatan berhasil ditambahkan.'
            );
    }
}
