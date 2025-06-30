<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grafik extends Model
{
    use HasFactory;

    protected $table = 'grafik';
    protected $primaryKey = 'GrafikID'; 
    protected $fillable = ['PracownikID', 'data', 'GodzinaOd', 'GodzinaDo'];

   
    public function pracownik()
    {
        return $this->belongsTo(Pracownik::class, 'PracownikID');
    }
    public $timestamps = false;

}
