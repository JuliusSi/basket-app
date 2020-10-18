@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Phone Number') }}</div>

                    <div class="card-body">

                        {{ __('Before proceeding, please check your phone for a verification code.') }}
                        <form method="POST" action="{{ route('phone-verify') }}">
                            @csrf
                            <div class="form-group row mt-4">
                                <label for="verification-code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Verification code') }}</label>

                                <div class="col-md-6">
                                    <input id="verification-code" type="text"
                                           class="form-control @error('verification-code') is-invalid @enderror"
                                           name="verification-code" value="{{ old('verification-code') }}" required
                                           autocomplete="verification-code">

                                    @error('verification-code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="form-group row mt-4">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Verify') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
