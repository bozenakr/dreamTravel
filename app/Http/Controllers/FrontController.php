<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Country;

class FrontController extends Controller
{
    public function home ()
    {
        $hotels = Hotel::paginate(9);
        
        return view('front.home', [
            'hotels' => $hotels
        ]);
    }
    public function showCatHotels (Country $country)
    {
        $hotels = Hotel::where('country_id', $country->id)->paginate(9);

        return view('front.home', [
            'hotels' => $hotels
        ]);
    }


        public function showHotel (Hotel $hotel)
    {
        
        return view('front.hotel', [
            'hotel' => $hotel
        ]);
    }
}
