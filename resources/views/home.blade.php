@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <router-view :user={{ Auth::user() }}></router-view>
            </div>
            @include('parts.sidebar')
        </div>
    </div>
@endsection
