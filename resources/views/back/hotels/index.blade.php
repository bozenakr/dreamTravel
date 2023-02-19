@extends('layouts.app')

@section('content')
@section('title', 'Hotels')



<form action="{{route('hotels-index')}}" method="get">
    <div class="container">
        <div class="row justify-content-space-between">

            {{-- SEARCH --}}
            <div class="col-2">
                <div class="mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" class="form-control" name="s" value="{{$s}}">
                </div>
            </div>
            <div class="col-2">
                <div class="head-buttons">
                    <button type="submit" class="btn btn-outline-success" style="margin-top: 30px">Search</button>
                </div>
            </div>

            {{-- SORT BY --}}
            <div class="col-2">
                <div class="mb-3">
                    <label class="form-label">Sort by</label>
                    <select class="form-select" name="sort">
                        <option>default</option>
                        @foreach($sortSelect as $value => $name)
                        <option value="{{$value}}" @if($sortShow==$value) selected @endif>{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- PER PAGE PAGINATOR --}}
            {{-- Arba cia per page arba paginate --}}
            <div class="col-2">
                <div class="mb-3">
                    <label class="form-label">Per page</label>
                    <select class="form-select" name="per_page">
                        @foreach($perPageSelect as $value)
                        <option value="{{$value}}" @if($perPageShow==$value) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- SELECT COUNTRY --}}
            {{-- Arba cia select country arba categories blade --}}
            <div class="col-2">
                <div class="mb-3">
                    <label class="form-label">Select Country</label>
                    <select class="form-select" name="country_id">
                        <option value="all">All</option>
                        @foreach($countries as $country)
                        <option value="{{$country->id}}" @if($country->id == $countryShow) selected @endif>{{$country->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- BUTTONS SHOW & RESET --}}
            <div class="col-1">
                <div class="head-buttons d-flex">
                    <button type="submit" class="btn btn-outline-success" style="margin-right: 5px; margin-top: 30px">Show</button>
                    <a href="{{route('hotels-index')}}" class="btn btn-outline-success" style="margin-top: 30px">Reset</a>
                </div>
            </div>


        </div>
    </div>
</form>


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
                                    <div class="m-2">{{$hotel->start}}</div>
                                    <div class="m-2">{{$hotel->end}}</div>
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
                                            <button hotel="submit" class="btn btn-delete btn-outline-danger">Delete</button>
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

        {{-- PER PAGE PAGINATOR LINKS --}}
        @if($perPageShow != 'all')
        <div class="m-2">{{ $hotels->links()}}
        </div>
        @endif

    </div>
</div>
@endsection
