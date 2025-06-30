<?php
namespace App\Http\Controllers;

use App\Models\Pracownik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class PracownicyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search'); 

        if ($search) {
          
            $pracownicy = Pracownik::where('Imie', 'like', '%' . $search . '%')
                                  ->orWhere('Nazwisko', 'like', '%' . $search . '%')
                                  ->get();
        } else {
           
            $pracownicy = Pracownik::all();
        }

        return view('pracownicy.index', compact('pracownicy', 'search'));
    }

    public function create()
    {
        return view('pracownicy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Imie' => 'required|string|max:50',
            'Nazwisko' => 'required|string|max:50',
            'Email' => 'required|email|unique:Pracownicy,Email',
            'Haslo' => 'required|string|min:8|confirmed',
            'Rola' => 'required|in:Właściciel,Sprzedawca,Sprzątanie',
        ]);

        Pracownik::create([
            'Imie' => $request->Imie,
            'Nazwisko' => $request->Nazwisko,
            'Email' => $request->Email,
            'Haslo' => Hash::make($request->Haslo), 
            'Rola' => $request->Rola,
        ]);

        return redirect()->route('pracownicy.index')->with('success', 'Pracownik dodany pomyślnie!');
    }
    public function destroy($id)
{
    
    $pracownik = Pracownik::findOrFail($id);

    
    
    \DB::table('Sprzatanie')->where('PracownikID', $id)->delete();
    $pracownik->delete();

   
    return redirect()->route('pracownicy.index')->with('success', 'Pracownik został usunięty!');
}


}
