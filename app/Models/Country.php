<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    public function countryHotels()
    {
    return $this->hasMany(Hotel::class, 'country_id', 'id');
    }

        
    //CARBON
    public $timestamps = false; //jei kuriame su new ir nera timestamps
    protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];
}