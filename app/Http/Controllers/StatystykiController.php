<?php
namespace App\Http\Controllers;

use App\Models\Seans;
use App\Models\Bilet;
use App\Models\Film;
use Illuminate\Http\Request;

class StatystykiController extends Controller
{
    public function index(Request $request)
    {
        
        if ($request->filled('okres') && $request->okres != 'wszystkie') {
            if ($request->okres == 'aktualne') {
                
                $filmy = Film::where('DoKiedy', '>=', now())->get();
            } elseif ($request->okres == 'ostatni_rok') {
                
                $filmy = Film::whereBetween('OdKiedy', [now()->subYear(), now()])->get();
            }
        } else {
            
            $filmy = Film::all();
        }
    
        $query = Seans::whereRaw('(Anulowany = false OR Anulowany IS NULL)');

        if ($request->filled('film_id')) {
            $query->where('FilmID', $request->film_id);
        }
        if ($request->filled('typ')) {
            $query->where('Typ', $request->typ);
        }
        if ($request->filled('typ2')) {
            $query->where('Typ2', $request->typ2);
        }
        if ($request->filled('data_od')) {
            $query->where('DataSeansu', '>=', $request->data_od);
        }
        if ($request->filled('data_do')) {
            $query->where('DataSeansu', '<=', $request->data_do);
        }
        if ($request->filled('pora_dnia')) {
            switch ($request->pora_dnia) {
                case 'rano':
                    $query->where('GodzinaZakonczenia', '<=', '12:00:00');
                    break;
                case 'popoludnie':
                    $query->whereBetween('GodzinaZakonczenia', ['12:01:00', '16:00:00']);
                    break;
                case 'wieczor':
                    $query->whereBetween('GodzinaZakonczenia', ['16:01:00', '20:00:00']);
                    break;
                case 'noc':
                    $query->whereBetween('GodzinaZakonczenia', ['20:01:00', '23:59:59']);
                    break;
            }
        }
        $seanse = $query->get();

        $przychod = 0;
        $sprzedaneBilety = 0;
        $wszystkieMiejsca = 0;
        $procentSprzedanych = 0;
        $filmTytul = '';

        if ($request->filled('film_id')) {
            $film = Film::find($request->film_id);
            $filmTytul = $film ? $film->Tytul : 'Nieznany';
            
            foreach ($seanse as $seans) {
                $kupioneBilety = Bilet::where('SeansID', $seans->SeansID)->count();
                $wszystkieMiejsca += $seans->sala->miejsca->count();

                $przychod += $kupioneBilety * $seans->film->CenaNormalna;
                $sprzedaneBilety += $kupioneBilety;
            }

            if ($wszystkieMiejsca > 0) {
                $procentSprzedanych = round(($sprzedaneBilety / $wszystkieMiejsca) * 100, 2);
            }
        }

        return view('statystyki.index', compact('filmy', 'przychod', 'filmTytul', 'sprzedaneBilety', 'wszystkieMiejsca', 'procentSprzedanych'));
    }
    public function getSeansDates($filmId)
    {
       
        $seanse = Seans::where('FilmID', $filmId)
                       ->whereRaw('(Anulowany = false OR Anulowany IS NULL)')
                       ->get();

       
        if ($seanse->isEmpty()) {
            return response()->json(['min_date' => '', 'max_date' => '']);
        }

        
        $minDate = $seanse->min('DataSeansu');
        $maxDate = $seanse->max('DataSeansu');

        return response()->json([
            'min_date' => $minDate,
            'max_date' => $maxDate
        ]);
    }
    
}
