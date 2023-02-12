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
    public function home ()
    {
        $hotels = Hotel::paginate(9);
        
        return view('front.home', [
            'hotels' => $hotels
        ]);
    }

    public function showCategoriesHotels (Country $country)
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

        return redirect()->route('start');
    }

}
