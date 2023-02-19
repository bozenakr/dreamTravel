@extends('layouts.front')

@section('content')
@section('title', 'Hotel details')

<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-3">
            @include('front.common.cats')
        </div> --}}
        <div class="col-9">
            <div class="card-body">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="list-table one">
                                <div class="top">
                                    <h3>
                                        {{$hotel->title}}
                                    </h3>
                                    {{-- <a href="{{route('show-hotel', $hotel)}}"> --}}
                                    <div class="smallimg">
                                        @if($hotel->photo)
                                        <img src="{{asset($hotel->photo)}}">
                                        @else
                                        <img src="{{asset('no-img.png')}}">
                                        @endif
                                    </div>
                                    </a>
                                </div>
                                <div class="bottom">
                                    <div>
                                        <div class="type"> {{$hotel->hotelCountry->title}}</div>
                                        <div class="type"> {{$hotel->start}} - {{$hotel->end}}</div>
                                        <div class="size"> {{$hotel->nights}} nights</div>
                                    </div>
                                    <div class="buy">
                                        <div class="price"> {{$hotel->price}} EUR</div>
                                        <form class="buy" action="{{route('add-to-cart')}}" method="post">
                                            <input class="margin-right" type="number" min="1" name="count" value="1">
                                            <button type="submit" class="btn btn-outline-primary">Add to cart</button>
                                            <input type="hidden" name="product" value="{{$hotel->id}}">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
