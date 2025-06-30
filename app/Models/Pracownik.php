<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pracownik extends Authenticatable
{
    use HasFactory, Notifiable;
    public $timestamps = false;
    protected $table = 'Pracownicy'; 
    protected $primaryKey = 'PracownikID'; 
    protected $fillable = [
        'Imie',
        'Nazwisko',
        'Email',
        'Haslo',
        'Rola'
    ];

    protected $hidden = [
        'Haslo',
    ];
    public function sprzatania()
{
    return $this->hasMany(Sprzatanie::class, 'PracownikID');
}

   
    public function setPasswordAttribute($password)
    {
        $this->attributes['Haslo'] = Hash::make($password);
    }
    public function grafik()
{
    return $this->hasMany(Grafik::class, 'PracownikID');
}

}
