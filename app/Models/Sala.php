<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;
    protected $table = 'Sale';
    protected $primaryKey = 'SalaID';
    protected $fillable = [
        'Nazwa'
    ];
    public function seanse()
    {
        return $this->hasMany(Seans::class, 'SalaID');
    }
    public function miejsca()
    {
        return $this->hasMany(Miejsce::class, 'SalaID');
    }
}
