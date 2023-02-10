<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Country;

class FrontController extends Controller
{
    public function home ()
    {
        $hotels = Hotel::all();
        
        return view('front.home', [
            'hotels' => $hotels
        ] );
    }
}
