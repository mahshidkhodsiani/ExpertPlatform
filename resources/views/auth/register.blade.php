@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">{{ __('Login or Register') }}</h3>
                        <p class="mb-0">{{ __('Via Email, Google, LinkedIn, or Apple') }}</p>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        {{-- Traditional Email/Password Login Form --}}
                        <h4 class="text-center mb-4 text-primary">{{ __('Login to Your Account') }}</h4>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>

                        {{-- Social Login/Registration Options --}}
                        <div class="text-center mb-4">
                            <p class="text-muted position-relative or-divider">
                                <span class="bg-white px-2">{{ __('Or via') }}</span>
                            </p>
                        </div>

                        <div class="d-grid gap-3 mb-5">
                            <a href="{{ route('auth.google') }}"
                                class="btn btn-outline-dark btn-lg d-flex align-items-center justify-content-center">
                                <i class="fab fa-google me-3"></i> {{ __('Login/Register with Google') }}
                            </a>
                            <a href="{{ route('auth.linkedin') }}"
                                class="btn btn-outline-primary btn-lg d-flex align-items-center justify-content-center">
                                <i class="fab fa-linkedin me-3"></i> {{ __('Login/Register with LinkedIn') }}
                            </a>
                            <a href="{{ route('auth.apple') }}"
                                class="btn btn-outline-danger btn-lg d-flex align-items-center justify-content-center">
                                <i class="fab fa-apple me-3"></i> {{ __('Login/Register with Apple') }}
                            </a>
                        </div>

                        {{-- Call to action for new users to register traditionally --}}
                        <div class="text-center">
                            <p class="mt-3 text-muted">
                                {{ __('Don\'t have an account?') }}
                                <a href="{{ route('register') }}" class="fw-bold text-decoration-none">
                                    {{ __('Register Now') }}
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Optional: Add custom CSS for the "or" divider if not already in your app.css --}}
    <style>
        .or-divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #ccc;
            margin: 20px 0;
            line-height: 0;
            /* Important to align the text in the middle of the line */
        }

        .or-divider::before,
        .or-divider::after {
            content: '';
            flex-grow: 1;
            height: 1px;
            background-color: #eee;
            position: relative;
            top: 0;
            /* Adjust as needed */
        }

        .or-divider::before {
            margin-right: 15px;
        }

        .or-divider::after {
            margin-left: 15px;
        }

        .or-divider span {
            background-color: white;
            /* Ensure background matches your card-body if it's not white */
            padding: 0 10px;
            /* Space around the text */
        }
    </style>
@endsection
