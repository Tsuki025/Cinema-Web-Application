<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seans extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'Seanse';
    protected $primaryKey = 'SeansID';
    protected $fillable = [
        'FilmID', 'SalaID', 'DataSeansu', 'GodzinaRozpoczecia','GodzinaZakonczenia', 'Typ', 'Typ2', 'Publicznosc','anulowany'
    ];
    public function isAnulowany()
    {
        return $this->anulowany;
    }
    public function film()
    {
        return $this->belongsTo(Film::class, 'FilmID');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'SalaID');
    }
    public function rezerwacje()
{
    return $this->hasMany(Rezerwacja::class, 'SeansID');
}

}
