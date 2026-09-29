@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-5 text-center">

                    <div class="mb-4">

                        <h2 class="fw-bold">
                            Verify Your Email
                        </h2>

                        <p class="text-muted">
                            We have sent a verification link to:
                        </p>

                        <strong>
                            {{ auth()->user()->email }}
                        </strong>

                    </div>

                    <p class="text-muted">
                        Please check your inbox and click the
                        verification link to activate your account.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('verification.send') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Resend Verification Email
                        </button>

                    </form>

                    <div class="mt-3">

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-link text-danger"
                            >
                                Logout
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection