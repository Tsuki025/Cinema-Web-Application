<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miejsce extends Model
{
    use HasFactory;

    protected $table = 'miejsca'; 
    protected $primaryKey = 'MiejsceID'; 
    protected $fillable = [
        'SalaID',
        'Rzad',
        'NumerMiejsca',
        
    ];
    public $timestamps = false; 
}
