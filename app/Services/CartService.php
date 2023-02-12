<?php

namespace App\Services;

use App\Models\Hotel;

class CartService
{

    private $cart, $cartList, $total = 0, $count = 0;
    
    public function __construct()
    {
        $this->cart = session()->get('cart', []);

        $ids = array_keys($this->cart);

        $this->cartList = Hotel::whereIn('id', $ids)
        ->get()
        ->map(function($hotel) {
            $hotel->count = $this->cart[$hotel->id];
            $hotel->sum = $hotel->count * $hotel->price;
            $this->total += $hotel->sum;
            return $hotel;
        });

        $this->count = $this->cartList->count();

    }

    public function __get($props)
    {
        return match($props) {
            'total' => $this->total,
            'count' => $this->count,
            'list' => $this->cartList,
            default => null
        };
    }


    public function add(int $id, int $count)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id] += $count;
        }
        else {
            $this->cart[$id] = $count;
        }
        session()->put('cart', $this->cart);
    }

    public function update(array $cart)
    {
        session()->put('cart', $cart);
    }

    
    public function delete(int $id)
    {
        unset($this->cart[$id]);
        session()->put('cart', $this->cart);
    }

    public function order()
    {
        $order = (object)[];
        $order->total = $this->total;
        $order->hotels = [];

        foreach ($this->cartList as $hotel) {
            $order->hotels[] = (object)[
                'title' => $hotel->title,
                'count' => $hotel->count,
                'price' => $hotel->price,
                'id' => $hotel->id
            ];
        }

        return $order;
    }

    public function empty()
    {
        session()->put('cart', []);
        $this->total = 0;
        $this->count = 0;
        $this->cartList = collect();
        $this->cart = [];
    }


    
    
    public function test()
    {
        return 'Hello this is Cart Service';
    }



}