@extends('layouts.app')

@section('content')
@section('title', 'Hotels')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 style="justify-content: center; display: flex">All hotels</h1>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($hotels as $hotel)
                        <li class="list-group-item">
                            <div class="list-table">
                                <div class="d-flex">
                                    @if($hotel->photo)
                                    <img class="small-img" src="{{asset($hotel->photo)}}">
                                    @endif
                                    <h5 class="m-2">{{$hotel->title}}</h5>
                                    <div class="m-2">{{$hotel->hotelCountry->title}}</div>
                                    <div class="m-2">{{$hotel->startNice}}</div>
                                    <div class="m-2">{{$hotel->endNice}}</div>
                                    <div class="m-2">{{$hotel->nights}} nights
                                    </div>
                                    <div class="m-2">{{$hotel->price}} EUR</div>
                                </div>
                                <div>
                                    <div class="d-flex">
                                        <a href="{{route('hotels-show', $hotel)}}" class="btn btn-outline-success">Show</a>
                                        <a href="{{route('hotels-edit', $hotel)}}" class="btn btn-outline-success">Edit</a>

                                        {{-- delete rodomas tik admin --}}
                                        @if(Auth::user()?->role == 'admin')
                                        <form action="{{route('hotels-delete', $hotel)}}" method="post">
                                            <button hotel="submit" class="btn btn-outline-danger">Delete</button>
                                    </div>
                                    @csrf
                                    @method('delete')
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">No hotels yet</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
