@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 col-10 col-sm-8">
            <form method="POST" action="{{ route('login') }}">
            <div class="mt-5">
                <!-- <div class="card-header">{{ __('Login') }}</div> -->

                <div class="card-body">
                        @csrf
                        <div class="form-floating mb-3">
                                <input id="username" type="username" placeholder="john.doe" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
                                <label for="username">{{ __('Usuario') }}</label>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-floating mb-3">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <label for="password">{{ __('Password') }}</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <!-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        
                    </div>
                
                <div class="">
                    <div class="">
                        <div class="forgot-block text-light">
                            <button type="submit" class="btn btn-success w-100">
                                {{ __('LOGIN') }}
                            </button>
                        </div>
                        <div class="forgot-block text-light mt-5 text-center">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link text-light" href="{{ route('password.request') }}">
                                    <small>{{ __('Reestablecer clave?') }}</small>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
