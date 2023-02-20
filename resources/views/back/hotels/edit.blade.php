@extends('layouts.app')

@section('content')
@section('title', 'Hotel Update')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card m-6">
                <div class="card-header">
                    <h2 style="justify-content: center; display: flex">Update Hotel Information</h2>
                </div>
                <div class="card-body">
                    <form action="{{route('hotels-update', $hotel)}}" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label class="form-label">Country</label>
                            <select class="form-select" name="country_id">
                                @foreach($countries as $country)
                                <option value="{{$country->id}}" @if($country->id == $hotel->country_id) selected @endif>{{$country->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel name</label>
                            <input type="text" name="hotel_title" class="form-control" value="{{ old('hotel_title', $hotel->title) }}">

                        </div>

                        {{-- CARBON DATES --}}
                        <div class="mb-3">
                            <label class="form-label">Check-in</label>
                            <input type="date" name="hotel_start" class="form-control" value="{{ old('hotel_start', $hotel->start) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Check-out</label>
                            <input type="date" name="hotel_end" class="form-control" value="{{ old('hotel_start', $hotel->end) }}">
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Nights</label>
                            <input type="text" name="hotel_nights" class="form-control" value="{{old('nights')}}">
                </div> --}}

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="text" name="hotel_price" class="form-control" value="{{ old('hotel_price', $hotel->price) }}">

                </div>
                <div class="col-3">
                    <div class="mb-3">
                        <label class="form-label">Hotel Photo</label>
                        <input type="file" class="form-control" name="photo">
                    </div>

                    @if($hotel->photo)
                    <div class="col-4">
                        <div class="mb-3 img">
                            <img src="{{asset($hotel->photo)}}">
                        </div>
                    </div>
                    @endif

                </div>
                @if($hotel->photo)
                <button type="submit" class="btn btn-outline-warning mt-2 mb-4" name="delete_photo" value="1">Delete Photo</button>
                @endif

                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Hotel description</label>
                        <textarea class="form-control" rows="10" name="hotel_desc">{{$hotel->desc}}</textarea>
                    </div>
                </div>
                <div class="mb-3" style="justify-content: center; display: flex">
                    <button type="submit" class="btn btn-outline-warning mt-4">Save</button>

                </div>
                @csrf
                @method('put')
                </form>
            </div>
        </div>
    </div>

</div>
</div>

@endsection
