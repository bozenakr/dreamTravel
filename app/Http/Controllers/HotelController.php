<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Country;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
// use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::all();
        return view('back.hotels.index', [
            'hotels' => $hotels
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all()->sortBy('country');
        return view('back.hotels.create', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hotel = new Hotel;

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $ext = $photo->getClientOriginalExtension();
            $name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $file = $name. '-' . rand(100000, 999999). '.' . $ext;
            
            // $manager = new ImageManager(['driver' => 'GD']);

            $photo->move(public_path().'/hotels', $file);
            $hotel->photo = '/hotels/' . $file;

        }

        $hotel->country_id = $request->country_id;
        $hotel->title = $request->hotel_title;
        $hotel->days = $request->hotel_days;
        $hotel->price = $request->hotel_price;
        $hotel->desc = $request->hotel_desc;

        $hotel->save();

        return redirect()->route('hotels-index')->with('ok', 'Hotel succesfully added');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        return view('back.hotels.show', ['hotel' => $hotel]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        $countries = Country::all()->sortBy('title');
        return view('back.hotels.edit', [
            'hotel' => $hotel,
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
                   
        if ($request->delete_photo) {
            $hotel->deletePhoto();
            return redirect()->back()->with('ok', 'Photo was deleted');
        }

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $ext = $photo->getClientOriginalExtension();
            $name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $file = $name. '-' . rand(100000, 999999). '.' . $ext;
            
            $manager = new ImageManager(['driver' => 'GD']);//sukuriu driveri

            $image = $manager->make($photo);
            $image->resize(400, 300);
            
            if ($hotel->photo) {
                $hotel->deletePhoto();
            }
            
            // $photo->move(public_path().'/hotels', $file);
        
            $image->save(public_path().'/hotels/'.$file); //save i disc
            $hotel->photo = '/hotels/' . $file; //save i db
            
        }
        
        $hotel->country_id = $request->country_id;
        $hotel->title = $request->hotel_title;
        $hotel->days = $request->hotel_days;
        $hotel->price = $request->hotel_price;
        $hotel->desc = $request->hotel_desc;

        $hotel->save();
        
        return redirect()->route('hotels-index')->with('ok', 'Hotel succesfully edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete(); 
        return redirect()->route('hotels-index')->with('ok', 'Hotel successfully deleted');
    }

    public function pdf(hotel $hotel)
    {
        $pdf = Pdf::loadView('back.hotels.pdf', ['hotel' => $hotel]);
        return $pdf->download('dreamTravel '.'-'.' '.$hotel->title.'.pdf');
    }
}