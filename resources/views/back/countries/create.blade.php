@extends('layouts.app')

@section('content')
@section('title', 'New country')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card m-6">
                <div class="card-header">
                    <h2 style="justify-content: center; display: flex">New country</h2>

                </div>
                <div class="card-body">
                    <form action="{{route('countries-store')}}" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Country name</label>
                            <input type="text" name="country_title" class="form-control" value="{{old('country_title')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Season start</label>
                            <input type="text" name="season_start" class="form-control" value="{{old('season_start')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Season end</label>
                            <input type="text" name="season_end" class="form-control" value="{{old('season_end')}}">
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
