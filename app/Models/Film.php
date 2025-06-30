<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $table = 'Filmy';
    protected $primaryKey = 'FilmID';

    protected $fillable = [
        'Tytul',
        'Opis',
        'ZwiastunURL',
        'CenaNormalna',
        'CenaUlgowa',
        'DataDodania',
        'Plakat',
        'Wiek',
        'OdKiedy',
        'DoKiedy',
        'Dystrybucja'
    ];

    public $timestamps = false;
    public function seanse()
    {
        return $this->hasMany(Seans::class, 'FilmID');
    }
   
}
