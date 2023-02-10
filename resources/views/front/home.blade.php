@extends('layouts.front')

@section('content')
@section('title', 'Hotels')

<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-3">
            @include('front.common.cats')
        </div> --}}
        <div class="col-9">
            <div class="card-body">
                <div class="container">
                    <div class="row justify-content-center">
                        @forelse($hotels as $hotel)
                        <div class="col-4">
                            <div class="list-table">
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
                                        <div class="size"> {{$hotel->days}} nights</div>
                                    </div>
                                    <div class="buy">
                                        <div class="price"> {{$hotel->price}} EUR</div>
                                        <form action="{{route('add-to-cart')}}" method="post">
                                            <button type="submit" class="btn btn-outline-primary">Add to cart</button>
                                            <input type="number" min="1" name="count" value="1">
                                            <input type="hidden" name="product" value="{{$hotel->id}}">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        No hotel yet
                        @endforelse
                    </div>
                </div>
            </div>
            {{-- <div class="m-2">{{ $hotels->links() }}
        </div> --}}
    </div>
</div>
</div>
@endsection
