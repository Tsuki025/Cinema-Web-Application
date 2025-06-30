<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprzatanie extends Model
{
    protected $table = 'Sprzatanie';
    public $timestamps = false;
    protected $primaryKey = 'SprzatanieID';
    protected $fillable = [
        'PracownikID', 'SalaID', 'DataSprzatania', 'GodzinaRozpoczecia','GodzinaZakonczenia'
    ];
  
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'SalaID');
        
    }

  
    public function pracownik()
    {
        return $this->belongsTo(Pracownik::class, 'PracownikID');
    }
    
}
