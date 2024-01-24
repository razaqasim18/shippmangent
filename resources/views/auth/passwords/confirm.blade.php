@extends('layouts.auth')

@section('content')
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">
                {{ __('Please confirm your password before continuing.') }}
            </h5>
            <p class="text-center small"></p>
        </div>
        <form class="row g-3 needs-validation" method="POST" action="{{ route('password.confirm') }}">
            @csrf


            <div class="col-12">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">
                    {{ __('Confirm Password') }}
                </button>
                @if (Route::has('password.request'))
                    <p class="small mb-0">
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </p>
                @endif
            </div>

        </form>
    </div>
@endsection
