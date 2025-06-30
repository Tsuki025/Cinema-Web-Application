<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Pracownik;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Email' => ['required', 'string', 'email'],
            'Haslo' => ['required', 'string'],
        ]);

        $pracownik = Pracownik::where('Email', $request->Email)->first();

        if (!$pracownik || !Hash::check($request->Haslo, $pracownik->Haslo)) {
            return back()->withErrors([
                'Email' => ['Niepoprawny email lub hasło.'],
            ]);
        }

        Auth::login($pracownik);

        // Przekierowanie na odpowiedni dashboard w zależności od roli
        if ($pracownik->Rola == 'Właściciel') {
            return redirect()->route('dashboard');
        } elseif ($pracownik->Rola == 'Sprzedawca') {
            return redirect()->route('dashboard');
        } elseif ($pracownik->Rola == 'Sprzątanie') {
            return redirect()->route('dashboard');
        }

        // Jeśli rola nie pasuje, przekierowanie na stronę główną
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

  
    return redirect('/login');
}

}
