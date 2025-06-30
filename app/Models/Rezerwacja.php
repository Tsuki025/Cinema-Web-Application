<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezerwacja extends Model
{
    use HasFactory;

    protected $table = 'rezerwacje'; 
    protected $primaryKey = 'RezerwacjaID'; 
    protected $fillable = [
        'SeansID',
        'ZarezerwowaneMiejsca',
        'NrTelefonu',
        'Kod',
    ];
    
public function seans()
{
    return $this->belongsTo(Seans::class, 'SeansID');
}

    public $timestamps = false; 
}
