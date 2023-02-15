@extends('layouts.app')

@section('content')
@section('title', 'New hotel')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card m-6">
                <div class="card-header">
                    <h2 style="justify-content: center; display: flex">New hotel</h2>
                </div>
                <div class="card-body">
                    <form action="{{route('hotels-store')}}" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label class="form-label">Country</label>
                            <select class="form-select" name="country_id">
                                @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->title}}</option>
                                {{-- <label class="form-label">Season</label>
                                <input type="text" name="" class="form-control" readonly value="{{$country->season_start}} - {{$country->season_end}}"> --}}
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel name</label>
                            <input type="text" name="hotel_title" class="form-control" value="{{old('hotel_title')}}">
                        </div>

                        {{-- DATES --}}
                        <div class="mb-3">
                            <label class="form-label">Check-in</label>
                            <input type="date" name="hotel_start" class="form-control" min="" value="">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Check-out</label>
                            <input type="date" name="hotel_end" class="form-control" value="{{old('hotel_end')}}">
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Nights</label>
                            <input type="text" name="hotel_nights" class="form-control" value="{{old('hotel_nights')}}">
                </div> --}}

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="text" name="hotel_price" class="form-control" value="{{old('hotel_price')}}">
                </div>
                <div class="col-3">
                    <div class="mb-3">
                        <label class="form-label">Hotel Photo</label>
                        <input type="file" class="form-control" name="photo">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Hotel description</label>
                        <textarea class="form-control" rows="10" name="hotel_desc">{{old('hotel_desc')}}</textarea>
                    </div>
                </div>
                <div class="mb-3" style="justify-content: center; display: flex">
                    <button type="submit" class="btn btn-outline-warning mt-4">Add</button>
                </div>
                @csrf
                </form>
            </div>
        </div>
    </div>

</div>
</div>

@endsection
