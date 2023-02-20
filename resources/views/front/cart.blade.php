@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-3">
            @include('front.common.categories')
        </div> --}}
        <div class="col-10">
            <div class="card-body">
                <div class="card-body">
                    <form action="{{route('update-cart')}}" method="post">
                        <ul class="list-group">
                            @forelse($cartList as $hotel)
                            <li class="list-group-item">
                                <div class="list-table cart">
                                    <div class="list-table__content">
                                        <div class="smallimg">
                                            @if($hotel->photo)
                                            <img src="{{asset($hotel->photo)}}">
                                            @else
                                            <img src="{{asset('no-img-2.png')}}">
                                            @endif
                                        </div>
                                        <h4 class="col-3">{{$hotel->title}}</h4>

                                        <div class="type col-1"> {{$hotel->hotelCountry->title}}</div>
                                        <div> {{$hotel->price}} eur/person
                                        </div>

                                        <div class="size">
                                            <input type="number" min="1" name="count[]" value="{{$hotel->count}}">
                                            <input type="hidden" name="ids[]" value="{{$hotel->id}}">
                                        </div>
                                        <div class="price"> {{$hotel->sum}} EUR</div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" name="delete" value="{{$hotel->id}}" class="btn btn-delete">Delete</button>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item">Cart Empty</li>
                            @endforelse
                            <li class="d-flex justify-content-end">
                                <button type="submit" class="btn" style="margin:10px">Update cart</button>

                            </li>
                        </ul>
                        @csrf
                    </form>

                    {{-- Make order BUY--}}
                    <form action="{{route('make-order')}}" method="post" class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-buy">Buy</button>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
