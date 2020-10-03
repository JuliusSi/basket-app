@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('weather.check_weather_for_basketball') }}
                    </div>
                    <div class="card-body">
                        <weather-check></weather-check>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    @if(empty($data['file']))
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
        </div>
    </div>
@endsection
