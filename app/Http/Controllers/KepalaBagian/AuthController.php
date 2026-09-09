<?php
namespace App\Http\Controllers\KepalaBagian;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
class AuthController extends Controller
{ /* |-------------------------------------------------------------------------- | SHOW LOGIN |-------------------------------------------------------------------------- */
    public function showLogin(): View
    {
        return view('kepala_bagian.auth.login');
    } /* |-------------------------------------------------------------------------- | LOGIN |-------------------------------------------------------------------------- */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['email' => ['required', 'email',], 'password' => ['required', 'string',],]);
        $remember = $request->boolean('remember');
        if (!Auth::guard('kepala_bagian')->attempt($credentials, $remember)) {
            throw ValidationException::withMessages(['email' => 'Email atau password Kepala Bagian salah.',]);
        }
        $request->session()->regenerate();
        return redirect()->intended(route('kepala-bagian.it-requests.index'));
    } /* |-------------------------------------------------------------------------- | LOGOUT |-------------------------------------------------------------------------- */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('kepala_bagian')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('kepala-bagian.login');
    }
}