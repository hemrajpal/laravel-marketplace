@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">

                        <h2 class="fw-bold">
                            Login
                        </h2>

                        <p class="text-muted mb-0">
                            Login to your MarketPlace account
                        </p>

                    </div>

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0 ps-3">

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form
                        method="POST"
                        action="{{ route('login.submit') }}"
                    >

                        @csrf

                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                required
                                autofocus
                            >

                            @error('email')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        <div class="mb-3">

                            <label
                                for="password"
                                class="form-label"
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password"
                                required
                            >

                            @error('password')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                            <div class="text-end mt-2">

                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-decoration-none"
                                >
                                    Forgot Password?
                                </a>

                            </div>

                        </div>

                        <div class="mb-4 form-check">

                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                class="form-check-input"
                                value="1"
                            >

                            <label
                                for="remember"
                                class="form-check-label"
                            >
                                Remember me
                            </label>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <span class="text-muted">
                            Don't have an account?
                        </span>

                        <a
                            href="{{ route('register') }}"
                            class="text-decoration-none"
                        >
                            Register
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection