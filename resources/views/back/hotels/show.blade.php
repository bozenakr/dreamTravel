@extends('layouts.app')

@section('content')
@section('title', 'Show hotel')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card m-6">
                <div class="card-header">
                    <h2 style="justify-content: center; display: flex">Show hotel</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Country </label>
                        {{-- persokam i kita lentele (Models-Hotel) --}}
                        {{$hotel->hotelCountry->title}}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hotel name</label>
                        {{$hotel->title}}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Days</label>
                        {{$hotel->days}}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        {{$hotel->price}}
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Hotel description</label>
                            <div>{{$hotel->desc}}</div>
                        </div>
                    </div>
                    @if($hotel->photo)
                    <div class="col-12">
                        <div class="mb-3 img">
                            <img class="fit-img" src="{{asset($hotel->photo)}}">
                        </div>
                    </div>
                    @endif
                    <div class="mb-3" style="justify-content: center; display: flex">
                        <a href="{{route('hotels-pdf', $hotel)}}" class="btn btn-outline-primary">Download PDF</a>
                    </div>
                    <div class="mb-3" style="justify-content: center; display: flex">
                        <a href="{{route('hotels-qrcode', $hotel)}}" class="btn btn-outline-primary">Qr</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
