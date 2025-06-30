<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grafik;
use App\Models\Pracownik;
use Carbon\Carbon;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
           
        $data = $request->input('data', Carbon::now('Europe/Warsaw')->locale('pl')->toDateString());

        $grafik = Grafik::where('data', $data)
            ->with('pracownik')
            ->orderBy('GodzinaOd', 'asc')
            ->get();

        return view('grafik.index', compact('grafik', 'data'));
    }
    public function create(Request $request)
    {
        $data = $request->input('data', Carbon::today()->setTimezone('Europe/Warsaw'));
        $pracownicy = Pracownik::where('Rola', '!=', 'Właściciel')->get();

        return view('grafik.create', compact('data', 'pracownicy'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'PracownikID' => 'required|exists:pracownicy,PracownikID',
            'data' => 'required|date',
            'zmiana' => 'required|in:1,2',
        ]);


        if ($request->input('zmiana') == 1) {
            $godzinaOd = '08:00';
            $godzinaDo = '16:00';
        } else {
            $godzinaOd = '16:00';
            $godzinaDo = '23:59:59';
        }

        $existingShift = Grafik::where('PracownikID', $request->input('PracownikID'))
            ->where('data', $request->input('data'))
            ->where(function ($query) use ($godzinaOd, $godzinaDo) {

                $query->whereBetween('GodzinaOd', [$godzinaOd, $godzinaDo])
                    ->orWhereBetween('GodzinaDo', [$godzinaOd, $godzinaDo])
                    ->orWhere(function ($query) use ($godzinaOd, $godzinaDo) {
                        $query->where('GodzinaOd', '<', $godzinaDo)
                            ->where('GodzinaDo', '>', $godzinaOd);
                    });
            })
            ->exists();

        if ($existingShift) {
            return redirect()->back()->withErrors(['Pracownik ma już zaplanowaną zmianę na ten dzień i godzinę.']);
        }

        Grafik::create([
            'PracownikID' => $request->input('PracownikID'),
            'data' => $request->input('data'),
            'GodzinaOd' => $godzinaOd,
            'GodzinaDo' => $godzinaDo,
        ]);

        return redirect()->route('grafik.index', ['data' => $request->input('data')])
            ->with('success', 'Grafik został dodany.');
    }
    public function edit($id)
{
    $grafik = Grafik::findOrFail($id);
    $pracownicy = Pracownik::where('Rola', '!=', 'Właściciel')->get();
    return view('grafik.edit', compact('grafik', 'pracownicy'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'PracownikID' => 'required|exists:pracownicy,PracownikID',
        'data' => 'required|date',
        'zmiana' => 'required|in:1,2',
    ]);

    $grafik = Grafik::findOrFail($id);

    $godzinaOd = $request->input('zmiana') == 1 ? '08:00' : '16:00';
    $godzinaDo = $request->input('zmiana') == 1 ? '16:00' : '23:59:59';

    
    

    $grafik->update([
        'PracownikID' => $request->input('PracownikID'),
        'data' => $request->input('data'),
        'GodzinaOd' => $godzinaOd,
        'GodzinaDo' => $godzinaDo,
    ]);

    return redirect()->route('grafik.index', ['data' => $request->input('data')])
        ->with('success', 'Grafik został zaktualizowany.');
}

public function destroy($id)
{
    Grafik::destroy($id);
    return redirect()->route('grafik.index')->with('success', 'Grafik został usunięty.');
}

}
