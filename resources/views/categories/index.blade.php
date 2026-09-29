@extends('layouts.app')

@section('title', 'All Categories')

@section('content')

<div class="container py-5">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">All Categories</h1>
            <p class="text-muted mb-0">
                Browse all available categories
            </p>
        </div>

        <a href="{{ route('home') }}" class="btn btn-outline-dark">
            ← Back to Home
        </a>
    </div>

    {{-- Categories --}}
    <div class="row g-4">

        @forelse($categories as $category)

            <div class="col-12 col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <a href="{{ route('home', [ 'category' => $category->slug ]) }}">
                            <h4 class="fw-bold mb-2">
                                {{ $category->name }}
                            </h4>
                        </a>

                        @if($category->description)
                            <p class="text-muted mb-3">
                                {{ $category->description }}
                            </p>
                        @endif

                        {{-- Subcategories --}}
                        @if($category->subcategories->count())

                            <div class="mt-3">

                                <h6 class="fw-semibold mb-2">
                                    Subcategories
                                </h6>

                                <div class="d-flex flex-wrap gap-2">

                                    @foreach($category->subcategories as $subcategory)

                                        <a
                                            href="{{ route('home', [
                                                'category' => $category->slug,
                                                'subcategory' => $subcategory->slug
                                            ]) }}"
                                            class="badge bg-light text-dark border text-decoration-none p-2"
                                        >
                                            {{ $subcategory->name }}
                                        </a>

                                    @endforeach

                                </div>

                            </div>

                        @else

                            <p class="text-muted small mb-0">
                                No subcategories available.
                            </p>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info text-center">
                    No categories available.
                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection