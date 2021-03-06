@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <weather-check :user = {{ Auth::user() }}></weather-check>
            </div>
            @include('parts.sidebar')
        </div>
    </div>
@endsection
