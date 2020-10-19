@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('verification.phone.verify_phone') }}</div>

                    <div class="card-body">

                        {{ __('verification.phone.code_verification_notice') }}
                        <form method="POST" action="{{ route('phone-verify') }}">
                            @csrf
                            <div class="form-group row mt-4">
                                <label for="verification-code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('verification.verification_code') }}</label>

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
                                                {{ __('verification.verify') }}
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
