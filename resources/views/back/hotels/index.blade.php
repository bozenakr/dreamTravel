@extends('layouts.app')

@section('content')
@section('title', 'Hotels')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>All hotels</h1>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($hotels as $hotel)
                        <li class="list-group-item">
                            <div class="list-table">
                                <div class="d-flex">
                                    <h5 class="m-2">{{$hotel->title}}</h5>
                                    <div class="m-2">{{$hotel->hotelCountry->title}}</div>
                                    <div class="m-2">{{$hotel->days}}</div>
                                    <div class="m-2">{{$hotel->price}}</div>
                                </div>
                                <div>
                                    <div class="d-flex">
                                        <a href="{{route('hotels-show', $hotel)}}" class="btn btn-outline-success">Show</a>
                                        <a href="{{route('hotels-edit', $hotel)}}" class="btn btn-outline-success">Edit</a>
                                        <form action="{{route('hotels-delete', $hotel)}}" method="post">
                                            <button hotel="submit" class="btn btn-outline-danger">Delete</button>
                                    </div>
                                    @csrf
                                    @method('delete')
                                    </form>
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
