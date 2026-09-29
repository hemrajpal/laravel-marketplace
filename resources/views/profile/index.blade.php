@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            My Profile
        </h1>

        <p class="text-muted mb-0">
            Manage your account information.
        </p>
    </div>


    <div class="row g-4">

        {{-- Profile Card --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    {{-- Profile Header --}}
                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="profile-avatar me-3"
                        >
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div>
                            <h4 class="fw-bold mb-1">
                                {{ $user->name }}
                            </h4>

                            <div class="text-muted">
                                Member since
                                {{ $user->created_at->format('M Y') }}
                            </div>
                        </div>

                    </div>


                    <hr>


                    {{-- Profile Information --}}
                    <h5 class="fw-semibold mb-4">
                        Personal Information
                    </h5>


                    <div class="row g-4">

                        {{-- Name --}}
                        <div class="col-md-6">

                            <label class="form-label text-muted small">
                                Name
                            </label>

                            <div class="fw-semibold">
                                {{ $user->name }}
                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">

                            <label class="form-label text-muted small">
                                Email
                            </label>

                            <div class="fw-semibold">
                                {{ $user->email }}
                            </div>

                        </div>
                  

                    </div>


                    <hr class="my-4">


                    {{-- Actions --}}
                    <div class="d-flex flex-wrap gap-2">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="btn btn-primary"
                        >
                            Edit Profile
                        </a>

                        <a
                            href="{{ route('profile.password.edit') }}"
                            class="btn btn-outline-secondary"
                        >
                            Change Password
                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- My Products --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-2">
                        My Products
                    </h5>

                    <p class="text-muted small mb-3">
                        Manage the products and services you have posted.
                    </p>

                    <a
                        href="{{ route('products.my') }}"
                        class="btn btn-outline-primary w-100"
                    >
                        Manage Products
                    </a>

                </div>

            </div>


            {{-- Account --}}
            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-3">
                        Account
                    </h5>

                    <div class="d-flex justify-content-between mb-2">

                        <span class="text-muted">
                            Member since
                        </span>

                        <span class="fw-semibold">
                            {{ $user->created_at->format('d M Y') }}
                        </span>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">
                            Products
                        </span>

                        <span class="fw-semibold">
                            {{ $user->products()->count() }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

.profile-avatar {
    width: 64px;
    height: 64px;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #e9f2ff;
    color: #0d6efd;

    font-size: 24px;
    font-weight: 700;
}

</style>

@endpush