<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController as H;
use App\Http\Controllers\CountryController as C;
use App\Http\Controllers\FrontController as F;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


//HomeController - redirect i homepage
Route::get('/', [F::class, 'home'])->name('start');

Route::get('/hotel/{hotel}', [F::class, 'showHotel'])->name('show-hotel');
Route::get('/cat/{country}', [F::class, 'showCatHotels'])->name('show-cats-hotels');
Route::post('/add-to-cart', [F::class, 'addToCart'])->name('add-to-cart');

Route::prefix('admin/countries')->name('countries-')->group(function () {
    Route::get('/', [C::class, 'index'])->name('index')->middleware('roles:A|M');
    Route::get('/create', [C::class, 'create'])->name('create')->middleware('roles:A');
    Route::post('/create', [C::class, 'store'])->name('store')->middleware('roles:A');
    Route::get('/edit/{country}', [C::class, 'edit'])->name('edit')->middleware('roles:A');
    Route::put('/edit/{country}', [C::class, 'update'])->name('update')->middleware('roles:A');
    Route::delete('/delete/{country}', [C::class, 'destroy'])->name('delete')->middleware('roles:A');
});

Route::prefix('admin/hotels')->name('hotels-')->group(function () {
    Route::get('/', [H::class, 'index'])->name('index')->middleware('roles:A|M');
    Route::get('/show/{hotel}', [H::class, 'show'])->name('show')->middleware('roles:A|M');
    Route::get('/create', [H::class, 'create'])->name('create')->middleware('roles:A');
    Route::post('/create', [H::class, 'store'])->name('store')->middleware('roles:A');
    Route::get('/edit/{hotel}', [H::class, 'edit'])->name('edit')->middleware('roles:A|M');
    Route::put('/edit/{hotel}', [H::class, 'update'])->name('update')->middleware('roles:A|M');
    Route::delete('/delete/{hotel}', [H::class, 'destroy'])->name('delete')->middleware('roles:A');
    Route::get('/pdf/{hotel}', [H::class, 'pdf'])->name('pdf')->middleware('roles:A|M');
});


Auth::routes();

//disable registration
// Auth::routes(['register' => false]);

//HomeController - redirect i psl welcome youre logged in
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');