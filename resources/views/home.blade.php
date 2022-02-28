@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if($user->isAdministrator())
            <admin-sidebar :user={{ $user }}></admin-sidebar>
            @endif
            <div class="col-md-8">
                <router-view :user={{ $user }}></router-view>
            </div>
            @include('parts.sidebar')
        </div>
    </div>
@endsection
