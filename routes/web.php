<?php

use App\Http\Controllers\ItRequestController;
use App\Http\Controllers\KepalaBagian\ItRequestApprovalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItRequestRelatedUserNoteController;

/* |--------------------------------------------------------------------------
| ROOT
|-------------------------------------------------------------------------- */

Route::get('/', function () {
    return view('welcome');
});

/* |--------------------------------------------------------------------------
| DASHBOARD
|-------------------------------------------------------------------------- |
| SEMUA USER MENGGUNAKAN GUARD WEB. |
| Tidak lagi diarahkan otomatis ke: |
| /admin/dashboard |
| Redirect berdasarkan role dilakukan di controller/login |
| utama atau middleware khusus. |
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    /* |--------------------------------------------------------------------------
    | KEPALA BAGIAN
    |-------------------------------------------------------------------------- */

    if ($user->hasRole('kepala_bagian')) {
        return redirect()->route('kepala-bagian.it-requests.index');
    }

    /* |--------------------------------------------------------------------------
    | ADMIN
    |-------------------------------------------------------------------------- */

    if ($user->hasRole('admin')) {
        return redirect('/admin/dashboard');
    }

    /* |--------------------------------------------------------------------------
    | USER BIASA
    |-------------------------------------------------------------------------- */

    return redirect()->route('it-requests.index');

})->middleware(['auth', 'verified'])->name('dashboard');

/* |--------------------------------------------------------------------------
| KEPALA BAGIAN
|-------------------------------------------------------------------------- |
| Tidak ada login khusus Kepala Bagian. |
| Kepala Bagian login melalui form login utama. |
| Setelah login, role "kepala_bagian" akan diarahkan |
| ke halaman permintaan IT Kepala Bagian. |
*/

Route::prefix('kepala-bagian')
    ->name('kepala-bagian.')
    ->middleware('auth')
    ->group(function () {

        /* |--------------------------------------------------------------------------
        | DAFTAR PERMINTAAN IT
        |-------------------------------------------------------------------------- */

        Route::get(
            '/permintaan-it',
            [ItRequestApprovalController::class, 'index']
        )->name('it-requests.index');

        /* |--------------------------------------------------------------------------
        | DETAIL PERMINTAAN IT
        |-------------------------------------------------------------------------- */

        Route::get(
            '/permintaan-it/{itRequest}',
            [ItRequestApprovalController::class, 'show']
        )->name('it-requests.show');

        /* |--------------------------------------------------------------------------
        | APPROVE
        |-------------------------------------------------------------------------- */

        Route::patch(
            '/permintaan-it/{itRequest}/approve',
            [ItRequestApprovalController::class, 'approve']
        )->name('it-requests.approve');

        /* |--------------------------------------------------------------------------
        | REJECT
        |-------------------------------------------------------------------------- */

        Route::patch(
            '/permintaan-it/{itRequest}/reject',
            [ItRequestApprovalController::class, 'reject']
        )->name('it-requests.reject');

    });

/* |--------------------------------------------------------------------------
| USER BIASA
|-------------------------------------------------------------------------- |
| Semua user tetap menggunakan guard "web". |
| Controller tetap harus melakukan pengecekan |
| kepemilikan/otorisasi masing-masing request. |
*/

Route::middleware('auth')->group(function () {

    /* |--------------------------------------------------------------------------
    | INDEX
    |-------------------------------------------------------------------------- */

    Route::get(
        '/permintaan-it',
        [ItRequestController::class, 'index']
    )->name('it-requests.index');

    /* |--------------------------------------------------------------------------
    | CREATE
    |-------------------------------------------------------------------------- */

    Route::get(
        '/permintaan-it/create',
        [ItRequestController::class, 'create']
    )->name('it-requests.create');

    /* |--------------------------------------------------------------------------
    | STORE
    |-------------------------------------------------------------------------- */

    Route::post(
        '/permintaan-it',
        [ItRequestController::class, 'store']
    )->name('it-requests.store');

    /* |--------------------------------------------------------------------------
    | SHOW
    |-------------------------------------------------------------------------- */

    Route::get(
        '/permintaan-it/{itRequest}',
        [ItRequestController::class, 'show']
    )->name('it-requests.show');

    /* |--------------------------------------------------------------------------
    | EDIT
    |-------------------------------------------------------------------------- */

    Route::get(
        '/permintaan-it/{itRequest}/edit',
        [ItRequestController::class, 'edit']
    )->name('it-requests.edit');

    /* |--------------------------------------------------------------------------
    | UPDATE
    |-------------------------------------------------------------------------- */

    Route::put(
        '/permintaan-it/{itRequest}',
        [ItRequestController::class, 'update']
    )->name('it-requests.update');

    /* |--------------------------------------------------------------------------
    | DELETE
    |-------------------------------------------------------------------------- */

    Route::delete(
        '/permintaan-it/{itRequest}',
        [ItRequestController::class, 'destroy']
    )->name('it-requests.destroy');

    /* |--------------------------------------------------------------------------
    | SERAH TERIMA
    |-------------------------------------------------------------------------- */

    Route::post(
        '/permintaan-it/{itRequest}/serah-terima',
        [ItRequestController::class, 'serahTerima']
    )->name('it-requests.serah-terima');

    /* |--------------------------------------------------------------------------
    | LOGOUT
    |-------------------------------------------------------------------------- */

    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    })->name('logout');

    /* |--------------------------------------------------------------------------
    | RELATED USER NOTES - INDEX
    |-------------------------------------------------------------------------- */

    Route::get(
        '/permintaan-it/{itRequest}/related-user-notes',
        [ItRequestRelatedUserNoteController::class, 'index']
    )->name('it-requests.related-user-notes.index');

    /* |--------------------------------------------------------------------------
    | RELATED USER NOTES - STORE
    |-------------------------------------------------------------------------- */

    Route::post(
        '/permintaan-it/{itRequest}/related-user-notes',
        [ItRequestRelatedUserNoteController::class, 'store']
    )->name('it-requests.related-user-notes.store');

});

/* |--------------------------------------------------------------------------
| PROFILE
|-------------------------------------------------------------------------- */

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});

/* |--------------------------------------------------------------------------
| AUTH
|-------------------------------------------------------------------------- |
| Hanya SATU sistem login. |
*/

require __DIR__ . '/auth.php';
