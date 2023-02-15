{{-- <div class="container"> --}}
@if($errors)
<div class="container-alerts">
    @foreach ($errors->all() as $message)
    <div class="hide">
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @endforeach
        @endif
    </div>

    @if(Session::has('ok'))
    <div class="container-alerts">
        <div class="hide">
            <div class="alert alert-success" role="alert">
                {{ Session::get('ok') }}
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('no'))
    <div class="container-alerts">
        <div class="hide">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('no') }}
            </div>
        </div>
    </div>
    @endif

</div>
</div>
