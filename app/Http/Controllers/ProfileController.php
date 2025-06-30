<?php

namespace App\Http\Controllers;

use App\Models\Pracownik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function edit()
    {
        $user = Auth::user();
        return view('profil.edit', compact('user'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'Imie' => 'required|string|max:255',
            'Nazwisko' => 'required|string|max:255',
            'Email' => 'required|email|max:255|unique:Pracownicy,Email,' . Auth::id() . ',PracownikID',
            'Haslo' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->Imie = $request->Imie;
        $user->Nazwisko = $request->Nazwisko;
        $user->Email = $request->Email;

        if ($request->filled('Haslo')) {
            $user->Haslo = Hash::make($request->Haslo);
        }

        $user->save();

        return redirect()->route('profil.edit')->with('success', 'Profil został zaktualizowany.');
    }
}
