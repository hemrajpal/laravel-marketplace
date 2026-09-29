@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">

                        <h2 class="fw-bold">
                            Forgot Password?
                        </h2>

                        <p class="text-muted">
                            Enter your email and we will send you
                            a password reset link.
                        </p>

                    </div>

                    @if (session('success'))

                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>

                    @endif

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0 ps-3">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form
                        method="POST"
                        action="{{ route('password.email') }}"
                    >

                        @csrf

                        <div class="mb-4">

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

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Send Reset Link
                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <a
                            href="{{ route('login') }}"
                            class="text-decoration-none"
                        >
                            ← Back to Login
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection