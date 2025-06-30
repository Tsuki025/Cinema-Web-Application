<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bilet extends Model
{
    use HasFactory;

    protected $table = 'bilety'; 
    protected $primaryKey = 'BiletID'; 
    protected $fillable = [
        'SeansID',
        'TypBiletu',
        'Cena',
        'DataSprzedazy',
        'MiejsceID',
    ];
    public $timestamps = false; 
}
