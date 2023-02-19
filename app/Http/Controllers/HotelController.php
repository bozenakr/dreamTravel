<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Country;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {

        $perPageShow = in_array($request->per_page, Hotel::PER_PAGE) ? $request->per_page : '15';
        $hotels = Hotel::orderBy('id', 'desc');

       if (!$request->s) {
            if ($request->country_id && $request->country_id != 'all'){
                $hotels = Hotel::where('country_id', $request->country_id);
            }
            else {
                $hotels = Hotel::where('id', '>', 0);
            }

            $hotels = match($request->sort ?? '') {
                'asc_price' => $hotels->orderBy('price'),
                'desc_price' => $hotels->orderBy('price', 'desc'),
                default => $hotels
            };

            if ($perPageShow == 'all'){
                $hotels = $hotels->get();
            } else {
                $hotels = $hotels->paginate($perPageShow)->withQueryString();
            }
        }
        else {
            if ($request->s) {
                $s = explode(' ', $request->s);

                $hotels = Hotel::where(function($query) use ($s) {
                    foreach ($s as $keyword) {
                        //iesko bent vieno sutampancio
                        // $query->orWhere('title', 'like', '%'.$keyword.'%');
                        //iesko visu sutampanciu
                        $query->Where('title', 'like', '%'.$keyword.'%');
                    }
                });

                if ($perPageShow == 'all'){
                    $hotels = $hotels->get();
                } else {
                    $hotels = $hotels->paginate($perPageShow)->withQueryString();
                }
            }
        }

        $countries = Country::all();

        return view('back.hotels.index', [
            'hotels' => $hotels,
            'sortSelect' => Hotel::SORT,
            'sortShow' => isset(Hotel::SORT[$request->sort]) ? $request->sort : '',
            'perPageSelect' => Hotel::PER_PAGE,
            'perPageShow' => $perPageShow,
            'countries' => $countries,
            'countryShow' => $request->country_id ? $request->country_id : '',
            's' => $request->s ?? ''
        ]);
    }


        // $hotels = Hotel::orderBy('id', 'desc')->get();

        // //Datos formatavimas
        // $hotels = $hotels->map(function($format_date) {
        //     $format_date->startNice = Carbon::parse($format_date->start)->format('Y-m-d');
        //     $format_date->endNice = Carbon::parse($format_date->end)->format('Y-m-d');
        //     return $format_date;
        // });
        // return view('back.hotels.index', [
        //     'hotels' => $hotels
        // ]);
    

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

        //VALIDATION
        $validator = Validator::make(
        $request->all(),
        [
        //only letters, spaces + lt letters + min 3 letters
        'hotel_title' => 'required|min:3|regex:/^([a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ&\s]+){3,}$/',
        'hotel_price' => 'required|regex:/^[1-9]\d*(\.\d{1,2})?$/',

        ],
        [
            'hotel_title.required' => 'Hotel name field can not be empty.',
            'hotel_title.min' => 'Hotel name - please enter at least 3 characters.',
            'hotel_title.regex' => 'regex Please enter correct hotel name.',
            'hotel_price.required' => 'Price field can not be empty.',
            'hotel_price.regex' => 'Please enter a valid price (minimum 1.00 EUR).',
        ]);
            
            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }


        $hotel = new Hotel;

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $ext = $photo->getClientOriginalExtension();
            $name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $file = $name. '-' . rand(100000, 999999). '.' . $ext;
            
            $manager = new ImageManager(['driver' => 'GD']);

            $photo->move(public_path().'/hotels', $file);//save i disc
            $hotel->photo = '/hotels/' . $file;//save i db

        }

        //CARBON (start ir end tai objektai)
        //formoje 'hotel_start', DB 'start'
        $start = Carbon::parse($request->hotel_start);
        // $end = Carbon::parse($request->hotel_end)->addDays($request->hotel_nights);
        $end = Carbon::parse($request->hotel_end);
        $stay_length = Carbon::parse($start)->diffInDays($end);

        
        //i DB
        $hotel->country_id = $request->country_id;
        $hotel->title = $request->hotel_title;
        
        //CARBON
        $hotel->start = $start;
        $hotel->end = $end;
        $hotel->nights = $stay_length;
        $hotel->price = $request->hotel_price;
        $hotel->desc = $request->hotel_desc;
        
        
        //Carbon comparing
        // eq() equals
        // ne() not equals
        // gt() greater than
        // gte() greater than or equals
        // lt() less than
        // lte() less than or equals
        
        $x = $hotel->hotelCountry->season_start;
        $y = $hotel->hotelCountry->season_end;
        $a = $request->hotel_start;
        $b = $request->hotel_end;

        // dd($x);
        // dd($a);
        
        if (($x > $a) || ($y < $b)) {
            return redirect()->back()->with('no', 'Out of season! In ' . ' ' . $hotel->hotelCountry->title . ' pick date from ' . $x . ' to ' . $y);
        }
        else {
        $hotel->save();
        return redirect()->route('hotels-index')->with('ok', 'Hotel succesfully added');
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {      
        return view('back.hotels.show', [
            'hotel' => $hotel]);
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
        //VALIDATION
        $validator = Validator::make(
        $request->all(),
        [
        //only letters, spaces + lt letters + min 3 letters
        'hotel_title' => 'required|min:3|regex:/^([a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ&\s]+){3,}$/',
        'hotel_price' => 'required|regex:/^[1-9]\d*(\.\d{1,2})?$/',

        ],
        [
            'hotel_title.required' => 'Hotel name field can not be empty.',
            'hotel_title.min' => 'Hotel name - please enter at least 3 characters.',
            'hotel_title.regex' => 'Please enter correct hotel name.',
            'hotel_price.required' => 'Price field can not be empty.',
            'hotel_price.regex' => 'Please enter a valid price (minimum 1.00 EUR).',
        ]);
            
            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }



        //Pictures
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
        
        // $hotel->country_id = $request->country_id;
        // $hotel->title = $request->hotel_title;
        // $hotel->nights = $request->hotel_nights;
        // $hotel->price = $request->hotel_price;
        // $hotel->desc = $request->hotel_desc;


        //CARBON (start ir end tai objektai);
        //formoje - 'hotel_start, hotel_end', DB - 'start, end'
        $start = Carbon::parse($request->hotel_start);
        // $end = Carbon::parse($request->hotel_end)->addDays($request->hotel_nights);
        $end = Carbon::parse($request->hotel_end);
        $stay_length = Carbon::parse($start)->diffInDays($end);

     
        //i DB is formos
        $hotel->country_id = $request->country_id;
        $hotel->title = $request->hotel_title;
        //CARBON
        $hotel->start = $start;
        $hotel->end = $end;
        $hotel->nights = $stay_length;
        $hotel->price = $request->hotel_price;
        $hotel->desc = $request->hotel_desc;


       //Carbon comparing
        // eq() equals
        // ne() not equals
        // gt() greater than
        // gte() greater than or equals
        // lt() less than
        // lte() less than or equals
        
        $x = $hotel->hotelCountry->season_start;
        $y = $hotel->hotelCountry->season_end;
        $a = $request->hotel_start;
        $b = $request->hotel_end;

        // dd($x);
        // dd($a);
        
        if (($x > $a) || ($y < $b)) {
            return redirect()->back()->with('no', 'Out of season! In ' . ' ' . $hotel->hotelCountry->title . ' pick date from ' . $x . ' to ' . $y);
        }
        else {
        $hotel->save();
        return redirect()->route('hotels-index')->with('ok', 'Hotel succesfully edited');
        }
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
        // $qrCode = 
        $pdf = Pdf::loadView('back.hotels.pdf', ['hotel' => $hotel]);
        return $pdf->download('dreamTravel '.'-'.' '.$hotel->title.'.pdf');
    }
}