<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $okres = $request->get('okres', 'wszystkie');

        if ($search) {
            $filmy = Film::where('Tytul', 'like', '%' . $search . '%');
        } else {
            $filmy = Film::query();
        }


        if ($okres == 'aktualne') {
            $filmy = $filmy->where('DoKiedy', '>=', now());
        } elseif ($okres == 'ostatni_rok') {
            $filmy = $filmy->whereBetween('OdKiedy', [now()->subYear(), now()]);
        }


        $filmy = $filmy->get();

        return view('filmy.index', [
            'filmy' => $filmy,
            'search' => $search,
            'selectedOkres' => $okres
        ]);
    }


    public function create()
    {
        return view('filmy.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'Tytul' => 'required|string|max:100',
            'Opis' => 'nullable|string',
            'CenaNormalna' => 'required|numeric',
            'CenaUlgowa' => 'required|numeric',
            'Plakat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Wiek' => 'required|in:3+,7+,13+,16+,18+',
            'OdKiedy' => 'required|date',
            'DoKiedy' => 'required|date',
            'Dystrybucja' => 'required|string|max:255',
        ]);

        $film = new Film();
        $film->Tytul = $request->Tytul;
        $film->Opis = $request->Opis;
        $film->CenaNormalna = $request->CenaNormalna;
        $film->CenaUlgowa = $request->CenaUlgowa;
        $film->ZwiastunURL = $request->ZwiastunURL;
        $film->Wiek = $request->Wiek;
        $film->OdKiedy = $request->OdKiedy;
        $film->DoKiedy = $request->DoKiedy;
        $film->Dystrybucja = $request->Dystrybucja;

        if ($request->hasFile('Plakat')) {
            $path = $request->file('Plakat')->store('plakaty', 'public');
            $film->Plakat = $path;
        }

        $film->save();

        return redirect()->route('filmy.index')->with('success', 'Film został dodany!');
    }




    public function edit($id)
    {
        $film = Film::findOrFail($id);
        return view('filmy.edit', compact('film'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Tytul' => 'required|string|max:255',
            'Opis' => 'nullable|string',
            'CenaNormalna' => 'required|numeric',
            'CenaUlgowa' => 'required|numeric',
            'Plakat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Wiek' => 'required|in:3+,7+,13+,16+,18+',
            'OdKiedy' => 'required|date',
            'DoKiedy' => 'required|date',
            'Dystrybucja' => 'required|string|max:255',
        ]);

        $film = Film::findOrFail($id);

        $film->Tytul = $request->Tytul;
        $film->Opis = $request->Opis;
        $film->CenaNormalna = $request->CenaNormalna;
        $film->CenaUlgowa = $request->CenaUlgowa;
        $film->ZwiastunURL = $request->ZwiastunURL;
        $film->Wiek = $request->Wiek;
        $film->OdKiedy = $request->OdKiedy;
        $film->DoKiedy = $request->DoKiedy;
        $film->Dystrybucja = $request->Dystrybucja;
        if ($request->hasFile('Plakat')) {

            if ($film->Plakat) {
                $pathToDelete = public_path('storage/' . $film->Plakat);
                if (file_exists($pathToDelete)) {
                    unlink($pathToDelete);
                }
            }

            $path = $request->file('Plakat')->store('plakaty', 'public');
            $film->Plakat = $path;
        }

        $film->save();

        return redirect()->route('filmy.index')->with('success', 'Film został zaktualizowany.');
    }

    public function destroy($id)
    {
        $film = Film::findOrFail($id);


        if ($film->Plakat) {
            $pathToDelete = public_path('storage/' . $film->Plakat);
            if (file_exists($pathToDelete)) {
                unlink($pathToDelete);
            }
        }

        $film->delete();

        return redirect()->route('filmy.index')->with('success', 'Film został usunięty.');
    }
}
