<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Seans;
use App\Models\Bilet;
use App\Models\Miejsce;
use App\Models\Film;
use App\Models\Rezerwacja;

class BiletController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('pl');
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


        $wybranyDzien = $request->input('data', \Carbon\Carbon::now('Europe/Warsaw')->toDateString());



        if ($wybranyDzien == now()->toDateString()) {

            $seanse = Seans::whereDate('DataSeansu', $wybranyDzien)
                ->where('GodzinaZakonczenia', '>', now()->setTimezone('Europe/Warsaw'))
                ->orderBy('GodzinaRozpoczecia', 'asc')
                ->get();
        } else {

            $seanse = Seans::whereDate('DataSeansu', $wybranyDzien)
                ->orderBy('GodzinaRozpoczecia', 'asc')
                ->get();
        }


        $seanseGrupowane = $seanse->groupBy(function ($seans) {
            return $seans->sala->Nazwa;
        });


        $seanseGrupowane = $seanseGrupowane->sortKeys();


        $daneSeansow = $seanseGrupowane->map(function ($seanse) {
            return $seanse->map(function ($seans) {
                $kupioneBilety = Bilet::where('SeansID', $seans->SeansID)->count();
                $zajeteMiejsca = explode(',', $seans->ZajeteMiejsca ?? '');
                $wszystkieMiejsca = $seans->sala->miejsca->count();

                $wolneMiejsca = ($wszystkieMiejsca - count($zajeteMiejsca)) + 1;

                return [
                    'seans' => $seans,
                    'film' => $seans->film,
                    'kupioneBilety' => $kupioneBilety,
                    'wolneMiejsca' => $wolneMiejsca,
                    'rezerwacje' => Rezerwacja::where('SeansID', $seans->SeansID)->get(),
                ];
            });
        });

        return view('bilety.index', compact('daneSeansow', 'dniTygodnia', 'wybranyDzien'));
    }

    public function kupBilet(Request $request, $seansId)
    {
        $seans = Seans::findOrFail($seansId);

        if ($seans->isAnulowany()) {
            return back()->withErrors(['error' => 'Nie można kupić biletu na anulowany seans.']);
        }

        $request->validate([
            'miejsca' => 'required|array|min:1',
            'miejsca.*' => 'exists:miejsca,MiejsceID',
            'typ_biletu' => 'required|in:Normalny,Ulgowy'
        ]);

        $zajeteMiejsca = explode(',', $seans->ZajeteMiejsca ?? '');

        foreach ($request->miejsca as $miejsce) {
            if (in_array($miejsce, $zajeteMiejsca)) {
                return back()->withErrors(['miejsca' => 'Niektóre wybrane miejsca są już zajęte.']);
            }
        }

        foreach ($request->miejsca as $miejsce) {
            Bilet::create([
                'SeansID' => $seansId,
                'MiejsceID' => $miejsce,
                'TypBiletu' => $request->typ_biletu,
                'Cena' => $request->typ_biletu === 'Normalny' ? $seans->film->CenaNormalna : $seans->film->CenaUlgowa,
                'DataSprzedazy' => now()->setTimezone('Europe/Warsaw'),
            ]);
        }

        $noweZajeteMiejsca = array_merge($zajeteMiejsca, $request->miejsca);
        $seans->ZajeteMiejsca = implode(',', $noweZajeteMiejsca);
        $seans->save();

        return redirect()->route('bilety.index')->with('success', 'Zakup biletów zakończony sukcesem!');
    }

    public function anuluj($id)
    {
        $seans = Seans::findOrFail($id);
        $seans->anulowany = true;
        $seans->save();

        return redirect()->route('bilety.index')->with('success', 'Seans został anulowany.');
    }

    public function zwolnijRezerwacje($rezerwacjaId)
    {

        $rezerwacja = Rezerwacja::findOrFail($rezerwacjaId);

        $rezerwacja->delete();

        return redirect()->route('bilety.index')->with('success', 'Rezerwacja została zwolniona.');
    }

    public function zatwierdzBilety(Request $request, $rezerwacjaId)
    {
        $rezerwacja = Rezerwacja::findOrFail($rezerwacjaId);
        $seans = $rezerwacja->seans;

        $normalBilety = (int)$request->normal_bilety;
        $ulgoweBilety = (int)$request->ulgowe_bilety;

        $zarezerwowaneMiejsca = explode(',', $rezerwacja->ZarezerwowaneMiejsca);

        $zajeteMiejsca = explode(',', $seans->ZajeteMiejsca ?? '');

        for ($i = 0; $i < $normalBilety; $i++) {
            Bilet::create([
                'SeansID' => $seans->SeansID,
                'MiejsceID' => $zarezerwowaneMiejsca[$i],
                'TypBiletu' => 'Normalny',
                'Cena' => $seans->film->CenaNormalna,
                'DataSprzedazy' => now()->setTimezone('Europe/Warsaw'),
            ]);
        }

        for ($i = 0; $i < $ulgoweBilety; $i++) {
            Bilet::create([
                'SeansID' => $seans->SeansID,
                'MiejsceID' => $zarezerwowaneMiejsca[$normalBilety + $i],
                'TypBiletu' => 'Ulgowy',
                'Cena' => $seans->film->CenaUlgowa,
                'DataSprzedazy' => now()->setTimezone('Europe/Warsaw'),
            ]);
        }

        $noweZajeteMiejsca = array_merge($zajeteMiejsca, $zarezerwowaneMiejsca);
        $seans->ZajeteMiejsca = implode(',', $noweZajeteMiejsca);
        $seans->save();

        $rezerwacja->delete();

        return redirect()->route('bilety.index')->with('success', 'Rezerwacja została zatwierdzona i bilety zostały sprzedane.');
    }
}
