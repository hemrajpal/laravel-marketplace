@extends('layouts.app')

@section('title', 'Change Password')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7 col-lg-5">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <div class="mb-4">

                        <h3 class="fw-bold mb-1">
                            Change Password
                        </h3>

                        <p class="text-muted mb-0">
                            Update your account password.
                        </p>

                    </div>


                    @if(session('success'))

                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>

                    @endif


                    <form
                        action="{{ route('profile.password.update') }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


                        {{-- Current Password --}}
                        <div class="mb-3">

                            <label
                                for="current_password"
                                class="form-label"
                            >
                                Current Password
                            </label>

                            <input
                                type="password"
                                name="current_password"
                                id="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                autocomplete="current-password"
                                required
                            >

                            @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- New Password --}}
                        <div class="mb-3">

                            <label
                                for="password"
                                class="form-label"
                            >
                                New Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="new-password"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Confirm Password --}}
                        <div class="mb-4">

                            <label
                                for="password_confirmation"
                                class="form-label"
                            >
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                autocomplete="new-password"
                                required
                            >

                        </div>


                        {{-- Buttons --}}
                        <div class="d-flex gap-2">

                            <a
                                href="{{ route('profile') }}"
                                class="btn btn-outline-secondary"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Change Password
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection