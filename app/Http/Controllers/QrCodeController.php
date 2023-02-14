<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class QrCodeController extends Controller
{
    public function index(hotel $hotel)
    {
      return view('back.hotels.qrcode', ['hotel' => $hotel]);
    }
}
