<?php

namespace App\Services;
use App\Models\Country;

class CategoriesService 
{
    public function test()
    {
        return 'Hello this is Categories Service';
    }

    public function get()
    {
        return Country::all();
    }
}