@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">

        <ol class="breadcrumb">

            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">
                    Home
                </a>
            </li>


            @if ($product->category)

                @if ($product->category->parent)

                    <li class="breadcrumb-item">

                        <a
                            href="{{ route('products.category', [
                                'category' => $product->category->parent->slug,
                                'categoryId' => $product->category->parent->id,
                            ]) }}"
                        >
                            {{ $product->category->parent->name }}
                        </a>

                    </li>

                @endif


                <li class="breadcrumb-item">

                    <a
                        href="{{ route('products.category', [
                            'category' => $product->category->slug,
                            'categoryId' => $product->category->id,
                        ]) }}"
                    >
                        {{ $product->category->name }}
                    </a>

                </li>

            @endif


            <li class="breadcrumb-item active">
                {{ $product->name }}
            </li>

        </ol>

    </nav>



    <div class="row g-4">


        {{-- ==========================================================
            Images
        =========================================================== --}}
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                @if ($product->images->count())

                    <div
                        id="productCarousel"
                        class="carousel slide"
                        data-bs-ride="carousel"
                    >

                        <div class="carousel-inner">

                            @foreach ($product->images as $index => $image)

                                <div
                                    class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                                >

                                    <img
                                        src="{{ asset('storage/' . $image->image) }}"
                                        class="d-block w-100"
                                        style="height: 450px; object-fit: contain;"
                                        alt="{{ $product->name }}"
                                    >

                                </div>

                            @endforeach

                        </div>


                        @if ($product->images->count() > 1)

                            <button
                                class="carousel-control-prev"
                                type="button"
                                data-bs-target="#productCarousel"
                                data-bs-slide="prev"
                            >

                                <span class="carousel-control-prev-icon"></span>

                                <span class="visually-hidden">
                                    Previous
                                </span>

                            </button>


                            <button
                                class="carousel-control-next"
                                type="button"
                                data-bs-target="#productCarousel"
                                data-bs-slide="next"
                            >

                                <span class="carousel-control-next-icon"></span>

                                <span class="visually-hidden">
                                    Next
                                </span>

                            </button>

                        @endif

                    </div>

                @else

                    <div
                        class="d-flex align-items-center justify-content-center bg-light"
                        style="height: 450px;"
                    >

                        <span class="text-muted">
                            No image available
                        </span>

                    </div>

                @endif

            </div>

        </div>



        {{-- ==========================================================
            Product Information
        =========================================================== --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">


                    {{-- Type --}}
                    <span
                        class="badge
                        {{ $product->type === 'service'
                            ? 'bg-success'
                            : 'bg-primary' }}"
                    >
                        {{ ucfirst($product->type) }}
                    </span>



                    {{-- Name --}}
                    <h1 class="h3 mt-3 mb-2">
                        {{ $product->name }}
                    </h1>



                    {{-- Price --}}
                    <h2 class="h4 text-primary mb-4">

                        ₹{{ number_format($product->price, 2) }}

                    </h2>



                    {{-- ==================================================
                        Category
                    =================================================== --}}
                    @if ($product->category)

                        @if ($product->category->parent)

                            {{-- Main Category --}}
                            <div class="mb-3">

                                <small class="text-muted d-block">
                                    Category
                                </small>

                                <a
                                    href="{{ route('products.category', [
                                        'category' => $product->category->parent->slug,
                                        'categoryId' => $product->category->parent->id,
                                    ]) }}"
                                    class="text-decoration-none"
                                >
                                    <strong>
                                        {{ $product->category->parent->name }}
                                    </strong>
                                </a>

                            </div>


                            {{-- Subcategory --}}
                            <div class="mb-3">

                                <small class="text-muted d-block">
                                    Subcategory
                                </small>

                                <a
                                    href="{{ route('products.category', [
                                        'category' => $product->category->slug,
                                        'categoryId' => $product->category->id,
                                    ]) }}"
                                    class="text-decoration-none"
                                >
                                    <strong>
                                        {{ $product->category->name }}
                                    </strong>
                                </a>

                            </div>

                        @else

                            {{-- Fallback if category has no parent --}}
                            <div class="mb-3">

                                <small class="text-muted d-block">
                                    Category
                                </small>

                                <a
                                    href="{{ route('products.category', [
                                        'category' => $product->category->slug,
                                        'categoryId' => $product->category->id,
                                    ]) }}"
                                    class="text-decoration-none"
                                >
                                    <strong>
                                        {{ $product->category->name }}
                                    </strong>
                                </a>

                            </div>

                        @endif

                    @endif



                    {{-- ==================================================
                        Location
                    =================================================== --}}
                    <div class="mb-3">

                        <small class="text-muted d-block">
                            Location
                        </small>

                        <strong>

                            {{ $product->area }}

                            @if ($product->city)
                                , {{ $product->city->name }}
                            @endif

                            @if ($product->state)
                                , {{ $product->state->name }}
                            @endif

                        </strong>

                    </div>



                    {{-- ==================================================
                        Country
                    =================================================== --}}
                    <div class="mb-3">

                        <small class="text-muted d-block">
                            Country
                        </small>

                        <strong>
                            {{ $product->country }}
                        </strong>

                    </div>



                    {{-- ==================================================
                        Seller
                    =================================================== --}}
                    <div class="mb-4">

                        <small class="text-muted d-block">
                            Posted By
                        </small>

                        <strong>
                            {{ $product->user->name }}
                        </strong>

                    </div>



                    <hr>



                    {{-- ==================================================
                        Contact
                    =================================================== --}}
                    @auth

                        @if ($product->user_id === auth()->id())

                            <a
                                href="{{ route('products.edit', $product->id) }}"
                                class="btn btn-outline-primary w-100"
                            >
                                Your Product
                            </a>

                        @else

                            <button
                                type="button"
                                class="btn btn-primary w-100"
                            >
                                Contact Seller
                            </button>

                        @endif

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="btn btn-primary w-100"
                        >
                            Login to Contact Seller
                        </a>

                    @endauth

                </div>

            </div>

        </div>

    </div>



    {{-- ==============================================================
        Description
    =============================================================== --}}
    <div class="row mt-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h2 class="h5 mb-3">
                        Description
                    </h2>


                    <div style="white-space: pre-line;">
                        {{ $product->detail }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection