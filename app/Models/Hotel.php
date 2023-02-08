<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    const SORT = [
        'asc_name' => 'Name A-Z',
        'desc_name' => 'Name Z-A',
        'asc_size' => 'Size 0-9',
        'desc_size' => 'Size 9-0'
    ];

    const PER_PAGE = [
        'all', 5, 12, 21, 34
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
}