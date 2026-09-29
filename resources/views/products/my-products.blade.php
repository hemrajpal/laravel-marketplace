@extends('layouts.app')

@section('title', 'My Products')

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                My Products
            </h1>

            <p class="text-muted mb-0">
                Manage your products and services.
            </p>
        </div>

        <a
            href="{{ route('products.create') }}"
            class="btn btn-primary"
        >
            + Post Product
        </a>

    </div>


    @if ($products->count())

        <div class="row g-4">

            @foreach ($products as $product)

                <div class="col-md-6 col-lg-4">

                    <div class="card h-100 border-0 shadow-sm">

                        {{-- ====================================================
                            Image
                        ==================================================== --}}

                        @if ($product->images->first())

                            <img
                                src="{{ asset('storage/' . $product->images->first()->image) }}"
                                class="card-img-top"
                                alt="{{ $product->name }}"
                                style="
                                    height: 220px;
                                    object-fit: cover;
                                "
                            >

                        @else

                            <div
                                class="bg-light d-flex align-items-center justify-content-center"
                                style="height: 220px;"
                            >
                                <span class="text-muted">
                                    No Image
                                </span>
                            </div>

                        @endif


                        <div class="card-body">

                            {{-- ====================================================
                                Type
                            ==================================================== --}}

                            <span
                                class="badge
                                {{ $product->type === 'service'
                                    ? 'bg-success'
                                    : 'bg-primary' }}"
                            >
                                {{ ucfirst($product->type) }}
                            </span>


                            {{-- ====================================================
                                Name
                            ==================================================== --}}

                            <h5 class="card-title mt-2 mb-1">
                                {{ $product->name }}
                            </h5>


                            {{-- ====================================================
                                Price
                            ==================================================== --}}

                            <h6 class="text-primary mb-2">
                                ₹{{ number_format($product->price, 2) }}
                            </h6>


                            {{-- ====================================================
                                Category
                            ==================================================== --}}

                            @if ($product->category)

                                <div class="small text-muted mb-1">

                                    @if ($product->category->parent)

                                        <span>
                                            {{ $product->category->parent->name }}
                                        </span>

                                        <span class="mx-1">
                                            →
                                        </span>

                                    @endif

                                    <span class="fw-medium">
                                        {{ $product->category->name }}
                                    </span>

                                </div>

                            @endif


                            {{-- ====================================================
                                Location
                            ==================================================== --}}

                            <div class="small text-muted mb-2">

                                @if ($product->area)
                                    {{ $product->area }}
                                @endif

                                @if ($product->city)
                                    @if ($product->area)
                                        ,
                                    @endif

                                    {{ $product->city->name }}
                                @endif

                                @if ($product->state)
                                    @if ($product->area || $product->city)
                                        ,
                                    @endif

                                    {{ $product->state->name }}
                                @endif

                            </div>


                            {{-- ====================================================
                                Description
                            ==================================================== --}}

                            <p class="card-text text-muted small">
                                {{ Str::limit($product->detail, 100) }}
                            </p>


                            {{-- ====================================================
                                Status
                            ==================================================== --}}

                            <div class="mb-3">

                                @if ($product->status === 'published')

                                    <span class="badge bg-success">
                                        Published
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Draft
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- ====================================================
                            Actions
                        ==================================================== --}}

                        <div class="card-footer bg-white border-0">

                            <div class="d-flex gap-2">

                                {{-- View --}}
                                <a
                                    href="{{ route('products.show', $product->slug) }}"
                                    class="btn btn-outline-primary btn-sm flex-grow-1"
                                >
                                    View
                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('products.edit', $product->id) }}"
                                    class="btn btn-outline-secondary btn-sm"
                                >
                                    Edit
                                </a>


                                {{-- Delete --}}
                                <form
                                    action="{{ route('products.destroy', $product->id) }}"
                                    method="POST"
                                    class="delete-product-form"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="button"
                                        class="btn btn-outline-danger btn-sm delete-product-btn"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                    >
                                        Delete
                                    </button>

                                </form>

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
            Empty State
        ==================================================== --}}

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <h5>
                    No products found
                </h5>

                <p class="text-muted">
                    You haven't posted any products yet.
                </p>

                <a
                    href="{{ route('products.create') }}"
                    class="btn btn-primary"
                >
                    Post Your First Product
                </a>

            </div>

        </div>

    @endif

</div>


{{-- ====================================================
    Delete Product Modal
==================================================== --}}

<div
    class="modal fade"
    id="deleteProductModal"
    tabindex="-1"
    aria-labelledby="deleteProductModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="deleteProductModalLabel"
                >
                    Delete Product
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <p class="mb-1">
                    Are you sure you want to delete this product?
                </p>

                <strong id="deleteProductName"></strong>

                <p class="text-danger small mt-2 mb-0">
                    This action cannot be undone.
                </p>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    id="confirmDeleteProduct"
                >
                    Delete
                </button>

            </div>

        </div>

    </div>

</div>

@endsection


{{-- ====================================================
    Styles
==================================================== --}}

@push('styles')

<style>

    /* ====================================================
       Product Pagination
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

        transition: all 0.2s ease;
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

</style>

@endpush


{{-- ====================================================
    Scripts
==================================================== --}}

@push('scripts')

<script>

$(function () {

    let deleteForm = null;


    /*
    |--------------------------------------------------------------------------
    | Open Delete Modal
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.delete-product-btn', function () {

        deleteForm = $(this).closest('.delete-product-form');

        const productName = $(this).data('product-name');

        $('#deleteProductName').text(productName);


        const modal = new bootstrap.Modal(
            document.getElementById('deleteProductModal')
        );

        modal.show();

    });


    /*
    |--------------------------------------------------------------------------
    | Confirm Delete
    |--------------------------------------------------------------------------
    */

    $('#confirmDeleteProduct').on('click', function () {

        if (!deleteForm) {
            return;
        }


        const button = $(this);


        button
            .prop('disabled', true)
            .text('Deleting...');


        deleteForm.submit();

    });


    /*
    |--------------------------------------------------------------------------
    | Reset Modal
    |--------------------------------------------------------------------------
    */

    $('#deleteProductModal').on(
        'hidden.bs.modal',
        function () {

            deleteForm = null;


            $('#confirmDeleteProduct')
                .prop('disabled', false)
                .text('Delete');

        }
    );

});

</script>

@endpush