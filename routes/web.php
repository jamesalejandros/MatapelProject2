<?php use App\Http\Controllers\KepalaBagian\AuthController as KepalaBagianAuthController;
use App\Http\Controllers\KepalaBagian\ItRequestApprovalController;
use App\Http\Controllers\ItRequestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route; /* |-------------------------------------------------------------------------- | KEPALA BAGIAN |-------------------------------------------------------------------------- */
Route::prefix('kepala-bagian')->name('kepala-bagian.')->group(function () { /* |-------------------------------------------------------------------------- | LOGIN |-------------------------------------------------------------------------- */
    Route::middleware('guest:kepala_bagian')->group(function () {
        Route::get('/login', [KepalaBagianAuthController::class, 'showLogin',])->name('login');
        Route::post('/login', [KepalaBagianAuthController::class, 'login',])->name('login.store'); }); /* |-------------------------------------------------------------------------- | AUTHENTICATED |-------------------------------------------------------------------------- */
    Route::middleware('auth:kepala_bagian')->group(function () {
        Route::get('/permintaan-it', [ItRequestApprovalController::class, 'index',])->name('it-requests.index');
        Route::get('/permintaan-it/{itRequest}', [ItRequestApprovalController::class, 'show',])->name('it-requests.show');
        Route::patch('/permintaan-it/{itRequest}/approve', [ItRequestApprovalController::class, 'approve',])->name('it-requests.approve');
        Route::patch('/permintaan-it/{itRequest}/reject', [ItRequestApprovalController::class, 'reject',])->name('it-requests.reject');
        Route::post('/logout', [KepalaBagianAuthController::class, 'logout',])->name('logout'); }); }); /* |-------------------------------------------------------------------------- | USER BIASA |-------------------------------------------------------------------------- */
Route::middleware('auth')->group(function () {
    Route::get('/permintaan-it', [ItRequestController::class, 'index'])->name('it-requests.index');
    Route::get('/permintaan-it/create', [ItRequestController::class, 'create'])->name('it-requests.create');
    Route::post('/permintaan-it', [ItRequestController::class, 'store'])->name('it-requests.store');
    Route::get('/permintaan-it/{itRequest}', [ItRequestController::class, 'show'])->name('it-requests.show');
    Route::get(
    '/it-requests/{itRequest}/edit',
    [ItRequestController::class, 'edit']
)->name('it-requests.edit');

Route::put(
    '/it-requests/{itRequest}',
    [ItRequestController::class, 'update']
)->name('it-requests.update');

Route::delete(
    '/it-requests/{itRequest}',
    [ItRequestController::class, 'destroy']
)->name('it-requests.destroy');

Route::post(
    'it-requests/{itRequest}/serah-terima',
    [ItRequestController::class, 'serahTerima']
)->name('it-requests.serah-terima');


    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login'); })->name('logout'); }); /* |-------------------------------------------------------------------------- | ROOT |-------------------------------------------------------------------------- */
Route::get('/', function () {
    return view('welcome'); }); /* |-------------------------------------------------------------------------- | DASHBOARD |-------------------------------------------------------------------------- */
Route::get('/dashboard', function () {
    return view('dashboard'); })->middleware(['auth', 'verified',])->name('dashboard'); /* |-------------------------------------------------------------------------- | PROFILE |-------------------------------------------------------------------------- */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit',])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update',])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy',])->name('profile.destroy'); });
require __DIR__ . '/auth.php';