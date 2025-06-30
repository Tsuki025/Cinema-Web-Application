<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seans;
use App\Models\Film;
use App\Models\Bilet;
use App\Models\Miejsce;
use App\Models\Rezerwacja;

class RepertuarController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('pl');
        $dzisiaj = Carbon::now('Europe/Warsaw');
        $dzienTygodnia = $dzisiaj->dayOfWeek;


        $najblizszyPiatek = $dzisiaj->copy()->next(Carbon::FRIDAY);


        $dzisiajJestPiatek = $dzienTygodnia === Carbon::FRIDAY;


        if ($dzisiajJestPiatek) {
            $najblizszyPiatek = $dzisiaj;
        }


        $wybranyDzien = $request->query('data', $dzisiaj->format('Y-m-d'));


        if (Carbon::parse($wybranyDzien)->lt($dzisiaj)) {
            $wybranyDzien = $dzisiaj->format('Y-m-d');
        }


        if (Carbon::parse($wybranyDzien)->gt($najblizszyPiatek) && !$dzisiajJestPiatek) {
            $wybranyDzien = $najblizszyPiatek->format('Y-m-d');
        }


        $dniTygodnia = [];
        for ($i = 0; $i < 7; $i++) {
            $data = $dzisiaj->copy()->addDays($i);


            $dostepny = ($dzisiajJestPiatek || $data->isFriday() || $data->isToday()) ||
                ($data->gte($dzisiaj) && $data->lte($najblizszyPiatek));

            $dniTygodnia[] = [
                'data' => $data->format('Y-m-d'),
                'nazwa' => ucfirst($data->translatedFormat('l')),
                'formatted' => $data->translatedFormat('d.m'),
                'dostepny' => $dostepny,
            ];
        }


        $seanse = Seans::whereDate('DataSeansu', $wybranyDzien)
            ->where(function ($query) {
                $query->whereNull('Anulowany')
                    ->orWhere('Anulowany', false);
            })
            ->where('Publicznosc', 'Publiczny')
            ->when(Carbon::parse($wybranyDzien)->isToday(), function ($query) {
                $query->where('GodzinaZakonczenia', '>', now()->setTimezone('Europe/Warsaw'));
            })
            ->with('film')
            ->orderBy('GodzinaRozpoczecia')
            ->get()
            ->groupBy('FilmID');

        return view('repertuar.index', compact('dniTygodnia', 'wybranyDzien', 'seanse'));
    }



    public function show($filmID, $seansID)
    {
        $dzisiaj = Carbon::now('Europe/Warsaw');
        $film = Film::findOrFail($filmID);


        $seans = Seans::with('film')
            ->where('SeansID', $seansID)
            ->where(function ($query) use ($dzisiaj) {
                $query->whereDate('DataSeansu', '<>', $dzisiaj)
                    ->orWhere(function ($subQuery) use ($dzisiaj) {
                        $subQuery->whereDate('DataSeansu', $dzisiaj)
                            ->where('GodzinaZakonczenia', '>', now()->setTimezone('Europe/Warsaw'));
                    });
            })
            ->firstOrFail();


        if ($seans->anulowany == 1 || $seans->Publicznosc === 'Prywatny') {
            return redirect()->route('repertuar.index')->with('error', 'Ten seans jest anulowany, prywatny lub już się odbył.');
        }

        return view('repertuar.show', compact('film', 'seans'));
    }


    public function rezerwujMiejsca(Request $request, $seansId)
    {
        $request->validate([
            'nr_telefonu' => 'required|numeric',
            'kod_rezerwacji' => 'required|string|max:5|unique:rezerwacje,Kod,NULL,id,SeansID,' . $seansId,
            'miejsca' => 'required|array|min:1',
        ]);

        $seans = Seans::findOrFail($seansId);


        $rezerwacja = new Rezerwacja();
        $rezerwacja->SeansID = $seansId;
        $rezerwacja->NrTelefonu = $request->nr_telefonu;
        $rezerwacja->Kod = $request->kod_rezerwacji;
        $rezerwacja->ZarezerwowaneMiejsca = implode(',', $request->miejsca);
        $rezerwacja->save();

        return redirect()->back()->with('success', 'Rezerwacja zakończona! Twój kod rezerwacji to: ' . $request->kod_rezerwacji);
    }
}
