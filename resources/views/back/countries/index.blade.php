@extends('layouts.app')

@section('content')
@section('title', 'All countries')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="justify-content: center; display: flex">All countries</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($countries as $country)
                        <li class="list-group-item">
                            <div class="list-table">
                                <div class="d-flex">
                                    <h5 class="m-2">{{$country->title}}</h5>
                                    <div class="m-2">{{$country->season_start}}</div>
                                    <div class="m-2">{{$country->season_end}}</div>
                                    <div class="count">[{{$country->countryHotels()->count()}}]</div>
                                </div>
                                <div>
                                    <div class="d-flex">

                                        {{-- delete ir edit rodomas tik admin --}}
                                        @if(Auth::user()?->role == 'admin')
                                        <a href="{{route('countries-edit', $country)}}" class="btn btn-outline-success">Edit</a>
                                        <form action="{{route('countries-delete', $country)}}" method="post">
                                            <button country="submit" class="btn btn-outline-danger">Delete</button>
                                    </div>
                                    @csrf
                                    @method('delete')
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">No countries yet</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
