<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Country;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function home (Request $request)
    {
        //be sort search ir per page (su paginate)
        // $hotels = Hotel::paginate(9);
        // return view('front.home', [
        //     'hotels' => $hotels
        // ]);


        //su sort search ir per page
       $perPageShow = in_array($request->per_page, Hotel::PER_PAGE) ? $request->per_page : '15';

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

        $hotels = $hotels->paginate($perPageShow)->withQueryString();
    }
        }

        $countries = Country::all();

        return view('front.home', [
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

    public function showCategoriesHotels (Request $request, Country $country)
    {
        // $hotels = Hotel::where('country_id', $country->id)->paginate(9);
        
        // return view('front.home', [
            //     'hotels' => $hotels
            // ]);
            
        $perPageShow = in_array($request->per_page, Hotel::PER_PAGE) ? $request->per_page : '15';
        $hotels = Hotel::where('country_id', $country->id)->paginate(9);

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

        }

    $countries = Country::all();

    return view('front.home', [
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


    public function showHotel (Hotel $hotel)
    {
        return view('front.hotel', [
            'hotel' => $hotel
        ]);
    }

        public function addToCart(Request $request, CartService $cart)
    {
        $id = (int) $request->product;
        $count = (int) $request->count;
        $cart->add($id, $count);
        return redirect()->back();
    }

    public function cart(CartService $cart)
    {
        return view('front.cart', [
            'cartList' => $cart->list
        ]);
    }

    //delete per update, nes viskas yra vienoje formoje, ir update ir delete
    public function updateCart(Request $request, CartService $cart)
    {
       
        if ($request->delete) {
            $cart->delete($request->delete);
        } else {
        $updatedCart = array_combine($request->ids ?? [], $request->count ?? []);
        $cart->update($updatedCart);
        }
        return redirect()->back();
    }

    public function makeOrder(CartService $cart)
    {
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->order_json = json_encode($cart->order());

        $order->save();

        $cart->empty();

        //alert
        return redirect()->route('start')->with('ok', 'Hotel succesfully booked');
    }

}
