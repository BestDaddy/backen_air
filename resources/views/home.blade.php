@extends('layouts.admin')

@section('content')
    <h1>Welcome to Air Almaty project!</h1>
    <h2>{{Auth::user()->first_name .' '. Auth::user()->last_name}}</h2>
    <hr>
    <div class="row">
    @for($i = 0; $i < count($arduinos); $i++)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $arduinos[$i]->name }}</h5>
                        <p class="card-text">{{ $arduinos[$i]->last_seen_at }}</p>
                        <p class="card-subtitle">PPM: {{ $arduinos[$i]->baseLog->ppm }}</p>
                    </div>
                </div>
            </div>

        @if($i % 3 == 0 && $i != 0)
            </div><div class="row">
        @endif
    @endfor
    </div>
    <hr>
@endsection
