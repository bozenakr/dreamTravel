<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    const SORT = [
        // 'asc_name' => 'Name A-Z',
        // 'desc_name' => 'Name Z-A',
        'asc_price' => 'Price ascending',
        'desc_price' => 'Price descending',
    ];

    const PER_PAGE = [
        'all', 9, 15, 27
    ];

    public function hotelCountry()
    {
    return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function deletePhoto()
    {
        $fileName = $this->photo;
        if (file_exists(public_path().$fileName)) {
            unlink(public_path().$fileName);
        }
        $this->photo = null;
        $this->save();
    }
    //CARBON
    public $timestamps = false; //jei kuriame su new ir nera timestamps
        protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];
}