<?php

namespace App\Http\Controllers;

use App\Models\Seans;
use App\Models\Sala;
use App\Models\Sprzatanie;
use App\Models\Pracownik;
use App\Models\Rezerwacja;
use App\Models\Grafik;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Film;
use App\Http\Controllers\FilmController;

class HarmonogramController extends Controller
{
    public function index(Request $request)
    {

        $dzisiaj = \Carbon\Carbon::now('Europe/Warsaw')->locale('pl');


        $dniTygodnia = [];
        for ($i = 0; $i < 7; $i++) {
            $nowyDzien = $dzisiaj->copy()->addDays($i);
            $dniTygodnia[] = [
                'nazwa' => $nowyDzien->locale('pl')->isoFormat('dddd'),
                'data' => $nowyDzien->format('Y-m-d'),
                'formatted' => $nowyDzien->format('d.m.Y'),
            ];
        }


        $wybranyDzien = $request->input('date', $dzisiaj->toDateString());


        $today = \Carbon\Carbon::parse($wybranyDzien);


        $seanse = Seans::whereDate('DataSeansu', $today)
            ->orderBy('GodzinaRozpoczecia', 'asc')
            ->get();

        $sprzatanie = Sprzatanie::whereDate('DataSprzatania', $today)
            ->orderBy('GodzinaRozpoczecia', 'asc')
            ->get();


        $sale = Sala::all();


        return view('harmonogram.index', compact('seanse', 'sprzatanie', 'sale', 'today', 'dniTygodnia'));
    }


    public function createSeans()
    {

        $filmy = Film::where('DoKiedy', '>=', now())->get();
        $sale = Sala::all();
        $pracownicySprzatanie = Pracownik::where('Rola', 'Sprzątanie')->get();

        return view('harmonogram.create', compact('filmy', 'sale', 'pracownicySprzatanie'));
    }
    public function getPracownicyByDate(Request $request)
    {
        $data = $request->input('data');
        $godzinaZakonczeniaSeansu = $request->input('godzina_zakonczenia');

        if (!$data || !$godzinaZakonczeniaSeansu) {
            return response()->json(['error' => 'Nie podano wymaganych danych.'], 400);
        }

        $godzinaRozpoczeciaSprzatania = Carbon::createFromFormat('H:i', $godzinaZakonczeniaSeansu)->addMinutes(2);
        $godzinaZakonczeniaSprzatania = $godzinaRozpoczeciaSprzatania->copy()->addMinutes(30);

        $pracownicy = Grafik::where('data', $data)
            ->whereTime('GodzinaOd', '<=', $godzinaRozpoczeciaSprzatania->format('H:i'))
            ->where(function ($query) use ($godzinaRozpoczeciaSprzatania, $godzinaZakonczeniaSprzatania) {
                $query->whereTime('GodzinaDo', '>=', $godzinaZakonczeniaSprzatania->format('H:i'))
                    ->orWhereTime('GodzinaDo', '>=', $godzinaRozpoczeciaSprzatania->copy()->addMinutes(20)->format('H:i'));
            })
            ->whereHas('pracownik', function ($query) use ($data, $godzinaRozpoczeciaSprzatania, $godzinaZakonczeniaSprzatania) {
                $query->where('Rola', 'Sprzątanie')
                    ->whereDoesntHave('sprzatania', function ($sprzatanieQuery) use ($data, $godzinaRozpoczeciaSprzatania, $godzinaZakonczeniaSprzatania) {
                        $sprzatanieQuery->where('DataSprzatania', $data)
                            ->where(function ($timeQuery) use ($godzinaRozpoczeciaSprzatania, $godzinaZakonczeniaSprzatania) {
                                $timeQuery->whereBetween('GodzinaRozpoczecia', [
                                    $godzinaRozpoczeciaSprzatania->format('H:i'),
                                    $godzinaZakonczeniaSprzatania->format('H:i'),
                                ])
                                    ->orWhereBetween('GodzinaZakonczenia', [
                                        $godzinaRozpoczeciaSprzatania->format('H:i'),
                                        $godzinaZakonczeniaSprzatania->format('H:i'),
                                    ])
                                    ->orWhere(function ($overlapQuery) use ($godzinaRozpoczeciaSprzatania, $godzinaZakonczeniaSprzatania) {
                                        $overlapQuery->where('GodzinaRozpoczecia', '<', $godzinaRozpoczeciaSprzatania->format('H:i'))
                                            ->where('GodzinaZakonczenia', '>', $godzinaZakonczeniaSprzatania->format('H:i'));
                                    });
                            });
                    });
            })
            ->with('pracownik')
            ->get()
            ->pluck('pracownik')
            ->unique();
        return response()->json($pracownicy);
    }




    public function storeSeans(Request $request)
    {
        $request->validate([
            'FilmID' => 'required|exists:filmy,FilmID',
            'SalaID' => 'required|exists:sale,SalaID',
            'DataSeansu' => 'required|date',
            'GodzinaRozpoczecia' => 'required|date_format:H:i',
            'GodzinaZakonczenia' => 'required|date_format:H:i',
            'Typ' => 'required|in:2D,3D',
            'Typ2' => 'required|in:Napisy,Dubbing,Lektor',
            'Publicznosc' => 'required|in:Publiczny,Prywatny',
            'AutoSprzatanie' => 'nullable|in:0,1',
            'PracownikSprzatanie' => 'nullable|exists:pracownicy,PracownikID'
        ]);

        $godzinaRozpoczecia = Carbon::createFromFormat('H:i', $request->GodzinaRozpoczecia);
        $godzinaZakonczenia = Carbon::createFromFormat('H:i', $request->GodzinaZakonczenia);
        $conflict = Seans::where('SalaID', $request->SalaID)
            ->whereDate('DataSeansu', $request->DataSeansu)
            ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhere(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                        $query->where('GodzinaRozpoczecia', '<=', $godzinaRozpoczecia)
                            ->where('GodzinaZakonczenia', '>=', $godzinaZakonczenia);
                    });
            })
            ->exists();
        if ($conflict) {
            return redirect()->route('harmonogram.create')
                ->with('error', 'Nie można dodać seansu, ponieważ odbywa się już seans w tym samym czasie w tej samej sali.');
        }
        $conflictSprzatanie = Sprzatanie::where('SalaID', $request->SalaID)
            ->whereDate('DataSprzatania', $request->DataSprzatania)
            ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhere(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                        $query->where('GodzinaRozpoczecia', '<=', $godzinaRozpoczecia)
                            ->where('GodzinaZakonczenia', '>=', $godzinaZakonczenia);
                    });
            })
            ->exists();
        if ($conflictSprzatanie) {
            return redirect()->route('harmonogram.create')
                ->with('error', 'Nie można dodać seansu, ponieważ odbywa się w tym samym czasie sprzątanie w tej samej sali.');
        }

        $seans = new Seans();
        $seans->FilmID = $request->FilmID;
        $seans->SalaID = $request->SalaID;
        $seans->DataSeansu = $request->DataSeansu;
        $seans->GodzinaRozpoczecia = $godzinaRozpoczecia;
        $seans->GodzinaZakonczenia = $godzinaZakonczenia;
        $seans->Typ = $request->Typ;
        $seans->Typ2 = $request->Typ2;
        $seans->Publicznosc = $request->Publicznosc;
        $seans->save();

        if ($request->AutoSprzatanie == '1' && $request->PracownikSprzatanie) {
            $pracownikSprzatanie = Pracownik::find($request->PracownikSprzatanie);

            $grafik = Grafik::where('PracownikID', $pracownikSprzatanie->PracownikID)
                ->whereDate('data', $request->DataSeansu)
                ->first();

            $godzinaRozpoczeciaSprzatania = $godzinaZakonczenia->copy()->addMinute(2);

            $godzinaKoncaPracy = Carbon::createFromFormat('H:i', substr($grafik->GodzinaDo, 0, 5));

            $dostepnyCzasSprzatania = $godzinaRozpoczeciaSprzatania->diffInMinutes($godzinaKoncaPracy, false);

            if ($dostepnyCzasSprzatania >= 20) {
                $czasSprzatania = min($dostepnyCzasSprzatania, 30);

                $godzinaZakonczeniaSprzatania = $godzinaRozpoczeciaSprzatania->copy()->addMinutes($czasSprzatania);

                $sprzatanie = new Sprzatanie();
                $sprzatanie->SalaID = $request->SalaID;
                $sprzatanie->DataSprzatania = $request->DataSeansu;
                $sprzatanie->GodzinaRozpoczecia = $godzinaRozpoczeciaSprzatania;
                $sprzatanie->GodzinaZakonczenia = $godzinaZakonczeniaSprzatania;
                $sprzatanie->PracownikID = $pracownikSprzatanie->PracownikID;

                $sprzatanie->save();
            } else {
                return redirect()->route('harmonogram.index')
                    ->with('error', 'Pracownik nie ma wystarczającego czasu na sprzątanie.');
            }
        }
        return redirect()->route('harmonogram.index')->with('success', 'Seans został dodany!');
    }

    public function getPracownicy(Request $request)
    {
        $data = $request->input('data');
        $godzinaRozpoczecia = $request->input('godzina_rozpoczecia');
        $godzinaZakonczenia = $request->input('godzina_zakonczenia');


        if (!$data || !$godzinaRozpoczecia || !$godzinaZakonczenia) {
            return response()->json(['error' => 'Brak wymaganych parametrów.'], 400);
        }


        $pracownicy = Pracownik::where('Rola', 'Sprzątanie')->get();


        $dostepniPracownicy = $pracownicy->filter(function ($pracownik) use ($data, $godzinaRozpoczecia, $godzinaZakonczenia) {

            $pracujeWtymCzasie = Grafik::where('PracownikID', $pracownik->PracownikID)
                ->whereDate('Data', $data)
                ->whereTime('GodzinaOd', '<=', $godzinaRozpoczecia)
                ->whereTime('GodzinaDo', '>=', $godzinaZakonczenia)
                ->exists();

            if (!$pracujeWtymCzasie) {
                return false;
            }


            $maKonfliktSprzatania = Sprzatanie::where('PracownikID', $pracownik->PracownikID)
                ->whereDate('DataSprzatania', $data)
                ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                    $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                        ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                        ->orWhereRaw('? BETWEEN GodzinaRozpoczecia AND GodzinaZakonczenia', [$godzinaRozpoczecia])
                        ->orWhereRaw('? BETWEEN GodzinaRozpoczecia AND GodzinaZakonczenia', [$godzinaZakonczenia]);
                })
                ->exists();

            return !$maKonfliktSprzatania;
        });

        return response()->json($dostepniPracownicy->values());
    }
    public function getPracownicyEdit(Request $request)
    {
        $data = $request->input('data');
        $godzinaRozpoczecia = $request->input('godzina_rozpoczecia');
        $godzinaZakonczenia = $request->input('godzina_zakonczenia');
        $edytowaneSprzatanieID = $request->input('edytowane_sprzatanie_id');

        if (!$data || !$godzinaRozpoczecia || !$godzinaZakonczenia) {
            return response()->json(['error' => 'Brak wymaganych parametrów.'], 400);
        }


        $pracownicy = Pracownik::where('Rola', 'Sprzątanie')->get();


        $dostepniPracownicy = $pracownicy->filter(function ($pracownik) use ($data, $godzinaRozpoczecia, $godzinaZakonczenia, $edytowaneSprzatanieID) {

            $pracujeWtymCzasie = Grafik::where('PracownikID', $pracownik->PracownikID)
                ->whereDate('Data', $data)
                ->whereTime('GodzinaOd', '<=', $godzinaRozpoczecia)
                ->whereTime('GodzinaDo', '>=', $godzinaZakonczenia)
                ->exists();

            if (!$pracujeWtymCzasie) {
                return false;
            }


            $maKonfliktSprzatania = Sprzatanie::where('PracownikID', $pracownik->PracownikID)
                ->whereDate('DataSprzatania', $data)
                ->where('SprzatanieID', '!=', $edytowaneSprzatanieID)
                ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                    $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                        ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                        ->orWhereRaw('? BETWEEN GodzinaRozpoczecia AND GodzinaZakonczenia', [$godzinaRozpoczecia])
                        ->orWhereRaw('? BETWEEN GodzinaRozpoczecia AND GodzinaZakonczenia', [$godzinaZakonczenia]);
                })
                ->exists();

            return !$maKonfliktSprzatania;
        });

        return response()->json($dostepniPracownicy->values());
    }


    public function createSprzatanie()
    {

        $sale = Sala::all();
        $pracownicy = Pracownik::where('Rola', 'Sprzątanie')->get();


        return view('harmonogram.createSprzatanie', compact('sale', 'pracownicy'));
    }

    public function storeSprzatanie(Request $request)
    {
        $request->validate([
            'SalaID' => 'required|exists:sale,SalaID',
            'PracownikID' => 'required|exists:pracownicy,PracownikID',
            'DataSprzatania' => 'required|date',
            'GodzinaRozpoczecia' => 'required|date_format:H:i',
            'GodzinaZakonczenia' => 'required|date_format:H:i',

        ]);


        $godzinaRozpoczecia = Carbon::createFromFormat('H:i', $request->GodzinaRozpoczecia);
        $godzinaZakonczenia = Carbon::createFromFormat('H:i', $request->GodzinaZakonczenia);


        $conflict = Seans::where('SalaID', $request->SalaID)
            ->whereDate('DataSeansu', $request->DataSprzatania)
            ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhere(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                        $query->where('GodzinaRozpoczecia', '<=', $godzinaRozpoczecia)
                            ->where('GodzinaZakonczenia', '>=', $godzinaZakonczenia);
                    });
            })
            ->exists();


        $conflictSprzatanie = Sprzatanie::where('SalaID', $request->SalaID)
            ->whereDate('DataSprzatania', $request->DataSprzatania)
            ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhere(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                        $query->where('GodzinaRozpoczecia', '<=', $godzinaRozpoczecia)
                            ->where('GodzinaZakonczenia', '>=', $godzinaZakonczenia);
                    });
            })
            ->exists();

        if ($conflict || $conflictSprzatanie) {
            return redirect()->route('harmonogram.createSprzatanie')
                ->with('error', 'Nie można dodać sprzątania, ponieważ odbywa się w tym samym czasie inny seansie lub sprzątanie w tej samej sali.');
        }


        $sprzatanie = new Sprzatanie();
        $sprzatanie->SalaID = $request->SalaID;
        $sprzatanie->PracownikID = $request->PracownikID;
        $sprzatanie->DataSprzatania = $request->DataSprzatania;
        $sprzatanie->GodzinaRozpoczecia = $godzinaRozpoczecia;
        $sprzatanie->GodzinaZakonczenia = $godzinaZakonczenia;
        $sprzatanie->save();

        return redirect()->route('harmonogram.index')->with('success', 'Sprzątanie zostało dodane!');
    }
    public function editSeans($id)
    {
        $seans = Seans::findOrFail($id);
        $filmy = Film::where('DoKiedy', '>=', now())->get();
        $sale = Sala::all();
        $seans->GodzinaRozpoczecia = Carbon::parse($seans->GodzinaRozpoczecia);
        $seans->GodzinaZakonczenia = Carbon::parse($seans->GodzinaZakonczenia);


        return view('harmonogram.editSeans', compact('seans', 'filmy', 'sale'));
    }


    public function updateSeans(Request $request, $id)
    {
        $request->validate([
            'FilmID' => 'required|exists:filmy,FilmID',
            'SalaID' => 'required|exists:sale,SalaID',
            'DataSeansu' => 'required|date',
            'GodzinaRozpoczecia' => 'required|date_format:H:i',
            'GodzinaZakonczenia' => 'required|date_format:H:i',
            'Typ' => 'required|in:2D,3D',
            'Typ2' => 'required|in:Napisy,Dubbing,Lektor',
            'Publicznosc' => 'required|in:Publiczny,Prywatny',
        ]);

        $godzinaRozpoczecia = Carbon::createFromFormat('H:i', $request->GodzinaRozpoczecia);
        $godzinaZakonczenia = Carbon::createFromFormat('H:i', $request->GodzinaZakonczenia);


        $conflictSeans = Seans::where('SalaID', $request->SalaID)
            ->whereDate('DataSeansu', $request->DataSeansu)
            ->where('SeansID', '!=', $id)
            ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhere(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                        $query->where('GodzinaRozpoczecia', '<=', $godzinaRozpoczecia)
                            ->where('GodzinaZakonczenia', '>=', $godzinaZakonczenia);
                    });
            })
            ->exists();

        if ($conflictSeans) {
            return redirect()->route('harmonogram.editSeans', $id)
                ->with('error', 'Nie można zaktualizować seansu, ponieważ odbywa się inny seans w tym samym czasie w tej samej sali.');
        }


        $conflictSprzatanie = Sprzatanie::where('SalaID', $request->SalaID)
            ->whereDate('DataSprzatania', $request->DataSeansu)
            ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhere(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                        $query->where('GodzinaRozpoczecia', '<=', $godzinaRozpoczecia)
                            ->where('GodzinaZakonczenia', '>=', $godzinaZakonczenia);
                    });
            })
            ->exists();

        if ($conflictSprzatanie) {
            return redirect()->route('harmonogram.editSeans', $id)
                ->with('error', 'Nie można zaktualizować seansu, ponieważ odbywa się sprzątanie w tym samym czasie w tej samej sali.');
        }


        $seans = Seans::findOrFail($id);
        $seans->FilmID = $request->FilmID;
        $seans->SalaID = $request->SalaID;
        $seans->DataSeansu = $request->DataSeansu;
        $seans->GodzinaRozpoczecia = $godzinaRozpoczecia;
        $seans->GodzinaZakonczenia = $godzinaZakonczenia;
        $seans->Typ = $request->Typ;
        $seans->Typ2 = $request->Typ2;
        $seans->Publicznosc = $request->Publicznosc;
        $seans->save();

        return redirect()->route('harmonogram.index')->with('success', 'Seans został zaktualizowany!');
    }

    public function destroySeans($id)
    {
        $seans = Seans::findOrFail($id);
        $seans->delete();

        return redirect()->route('harmonogram.index')->with('success', 'Seans został usunięty!');
    }
    public function editSprzatanie($id)
    {
        $sprzatanie = Sprzatanie::findOrFail($id);
        $sale = Sala::all();
        $pracownicy = Pracownik::where('Rola', 'Sprzątanie')->get();


        $sprzatanie->GodzinaRozpoczecia = Carbon::parse($sprzatanie->GodzinaRozpoczecia);
        $sprzatanie->GodzinaZakonczenia = Carbon::parse($sprzatanie->GodzinaZakonczenia);

        return view('harmonogram.editSprzatanie', compact('sprzatanie', 'sale', 'pracownicy'));
    }
    public function updateSprzatanie(Request $request, $id)
    {
        $request->validate([
            'SalaID' => 'required|exists:sale,SalaID',
            'PracownikID' => 'required|exists:pracownicy,PracownikID',
            'DataSprzatania' => 'required|date',
            'GodzinaRozpoczecia' => 'required|date_format:H:i',
            'GodzinaZakonczenia' => 'required|date_format:H:i',
        ]);

        $godzinaRozpoczecia = Carbon::createFromFormat('H:i', $request->GodzinaRozpoczecia);
        $godzinaZakonczenia = Carbon::createFromFormat('H:i', $request->GodzinaZakonczenia);

        $conflictSeans = Seans::where('SalaID', $request->SalaID)
            ->whereDate('DataSeansu', $request->DataSprzatania)
            ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhere(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                        $query->where('GodzinaRozpoczecia', '<=', $godzinaRozpoczecia)
                            ->where('GodzinaZakonczenia', '>=', $godzinaZakonczenia);
                    });
            })
            ->exists();

        $conflictSprzatanie = Sprzatanie::where('SalaID', $request->SalaID)
            ->whereDate('DataSprzatania', $request->DataSprzatania)
            ->where('SprzatanieID', '!=', $id)
            ->where(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                $query->whereBetween('GodzinaRozpoczecia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhereBetween('GodzinaZakonczenia', [$godzinaRozpoczecia, $godzinaZakonczenia])
                    ->orWhere(function ($query) use ($godzinaRozpoczecia, $godzinaZakonczenia) {
                        $query->where('GodzinaRozpoczecia', '<=', $godzinaRozpoczecia)
                            ->where('GodzinaZakonczenia', '>=', $godzinaZakonczenia);
                    });
            })
            ->exists();

        if ($conflictSeans || $conflictSprzatanie) {
            return redirect()->route('harmonogram.editSprzatanie', $id)
                ->with('error', 'Nie można zaktualizować sprzątania, ponieważ odbywa się inny seans lub sprzątanie w tym samym czasie w tej samej sali.');
        }


        $sprzatanie = Sprzatanie::findOrFail($id);
        $sprzatanie->SalaID = $request->SalaID;
        $sprzatanie->PracownikID = $request->PracownikID;
        $sprzatanie->DataSprzatania = $request->DataSprzatania;
        $sprzatanie->GodzinaRozpoczecia = $godzinaRozpoczecia;
        $sprzatanie->GodzinaZakonczenia = $godzinaZakonczenia;
        $sprzatanie->save();

        return redirect()->route('harmonogram.index')->with('success', 'Sprzątanie zostało zaktualizowane!');
    }

    public function destroySprzatanie($id)
    {
        $sprzatanie = Sprzatanie::findOrFail($id);
        $sprzatanie->delete();

        return redirect()->route('harmonogram.index')->with('success', 'Sprzątanie zostało usunięte!');
    }
}
