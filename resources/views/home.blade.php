@extends('layouts.app')

@section('title', 'MarketPlace - Buy & Sell')

@section('content')

<div class="container py-4">

    {{-- ============================================================
        SEARCH / CITY
    ============================================================= --}}

    <section class="bg-primary text-white rounded-3 p-4 p-md-5 mb-5">

        <div class="text-center mb-4">

            <h1 class="display-5 fw-bold mb-2">
                Find Products & Services Near You
            </h1>

            <p class="lead mb-0">
                Buy, sell and discover products and services in your city.
            </p>

        </div>


        <form
            action="{{ url()->current() }}"
            method="GET"
            id="filter_form"
        >

            <div class="row g-2 bg-white p-2 rounded shadow">

                {{-- City --}}

                <div class="col-12 col-md-4 position-relative">

                    <input
                        type="text"
                        id="city"
                        name="city"
                        class="form-control form-control-lg"
                        placeholder="Search city"
                        value="{{ isset($cityModel) ? $cityModel->name : request('city') }}"
                        autocomplete="off"
                    >

                    <div
                        id="citySuggestions"
                        class="list-group position-absolute w-100 shadow-sm"
                        style="z-index: 1050; display: none;"
                    ></div>

                </div>


                {{-- Search --}}

                <div class="col-12 col-md-5">

                    <input
                        type="text"
                        name="search"
                        class="form-control form-control-lg"
                        placeholder="What are you looking for?"
                        value="{{ request('search') }}"
                    >

                </div>


                {{-- Search Button --}}

                <div class="col-12 col-md-3">

                    <button
                        type="submit"
                        class="btn btn-dark btn-lg w-100"
                    >
                        Search
                    </button>

                </div>

            </div>

        </form>

    </section>



    {{-- ============================================================
        CATEGORIES
    ============================================================= --}}

    <section class="marketplace-categories mb-5">

        {{-- Top horizontal category bar --}}

        <div class="category-navbar">

            <div class="category-scroll">

                {{-- All Categories --}}

                <button
                    type="button"
                    class="category-pill all-categories"
                    data-bs-toggle="collapse"
                    data-bs-target="#categoriesPanel"
                    aria-expanded="false"
                    aria-controls="categoriesPanel"
                >

                    <span class="menu-icon">
                        ☰
                    </span>

                    <span>
                        All Categories
                    </span>

                </button>


                {{-- Main category pills --}}

                @foreach($categories as $category)

                    @php
                        $categoryActive = isset($categoryModel)
                            && $categoryModel->id == $category->id;

                        $categoryUrl = isset($cityModel)
                            ? route('products.city.category', [
                                'city' => $cityModel->slug,
                                'cityId' => $cityModel->id,
                                'category' => $category->slug,
                                'categoryId' => $category->id,
                            ])
                            : route('products.category', [
                                'category' => $category->slug,
                                'categoryId' => $category->id,
                            ]);
                    @endphp

                    <a
                        href="{{ $categoryUrl }}"
                        class="category-pill {{ $categoryActive ? 'active' : '' }}"
                    >
                        {{ $category->name }}
                    </a>

                @endforeach

            </div>

        </div>


        {{-- ========================================================
            ALL CATEGORIES PANEL
        ========================================================= --}}

        <div
            class="collapse categories-panel"
            id="categoriesPanel"
        >

            <div class="row g-0">

                @foreach($categories as $category)

                    @php
                        $categoryActive = isset($categoryModel)
                            && $categoryModel->id == $category->id;

                        $categoryUrl = isset($cityModel)
                            ? route('products.city.category', [
                                'city' => $cityModel->slug,
                                'cityId' => $cityModel->id,
                                'category' => $category->slug,
                                'categoryId' => $category->id,
                            ])
                            : route('products.category', [
                                'category' => $category->slug,
                                'categoryId' => $category->id,
                            ]);
                    @endphp

                    <div class="col-12 col-md-6 col-lg-3">

                        <div class="category-column">

                            {{-- Main Category --}}

                            <a
                                href="{{ $categoryUrl }}"
                                class="main-category-link {{ $categoryActive ? 'active' : '' }}"
                            >

                                <span class="main-category-name">
                                    {{ $category->name }}
                                </span>

                                <span class="category-arrow">
                                    →
                                </span>

                            </a>


                            {{-- Child Categories --}}

                            @if($category->children->count())

                                <div class="subcategory-list">

                                    @foreach($category->children as $child)

                                        @php
                                            $childActive = isset($categoryModel)
                                                && $categoryModel->id == $child->id;

                                            $childUrl = isset($cityModel)
                                                ? route('products.city.category', [
                                                    'city' => $cityModel->slug,
                                                    'cityId' => $cityModel->id,
                                                    'category' => $child->slug,
                                                    'categoryId' => $child->id,
                                                ])
                                                : route('products.category', [
                                                    'category' => $child->slug,
                                                    'categoryId' => $child->id,
                                                ]);
                                        @endphp

                                        <a
                                            href="{{ $childUrl }}"
                                            class="subcategory-link {{ $childActive ? 'active' : '' }}"
                                        >
                                            {{ $child->name }}
                                        </a>

                                    @endforeach

                                </div>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>



    {{-- ============================================================
        ACTIVE FILTERS
    ============================================================= --}}

    @if(
        request()->filled('search') ||
        isset($cityModel) ||
        isset($categoryModel)
    )

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <div class="d-flex flex-wrap align-items-center gap-2">

                    <span class="text-muted">
                        Filters:
                    </span>


                    {{-- City --}}

                    @if(isset($cityModel))

                        <span class="badge text-bg-secondary">

                            City:
                            {{ $cityModel->name }}

                        </span>

                    @elseif(request()->filled('city'))

                        <span class="badge text-bg-secondary">

                            City:
                            {{ request('city') }}

                        </span>

                    @endif


                    {{-- Search --}}

                    @if(request()->filled('search'))

                        <span class="badge text-bg-primary">

                            Search:
                            {{ request('search') }}

                        </span>

                    @endif


                    {{-- Category --}}

                    @if(isset($categoryModel))

                        <span class="badge text-bg-success">

                            Category:
                            {{ $categoryModel->name }}

                        </span>

                    @endif


                    <a
                        href="{{ route('home') }}"
                        class="btn btn-sm btn-outline-secondary ms-auto"
                    >
                        Clear Filters
                    </a>

                </div>

            </div>

        </div>

    @endif



    {{-- ============================================================
        PRODUCTS
    ============================================================= --}}

    <section>

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">

                    @if(isset($cityModel) && isset($categoryModel))

                        {{ $categoryModel->name }}
                        Products in
                        {{ $cityModel->name }}

                    @elseif(isset($cityModel))

                        Products in {{ $cityModel->name }}

                    @elseif(isset($categoryModel))

                        {{ $categoryModel->name }} Products

                    @else

                        Latest Products

                    @endif

                </h2>


                <p class="text-muted mb-0">

                    {{ $products->total() }}

                    {{ $products->total() == 1 ? 'product' : 'products' }}

                    found

                </p>

            </div>

        </div>



        @if($products->count())

            <div class="row g-4">

                @foreach($products as $product)

                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                        <div class="card h-100 border-0 shadow-sm overflow-hidden">


                            {{-- Product Image --}}

                            <a
                                href="{{ route('products.show', $product->slug) }}"
                                class="text-decoration-none"
                            >

                                <div
                                    class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 220px;"
                                >

                                    @if($product->images->count())

                                        <img
                                            src="{{ asset('storage/' . $product->images->first()->image) }}"
                                            alt="{{ $product->name }}"
                                            class="img-fluid"
                                            style="
                                                width: 100%;
                                                height: 220px;
                                                object-fit: cover;
                                            "
                                        >

                                    @else

                                        <div class="text-center text-muted">

                                            <div
                                                class="bg-secondary bg-opacity-10 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                                                style="width: 60px; height: 60px;"
                                            >

                                                <span class="fs-4">
                                                    📷
                                                </span>

                                            </div>

                                            <small>
                                                No Image
                                            </small>

                                        </div>

                                    @endif

                                </div>

                            </a>



                            {{-- Product Body --}}

                            <div class="card-body d-flex flex-column">


                                {{-- Type --}}

                                <div class="mb-2">

                                    @if($product->type === 'product')

                                        <span class="badge bg-primary">
                                            Product
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            Service
                                        </span>

                                    @endif

                                </div>



                                {{-- Product Name --}}

                                <h2 class="h6 fw-semibold mb-2">

                                    <a
                                        href="{{ route('products.show', $product->slug) }}"
                                        class="text-dark text-decoration-none"
                                    >
                                        {{ $product->name }}
                                    </a>

                                </h2>



                                {{-- Price --}}

                                <div class="fw-bold fs-5 text-dark mb-2">

                                    ₹{{ number_format((float) $product->price, 2) }}

                                </div>



                                {{-- Category --}}

                                @if($product->category)

                                    @php
                                        $productCategory = $product->category;

                                        $productCategoryUrl = isset($cityModel)
                                            ? route('products.city.category', [
                                                'city' => $cityModel->slug,
                                                'cityId' => $cityModel->id,
                                                'category' => $productCategory->slug,
                                                'categoryId' => $productCategory->id,
                                            ])
                                            : route('products.category', [
                                                'category' => $productCategory->slug,
                                                'categoryId' => $productCategory->id,
                                            ]);
                                    @endphp

                                    <div class="small text-muted mb-2">

                                        <a
                                            href="{{ $productCategoryUrl }}"
                                            class="text-decoration-none text-muted"
                                        >
                                            {{ $productCategory->name }}
                                        </a>

                                    </div>

                                @endif



                                {{-- Location --}}

                                <div class="small text-muted mb-2">

                                    📍

                                    @if($product->city)

                                        {{ $product->city->name }}

                                    @endif

                                    @if($product->area)

                                        <span class="mx-1">
                                            •
                                        </span>

                                        {{ $product->area }}

                                    @endif

                                </div>



                                {{-- State --}}

                                @if($product->state)

                                    <div class="small text-muted mb-2">

                                        {{ $product->state->name }}

                                    </div>

                                @endif



                                {{-- Detail --}}

                                <p class="text-muted small mb-3">

                                    {{ \Illuminate\Support\Str::limit(
                                        $product->detail,
                                        90
                                    ) }}

                                </p>



                                {{-- View Product --}}

                                <div class="mt-auto">

                                    <a
                                        href="{{ route('products.show', $product->slug) }}"
                                        class="btn btn-outline-primary btn-sm w-100"
                                    >
                                        View Product
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- ====================================================
                PAGINATION
            ==================================================== --}}

            @if($products->hasPages())

                <div class="d-flex justify-content-center mt-5">

                    <nav aria-label="Products pagination">

                        <ul class="pagination pagination-sm mb-0 shadow-sm">

                            {{-- Previous --}}

                            @if($products->onFirstPage())

                                <li class="page-item disabled">

                                    <span class="page-link">
                                        &laquo;
                                    </span>

                                </li>

                            @else

                                <li class="page-item">

                                    <a
                                        class="page-link"
                                        href="{{ $products->previousPageUrl() }}"
                                        rel="prev"
                                        aria-label="Previous"
                                    >
                                        &laquo;
                                    </a>

                                </li>

                            @endif


                            {{-- Page Numbers --}}

                            @foreach($products->getUrlRange(
                                max(1, $products->currentPage() - 1),
                                min($products->lastPage(), $products->currentPage() + 1)
                            ) as $page => $url)

                                @if($page == $products->currentPage())

                                    <li
                                        class="page-item active"
                                        aria-current="page"
                                    >

                                        <span class="page-link">
                                            {{ $page }}
                                        </span>

                                    </li>

                                @else

                                    <li class="page-item">

                                        <a
                                            class="page-link"
                                            href="{{ $url }}"
                                        >
                                            {{ $page }}
                                        </a>

                                    </li>

                                @endif

                            @endforeach


                            {{-- Next --}}

                            @if($products->hasMorePages())

                                <li class="page-item">

                                    <a
                                        class="page-link"
                                        href="{{ $products->nextPageUrl() }}"
                                        rel="next"
                                        aria-label="Next"
                                    >
                                        &raquo;
                                    </a>

                                </li>

                            @else

                                <li class="page-item disabled">

                                    <span class="page-link">
                                        &raquo;
                                    </span>

                                </li>

                            @endif

                        </ul>

                    </nav>

                </div>

            @endif


        @else


            {{-- ====================================================
                EMPTY STATE
            ===================================================== --}}

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center py-5">

                    <div class="fs-1 mb-3">
                        📦
                    </div>

                    <h3 class="h5">
                        No products found
                    </h3>

                    <p class="text-muted mb-4">
                        Try changing your search, city or category.
                    </p>


                    <a
                        href="{{ route('home') }}"
                        class="btn btn-primary"
                    >
                        View All Products
                    </a>

                </div>

            </div>

        @endif

    </section>



    {{-- ============================================================
        CALL TO ACTION
    ============================================================= --}}

    @auth

        @if(auth()->user()->hasVerifiedEmail())

            <section class="py-5 mt-5 bg-primary text-white rounded-3">

                <div class="text-center">

                    <h2 class="fw-bold mb-3">
                        Have something to sell?
                    </h2>

                    <p class="mb-4">
                        Post your product or service and reach buyers near you.
                    </p>

                    <a
                        href="{{ route('products.create') }}"
                        class="btn btn-light btn-lg"
                    >
                        Post Your Product
                    </a>

                </div>

            </section>

        @endif

    @endauth

</div>


@push('styles')

<style>

    .marketplace-categories {
        background: #fff;
    }

    .category-navbar {
        border-bottom: 1px solid #ddd;
        border-top: 1px solid #ddd;
        background: #fff;
    }

    .category-scroll {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        padding: 10px 0;
        scrollbar-width: none;
    }

    .category-scroll::-webkit-scrollbar {
        display: none;
    }

    .category-pill {
        flex: 0 0 auto;

        display: inline-flex;
        align-items: center;

        padding: 9px 18px;

        border: 1px solid #ddd;
        border-radius: 22px;

        background: #fff;

        color: #222;
        text-decoration: none;

        font-size: 14px;
        font-weight: 500;

        white-space: nowrap;

        transition: all .2s ease;
    }

    .category-pill:hover {
        border-color: #0d6efd;
        color: #0d6efd;
    }

    .category-pill.active {
        background: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }

    .all-categories {
        font-weight: 600;
    }

    .menu-icon {
        margin-right: 8px;
        font-size: 17px;
        line-height: 1;
    }

    .categories-panel {
        background: #fff;

        border: 1px solid #ddd;
        border-top: 0;

        box-shadow: 0 5px 15px rgba(0, 0, 0, .08);

        padding: 25px 0;
    }

    .category-column {
        padding: 5px 28px 20px;

        min-height: 150px;

        border-right: 1px solid #eee;
    }

    .category-column:nth-child(4n) {
        border-right: 0;
    }

    /* ============================================================
       MAIN CATEGORY
    ============================================================ */

    .main-category-link {
        display: flex;

        align-items: center;
        justify-content: space-between;

        width: 100%;

        margin-bottom: 12px;

        padding: 10px 12px;

        border-radius: 6px;

        color: #111;
        background: #fff;

        text-decoration: none;

        font-weight: 600;

        font-size: 15px;

        transition: all .2s ease;
    }

    .main-category-link:hover {
        color: #0d6efd;
        background: #f5f8ff;
    }

    .main-category-link.active {
        color: #0d6efd;
        background: #eaf2ff;
    }

    .main-category-name {
        font-size: 15px;

        overflow: hidden;
        text-overflow: ellipsis;
    }

    .category-arrow {
        color: #777;

        font-size: 18px;
        font-weight: 600;

        margin-left: 10px;

        transition: transform .2s ease;
    }

    .main-category-link:hover .category-arrow {
        transform: translateX(3px);
    }

    /* ============================================================
       CHILD CATEGORIES
    ============================================================ */

    .subcategory-list {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .subcategory-link {
        display: block;

        padding: 4px 0;

        color: #222;

        text-decoration: none;

        font-size: 14px;

        line-height: 1.5;
    }

    .subcategory-link:hover {
        color: #0d6efd;
        text-decoration: underline;
    }

    .subcategory-link.active {
        font-weight: 600;

        color: #0d6efd;
        background: #f0f6ff;

        border-radius: 4px;

        padding: 4px 8px;
    }

    /* ====================================================
       PRODUCT PAGINATION
    ==================================================== */

    .pagination {
        gap: 5px;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        border: 1px solid #dee2e6;
        border-radius: 6px !important;

        min-width: 38px;
        height: 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #495057;
        background: #fff;

        font-size: 14px;
        font-weight: 500;

        transition: all .2s ease;
    }

    .pagination .page-link:hover {
        background: #f8f9fa;

        color: #0d6efd;

        border-color: #b6d4fe;
    }

    .pagination .page-item.active .page-link {
        background: #0d6efd;

        border-color: #0d6efd;

        color: #fff;
    }

    .pagination .page-item.disabled .page-link {
        background: #f8f9fa;

        color: #adb5bd;

        border-color: #e9ecef;
    }

    /* ============================================================
       MOBILE
    ============================================================ */

    @media (max-width: 767.98px) {

        .category-scroll {
            padding-left: 10px;
            padding-right: 10px;
        }

        .category-pill {
            padding: 8px 14px;

            font-size: 13px;
        }

        .categories-panel {
            padding: 15px 0;
        }

        .category-column {
            padding: 15px 20px;

            border-right: 0;

            border-bottom: 1px solid #eee;
        }

        .category-column:last-child {
            border-bottom: 0;
        }

    }

</style>

@endpush


@push('scripts')

<script>

$(document).ready(function () {

    let searchTimer;

    /*
    |--------------------------------------------------------------------------
    | City Autocomplete
    |--------------------------------------------------------------------------
    */

    $('#city').on('input', function () {

        let input = $(this);

        let query = $.trim(input.val());

        clearTimeout(searchTimer);

        if (query.length < 2) {

            $('#citySuggestions')
                .empty()
                .hide();

            return;
        }

        searchTimer = setTimeout(function () {

            $.ajax({

                url: "{{ route('cities') }}",

                type: "GET",

                data: {
                    q: query
                },

                success: function (cities) {

                    let suggestions = $('#citySuggestions');

                    suggestions.empty();

                    if (!cities.length) {

                        suggestions.hide();

                        return;
                    }

                    $.each(cities, function (index, city) {

                        $('<button>', {

                            type: 'button',

                            class: 'list-group-item list-group-item-action',

                            text: city.name

                        })
                        .appendTo(suggestions)
                        .on('click', function () {

                            /*
                            |--------------------------------------------------------------------------
                            | Redirect to clean city URL
                            |--------------------------------------------------------------------------
                            |
                            | Example:
                            | /kolkata_ct_1
                            |
                            */

                            window.location.href =
                                "{{ url('/') }}/" +
                                city.slug +
                                "_ct_" +
                                city.id;

                        });

                    });

                    suggestions.show();

                },

                error: function () {

                    $('#citySuggestions')
                        .empty()
                        .hide();

                }

            });

        }, 300);

    });


    /*
    |--------------------------------------------------------------------------
    | Hide Suggestions When Clicking Outside
    |--------------------------------------------------------------------------
    */

    $(document).on('click', function (e) {

        if (
            !$(e.target).closest('#city').length &&
            !$(e.target).closest('#citySuggestions').length
        ) {

            $('#citySuggestions')
                .empty()
                .hide();

        }

    });

});

</script>

@endpush

@endsection