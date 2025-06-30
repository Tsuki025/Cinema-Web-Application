<?php

namespace App\Http\Controllers;

use App\Models\Sprzatanie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\Grafik;
use App\Models\Pracownik;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }


        Carbon::setLocale('pl');

       
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();


    


        if ($user->Rola == 'Właściciel') {
            $response = Response::make(view('dashboard.wlasciciel'));
        } elseif ($user->Rola == 'Sprzedawca') {
            $response = Response::make(view('dashboard.sprzedawca'));
        } elseif ($user->Rola == 'Sprzątanie') {

            $response = Response::make(view('dashboard.sprzatanie'));
        } else {
            return redirect('/');
        }


        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, proxy-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

        return $response;
    }
    public function grafiksprzatanie(Request $request)
{
    $user = Auth::user();

    if (!$user || $user->Rola !== 'Sprzątanie') {
        return redirect()->route('login');
    }

    Carbon::setLocale('pl');

  
    $data = $request->input('data', Carbon::now()->toDateString());

    
    $grafikPracy = Grafik::where('PracownikID', Auth::user()->PracownikID)
        ->whereDate('Data', $data)
        ->first();

   
    $sprzatania = Sprzatanie::where('PracownikID', Auth::user()->PracownikID)
        ->whereDate('DataSprzatania', $data)
        ->orderBy('GodzinaRozpoczecia')
        ->get();

    return view('sprzatanie.index', compact('grafikPracy', 'sprzatania'));
}
public function grafiksprzedawca(Request $request)
{
    $user = Auth::user();

    if (!$user || $user->Rola !== 'Sprzedawca') {
        return redirect()->route('login');
    }

    Carbon::setLocale('pl');

  
    $data = $request->input('data', Carbon::now()->toDateString());

    
    $grafikPracy = Grafik::where('PracownikID', Auth::user()->PracownikID)
        ->whereDate('Data', $data)
        ->first();

   
    

    return view('sprzedawca.index', compact('grafikPracy'));
}
}
