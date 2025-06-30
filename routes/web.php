<?php
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PracownicyController;
use App\Http\Controllers\HarmonogramController;
use App\Http\Controllers\BiletController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatystykiController;
use App\Http\Controllers\KinoController;
use App\Http\Controllers\RepertuarController;
use App\Http\Controllers\GrafikController;
use App\Models\Rezerwacja;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');


Route::get('/profil/edit', [ProfileController::class, 'edit'])
    ->name('profil.edit')
    ->middleware('auth'); 


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//ścieżki dla kina
Route::get('/kino', [KinoController::class, 'index'])->name('kino');
Route::get('/repertuar', [RepertuarController::class, 'index'])->name('repertuar.index');
Route::get('/kontakt', [KinoController::class, 'kontakt'])->name('kontakt');
Route::get('/seans/{film}/{seans}', [RepertuarController::class, 'show'])->name('repertuar.show');
Route::post('/bilety/rezerwuj/{seansId}', [RepertuarController::class, 'rezerwujMiejsca'])->name('bilety.rezerwuj');
Route::get('/sprawdz-kod-rezerwacji/{kod}/{seansId}', function ($kod, $seansId) {
    $istnieje = Rezerwacja::where('Kod', $kod)->where('SeansID', $seansId)->exists();
    return response()->json(['unikalny' => !$istnieje]);
});

Route::middleware('auth')->group(function () {
   
    Route::get('/sprzatanie', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Sprzątanie')) {
            return app(DashboardController::class)->grafiksprzatanie(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('sprzatanie.index');

    Route::get('/sprzedawca', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Sprzedawca')) {
            return app(DashboardController::class)->grafiksprzedawca(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('sprzedawca.index');

});
 
//ścieżki dla grafiku
Route::middleware('auth')->group(function () {
   
    Route::get('/grafik', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(GrafikController::class)->index(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('grafik.index');

    Route::get('/grafik/create', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(GrafikController::class)->create(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('grafik.create');

    Route::post('/grafik/store', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(GrafikController::class)->store(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('grafik.store');
   
Route::get('/grafik/{id}/edit', function ($id) {
    $user = Auth::user();

    if ($user && ($user->Rola === 'Właściciel')) {
        return app(GrafikController::class)->edit($id);
    }

    abort(403, 'Nie masz dostępu do tej strony.');
})->name('grafik.edit');


Route::put('/grafik/{id}', function ($id) {
    $user = Auth::user();

    if ($user && ($user->Rola === 'Właściciel')) {
        return app(GrafikController::class)->update(request(), $id);
    }

    abort(403, 'Nie masz dostępu do tej strony.');
})->name('grafik.update');


Route::delete('/grafik/{id}', function ($id) {
    $user = Auth::user();

    if ($user && ($user->Rola === 'Właściciel')) {
        return app(GrafikController::class)->destroy($id);
    }

    abort(403, 'Nie masz dostępu do tej strony.');
})->name('grafik.destroy');
});

//ścieżki dla statystyk
Route::middleware('auth')->group(function () {
   
    Route::get('/statystyki', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(StatystykiController::class)->index(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('statystyki.index');

  
    Route::get('/statystyki/get-seans-dates/{filmId}', function ($filmId) {
        $user = Auth::user();
    
        if ($user && $user->Rola === 'Właściciel') {
            return app(StatystykiController::class)->getSeansDates($filmId);
        }
    
        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('statystyki.getSeansDates');
    
});

//ścieżki dla pracowników
Route::middleware('auth')->group(function () {
    Route::get('/pracownicy', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(PracownicyController::class)->index(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('pracownicy.index');
    Route::get('/pracownicy/create', function () {
        $user = Auth::user();

        if ($user && $user->Rola === 'Właściciel') {
            return app(PracownicyController::class)->create();
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('pracownicy.create');

    
    Route::post('/pracownicy', function () {
        $user = Auth::user();

        if ($user && $user->Rola === 'Właściciel') {
            return app(PracownicyController::class)->store(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('pracownicy.store');

    Route::delete('/pracownicy/{pracownik}/usun', function ($pracownik) {
        $user = Auth::user();
    
        if ($user && $user->Rola === 'Właściciel') {
            return app(PracownicyController::class)->destroy($pracownik);
        }
    
        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('pracownicy.destroy');
    
    
});
//ścieżki dla biletów
Route::middleware('auth')->group(function () {
   
    Route::get('/bilety', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Sprzedawca' )) {
            return app(BiletController::class)->index(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('bilety.index');

  
    Route::post('/bilety/{seansId}', function ($seansId) {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Sprzedawca')) {
            return app(BiletController::class)->kupBilet(request(), $seansId);
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('bilety.kup');
    
    Route::post('/bilety/{id}/anuluj', function ($id) {
        $user = Auth::user();

    if ($user && ($user->Rola === 'Sprzedawca')) {
        return app(BiletController::class)->anuluj($id);
    }

    abort(403, 'Nie masz dostępu do tej strony.');
})->name('bilety.anuluj');
    
Route::delete('/bilety/zwolnij/{rezerwacjaId}', function ($rezerwacjaID) {
    $user = Auth::user();

    
    if ($user && ($user->Rola === 'Sprzedawca' || $user->Rola === 'Właściciel')) {
        
        return app(BiletController::class)->zwolnijRezerwacje($rezerwacjaID);
    }

   
    abort(403, 'Nie masz dostępu do tej strony.');
})->name('bilety.zwolnij'); 

Route::delete('/bilety/zwolnij/{rezerwacjaId}', function ($rezerwacjaID) {
    $user = Auth::user();

    
    if ($user && ($user->Rola === 'Sprzedawca' || $user->Rola === 'Właściciel')) {
        
        return app(BiletController::class)->zwolnijRezerwacje($rezerwacjaID);
    }

   
    abort(403, 'Nie masz dostępu do tej strony.');
})->name('bilety.zwolnij'); 

Route::post('/bilety/zwolnij/{rezerwacjaId}', function ($rezerwacjaId) {
    $user = Auth::user();

   
    if ($user && ($user->Rola === 'Sprzedawca' || $user->Rola === 'Właściciel')) {
        return app(BiletController::class)->zatwierdzBilety(request(), $rezerwacjaId);
    }

    
    abort(403, 'Nie masz dostępu do tej strony.');
})->name('bilety.zatwierdz');

});



//ścieżki dla filmów
Route::middleware('auth')->group(function () {
    Route::get('/filmy', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(FilmController::class)->index(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('filmy.index');

    Route::get('/filmy/create', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(FilmController::class)->create();
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('filmy.create');

    Route::post('/filmy', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(FilmController::class)->store(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('filmy.store');

    
    Route::get('/filmy/{film}/edit', function ($film) {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(FilmController::class)->edit($film, request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('filmy.edit');

    Route::put('/filmy/{film}', function (Request $request, $film) {
        $user = Auth::user();
    
        if ($user && ($user->Rola === 'Właściciel')) {
            return app(FilmController::class)->update($request, $film);
        }
    
        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('filmy.update');
    

    Route::delete('/filmy/{film}', function ($film) {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(FilmController::class)->destroy($film);
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('filmy.destroy');
});




//ścieżki dla harmonogramu
Route::middleware('auth')->group(function () {

    
    Route::get('/harmonogram', function() {
        $user = Auth::user();
        if ($user && ($user->Rola === 'Właściciel')) {
            return app(HarmonogramController::class)->index(request()); 
        }
        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('harmonogram.index');

    
    Route::get('/harmonogram/create', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(HarmonogramController::class)->createSeans();
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('harmonogram.create');
    
    Route::get('/grafik/pracownicy', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(HarmonogramController::class)->getPracownicyByDate(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('grafik.pracownicy');

    Route::post('/harmonogram/store', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(HarmonogramController::class)->storeSeans(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('harmonogram.store');

    Route::get('/grafik/sprzatanie', function () {
        $user = Auth::user();
    
        if ($user && $user->Rola === 'Właściciel') {
            return app(HarmonogramController::class)->getPracownicy(request());
        }
    
        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('grafik.sprzatanie');

    Route::get('/grafik/sprzatanieEdit', function () {
        $user = Auth::user();
    
        if ($user && $user->Rola === 'Właściciel') {
            return app(HarmonogramController::class)->getPracownicyEdit(request());
        }
    
        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('grafik.sprzatanieEdit');
    
    Route::get('/harmonogram/sprzatanie/create', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(HarmonogramController::class)->createSprzatanie();
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('harmonogram.createSprzatanie');

    
    Route::post('/harmonogram/sprzatanie/store', function () {
        $user = Auth::user();

        if ($user && ($user->Rola === 'Właściciel')) {
            return app(HarmonogramController::class)->storeSprzatanie(request());
        }

        abort(403, 'Nie masz dostępu do tej strony.');
    })->name('harmonogram.storeSprzatanie');
  
Route::get('/harmonogram/seans/{id}/edit', function ($id) {
    $user = Auth::user();

    if ($user && ($user->Rola === 'Właściciel')) {
        return app(HarmonogramController::class)->editSeans($id);
    }

    abort(403, 'Nie masz dostępu do tej strony.');
})->name('harmonogram.editSeans');


Route::put('/harmonogram/seans/{id}/update', function (Illuminate\Http\Request $request, $id) {
    $user = Auth::user();
    if ($user && ($user->Rola === 'Właściciel')) {
        return app(HarmonogramController::class)->updateSeans($request, $id);
    }
    \abort(403, 'Nie masz dostępu do tej strony.');
})->name('harmonogram.updateSeans');


Route::delete('/harmonogram/seans/{id}/destroy', function ($id) {
    $user = Auth::user();

    if ($user && ($user->Rola === 'Właściciel')) {
        return app(HarmonogramController::class)->destroySeans($id);
    }

    abort(403, 'Nie masz dostępu do tej strony.');
})->name('harmonogram.destroySeans');


Route::get('/harmonogram/sprzatanie/{id}/edit', function ($id) {
    $user = Auth::user();

   
    if ($user && ($user->Rola === 'Właściciel')) {
        return app(HarmonogramController::class)->editSprzatanie($id);
    }

    abort(403, 'Nie masz dostępu do tej strony.');
})->name('harmonogram.editSprzatanie');

Route::delete('/harmonogram/sprzatanie/{id}/destroy', function ($id) {
    $user = Auth::user();

    if ($user && ($user->Rola === 'Właściciel' || $user->Rola === 'Sprzedawca')) {
        return app(HarmonogramController::class)->destroySprzatanie($id);
    }

    abort(403, 'Nie masz dostępu do tej strony.');
})->name('harmonogram.destroySprzatanie');

Route::put('/harmonogram/sprzatanie/{id}/update', function (Request $request, $id) {
    $user = Auth::user();

    if ($user && ($user->Rola === 'Właściciel')) {
        return app(HarmonogramController::class)->updateSprzatanie($request, $id);
    }

    abort(403, 'Nie masz dostępu do tej strony.');
})->name('harmonogram.updateSprzatanie');



});

require __DIR__.'/auth.php';
