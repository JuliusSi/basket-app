@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <radiation-check></radiation-check>
            </div>
            @include('parts.sidebar')
        </div>
    </div>
@endsection
