@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    @if(empty($data['file']) || !Auth::user()->hasRole('logs'))
                        <div class="card-header">
                            No logs found.
                        </div>
                    @else
                        <div class="card-header">
                            {{ __('Logs') }}
                            ({{ round($data['size'] / 1024) }} KB)
                        </div>
                        <div class="card-body">
                            {!! nl2br(e($data['file'])) !!}
                        </div>
                    @endif
                </div>
            </div>
            @include('parts.sidebar')
        </div>
    </div>
@endsection
