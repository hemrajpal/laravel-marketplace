@extends('layouts.app')

@section('title', 'Add Product')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white py-3">

                    <h1 class="h4 mb-0">
                        Add Product
                    </h1>

                    <p class="text-muted mb-0 mt-1">
                        Add your product or service details.
                    </p>

                </div>


                <div class="card-body p-4">

                    {{-- Validation Errors --}}
                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <strong>
                                Please fix the following errors:
                            </strong>

                            <ul class="mb-0 mt-2">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <form
                        action="{{ route('products.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        {{-- =====================================================
                            Type
                        ====================================================== --}}
                        <div class="mb-3">

                            <label
                                for="type"
                                class="form-label"
                            >
                                Type
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="type"
                                id="type"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select Type
                                </option>

                                <option
                                    value="product"
                                    {{ old('type') === 'product' ? 'selected' : '' }}
                                >
                                    Product
                                </option>

                                <option
                                    value="service"
                                    {{ old('type') === 'service' ? 'selected' : '' }}
                                >
                                    Service
                                </option>

                            </select>


                            @error('type')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- =====================================================
                            Name
                        ====================================================== --}}
                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label"
                            >
                                Product / Service Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                placeholder="Enter product or service name"
                                required
                            >


                            @error('name')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- =====================================================
                            Category
                        ====================================================== --}}
                        <div class="row">

                            {{-- Main Category --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="category_parent_id"
                                    class="form-label"
                                >
                                    Category
                                    <span class="text-danger">*</span>
                                </label>


                                <select
                                    id="category_parent_id"
                                    class="form-select"
                                    required
                                    disabled
                                >

                                    <option value="">
                                        Select Type First
                                    </option>

                                </select>


                                <div class="form-text">
                                    Select a category first.
                                </div>

                            </div>



                            {{-- Subcategory --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="subcategory_id"
                                    class="form-label"
                                >
                                    Subcategory
                                    <span class="text-danger">*</span>
                                </label>


                                <select
                                    id="subcategory_id"
                                    class="form-select"
                                    required
                                    disabled
                                >

                                    <option value="">
                                        Select Category First
                                    </option>

                                </select>


                                <div class="form-text">
                                    Subcategory selection is required.
                                </div>


                                @error('category_id')

                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>


                        {{-- Hidden field actually submitted to Laravel --}}
                        <input
                            type="hidden"
                            name="category_id"
                            id="selected_category_id"
                            value="{{ old('category_id') }}"
                        >



                        {{-- =====================================================
                            Location
                        ====================================================== --}}
                        <h5 class="border-bottom pb-2 mt-4 mb-3">
                            Location
                        </h5>


                        <div class="row">

                            {{-- Country --}}
                            <div class="col-md-4 mb-3">

                                <label
                                    for="country"
                                    class="form-label"
                                >
                                    Country
                                    <span class="text-danger">*</span>
                                </label>


                                <select
                                    name="country"
                                    id="country"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select Country
                                    </option>


                                    @foreach(config('locations') as $country => $st)

                                        <option
                                            value="{{ $country }}"
                                            {{ old('country') == $country ? 'selected' : '' }}
                                        >
                                            {{ $country }}
                                        </option>

                                    @endforeach

                                </select>


                                @error('country')

                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>



                            {{-- State --}}
                            <div class="col-md-4 mb-3">

                                <label
                                    for="state_id"
                                    class="form-label"
                                >
                                    State
                                    <span class="text-danger">*</span>
                                </label>


                                <select
                                    name="state_id"
                                    id="state_id"
                                    class="form-select"
                                    required
                                    disabled
                                >

                                    <option value="">
                                        Select Country First
                                    </option>

                                </select>


                                @error('state_id')

                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>



                            {{-- City --}}
                            <div class="col-md-4 mb-3">

                                <label
                                    for="city_id"
                                    class="form-label"
                                >
                                    City
                                    <span class="text-danger">*</span>
                                </label>


                                <select
                                    name="city_id"
                                    id="city_id"
                                    class="form-select"
                                    required
                                    disabled
                                >

                                    <option value="">
                                        Select State First
                                    </option>

                                </select>


                                @error('city_id')

                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>



                        {{-- =====================================================
                            Area
                        ====================================================== --}}
                        <div class="mb-3">

                            <label
                                for="area"
                                class="form-label"
                            >
                                Area
                                <span class="text-danger">*</span>
                            </label>


                            <input
                                type="text"
                                name="area"
                                id="area"
                                class="form-control"
                                value="{{ old('area') }}"
                                placeholder="Enter area"
                                required
                            >


                            @error('area')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- =====================================================
                            Price
                        ====================================================== --}}
                        <div class="mb-3">

                            <label
                                for="price"
                                class="form-label"
                            >
                                Price
                                <span class="text-danger">*</span>
                            </label>


                            <div class="input-group">

                                <span class="input-group-text">
                                    ₹
                                </span>


                                <input
                                    type="number"
                                    name="price"
                                    id="price"
                                    class="form-control"
                                    value="{{ old('price') }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="Enter price"
                                    required
                                >

                            </div>


                            @error('price')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- =====================================================
                            Images
                        ====================================================== --}}
                        <div class="mb-3">

                            <label
                                for="images"
                                class="form-label"
                            >
                                Product Images
                                <span class="text-danger">*</span>
                            </label>


                            <input
                                type="file"
                                name="images[]"
                                id="images"
                                class="form-control"
                                accept="image/jpeg,image/png,image/webp"
                                multiple
                                required
                            >


                            <div class="form-text">
                                Upload up to 10 images.
                                Maximum 5 MB per image.
                            </div>


                            <div
                                id="imagePreview"
                                class="row g-2 mt-2"
                            ></div>


                            @error('images')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror


                            @error('images.*')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- =====================================================
                            Detail
                        ====================================================== --}}
                        <div class="mb-4">

                            <label
                                for="detail"
                                class="form-label"
                            >
                                Detail
                                <span class="text-danger">*</span>
                            </label>


                            <textarea
                                name="detail"
                                id="detail"
                                class="form-control"
                                rows="6"
                                placeholder="Describe your product or service..."
                                required
                            >{{ old('detail') }}</textarea>


                            @error('detail')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- =====================================================
                            Buttons
                        ====================================================== --}}
                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary px-4"
                            >
                                Publish
                            </button>


                            <a
                                href="{{ route('home') }}"
                                class="btn btn-outline-secondary"
                            >
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | Laravel Data
    |--------------------------------------------------------------------------
    */

    const categories = @json($categories);

    const states = @json($states);

    const locations = @json(config('locations'));


    /*
    |--------------------------------------------------------------------------
    | Old Values
    |--------------------------------------------------------------------------
    */

    const oldType = @json(old('type'));

    const oldCategoryId = @json(old('category_id'));

    const oldCountry = @json(old('country'));

    const oldStateId = @json(old('state_id'));

    const oldCityId = @json(old('city_id'));


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const $typeSelect = $('#type');

    const $categoryParentSelect = $('#category_parent_id');

    const $subcategorySelect = $('#subcategory_id');

    const $selectedCategoryInput = $('#selected_category_id');

    const $countrySelect = $('#country');

    const $stateSelect = $('#state_id');

    const $citySelect = $('#city_id');

    const $imageInput = $('#images');

    const $imagePreview = $('#imagePreview');



    /*
    |--------------------------------------------------------------------------
    | Find Parent Category
    |--------------------------------------------------------------------------
    |
    | If old category_id is a child category, find its parent.
    |
    */

    function findParentCategory(categoryId) {

        const category = categories.find(function (item) {

            return item.id == categoryId;

        });


        if (!category) {

            return null;

        }


        /*
        |--------------------------------------------------------------------------
        | Already a parent category
        |--------------------------------------------------------------------------
        */

        if (category.parent_id === null) {

            return category;

        }


        /*
        |--------------------------------------------------------------------------
        | Find parent
        |--------------------------------------------------------------------------
        */

        return categories.find(function (item) {

            return item.id == category.parent_id;

        }) || null;

    }



    /*
    |--------------------------------------------------------------------------
    | Load Main Categories
    |--------------------------------------------------------------------------
    */

    function loadCategories(
        type,
        selectedCategoryId = null
    ) {

        $categoryParentSelect
            .html('<option value="">Select Category</option>')
            .prop('disabled', true);


        $subcategorySelect
            .html('<option value="">Select Category First</option>')
            .prop('disabled', true);


        $selectedCategoryInput.val('');


        if (!type) {

            $categoryParentSelect.html(
                '<option value="">Select Type First</option>'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Main Categories Only
        |--------------------------------------------------------------------------
        */

        const mainCategories = categories.filter(function (category) {

            return (
                category.type === type &&
                category.parent_id === null
            );

        });


        /*
        |--------------------------------------------------------------------------
        | Add Main Categories
        |--------------------------------------------------------------------------
        */

        $.each(mainCategories, function (index, category) {

            const $option = $('<option>', {

                value: category.id,

                text: category.name

            });


            /*
            |--------------------------------------------------------------------------
            | If selected category is a child,
            | select its parent.
            |--------------------------------------------------------------------------
            */

            const selectedCategory = categories.find(function (item) {

                return item.id == selectedCategoryId;

            });


            if (
                selectedCategory &&
                (
                    selectedCategory.id == category.id ||
                    selectedCategory.parent_id == category.id
                )
            ) {

                $option.prop('selected', true);

            }


            $categoryParentSelect.append($option);

        });


        $categoryParentSelect.prop('disabled', false);


        /*
        |--------------------------------------------------------------------------
        | Restore Subcategory
        |--------------------------------------------------------------------------
        */

        if (selectedCategoryId) {

            const parentCategory = findParentCategory(
                selectedCategoryId
            );


            if (parentCategory) {

                $categoryParentSelect.val(
                    parentCategory.id
                );


                loadSubcategories(
                    parentCategory.id,
                    selectedCategoryId
                );

            }

        }

    }



    /*
    |--------------------------------------------------------------------------
    | Load Subcategories
    |--------------------------------------------------------------------------
    */

    function loadSubcategories(
        parentCategoryId,
        selectedSubcategoryId = null
    ) {

        $subcategorySelect
            .html('<option value="">Select Subcategory</option>')
            .prop('disabled', true);


        $selectedCategoryInput.val('');


        if (!parentCategoryId) {

            $subcategorySelect.html(
                '<option value="">Select Category First</option>'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Find Children
        |--------------------------------------------------------------------------
        */

        const subcategories = categories.filter(function (category) {

            return (
                category.parent_id == parentCategoryId
            );

        });


        /*
        |--------------------------------------------------------------------------
        | Subcategory Required
        |--------------------------------------------------------------------------
        */

        if (subcategories.length === 0) {

            $subcategorySelect.html(
                '<option value="">No Subcategory Available</option>'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Add Subcategories
        |--------------------------------------------------------------------------
        */

        $.each(subcategories, function (index, subcategory) {

            const $option = $('<option>', {

                value: subcategory.id,

                text: subcategory.name

            });


            if (
                selectedSubcategoryId &&
                selectedSubcategoryId == subcategory.id
            ) {

                $option.prop('selected', true);

                $selectedCategoryInput.val(
                    subcategory.id
                );

            }


            $subcategorySelect.append($option);

        });


        $subcategorySelect.prop('disabled', false);

    }



    /*
    |--------------------------------------------------------------------------
    | Type Change
    |--------------------------------------------------------------------------
    */

    $typeSelect.on('change', function () {

        loadCategories(
            $(this).val()
        );

    });



    /*
    |--------------------------------------------------------------------------
    | Category Change
    |--------------------------------------------------------------------------
    */

    $categoryParentSelect.on('change', function () {

        loadSubcategories(
            $(this).val()
        );

    });



    /*
    |--------------------------------------------------------------------------
    | Subcategory Change
    |--------------------------------------------------------------------------
    */

    $subcategorySelect.on('change', function () {

        /*
        |--------------------------------------------------------------------------
        | Store selected CHILD category in category_id
        |--------------------------------------------------------------------------
        */

        $selectedCategoryInput.val(
            $(this).val()
        );

    });



    /*
    |--------------------------------------------------------------------------
    | Country -> State
    |--------------------------------------------------------------------------
    */

    function loadStates(
        country,
        selectedStateId = null
    ) {

        $stateSelect
            .html('<option value="">Select State</option>')
            .prop('disabled', true);


        $citySelect
            .html('<option value="">Select State First</option>')
            .prop('disabled', true);


        if (
            !country ||
            !locations[country]
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Add States
        |--------------------------------------------------------------------------
        */

        $.each(
            locations[country],
            function (stateName) {

                const state = states.find(function (item) {

                    return item.name === stateName;

                });


                if (!state) {

                    return;

                }


                const $option = $('<option>', {

                    value: state.id,

                    text: state.name

                });


                if (
                    selectedStateId &&
                    selectedStateId == state.id
                ) {

                    $option.prop('selected', true);

                }


                $stateSelect.append($option);

            }
        );


        $stateSelect.prop('disabled', false);


        /*
        |--------------------------------------------------------------------------
        | Restore City
        |--------------------------------------------------------------------------
        */

        if (selectedStateId) {

            loadCities(
                selectedStateId,
                oldCityId
            );

        }

    }



    /*
    |--------------------------------------------------------------------------
    | State -> City
    |--------------------------------------------------------------------------
    */

    function loadCities(
        stateId,
        selectedCityId = null
    ) {

        $citySelect
            .html('<option value="">Select City</option>')
            .prop('disabled', true);


        if (!stateId) {

            $citySelect.html(
                '<option value="">Select State First</option>'
            );

            return;

        }


        const state = states.find(function (item) {

            return item.id == stateId;

        });


        if (!state) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Add Cities
        |--------------------------------------------------------------------------
        */

        $.each(
            state.cities || [],
            function (index, city) {

                const $option = $('<option>', {

                    value: city.id,

                    text: city.name

                });


                if (
                    selectedCityId &&
                    selectedCityId == city.id
                ) {

                    $option.prop('selected', true);

                }


                $citySelect.append($option);

            }
        );


        $citySelect.prop('disabled', false);

    }



    /*
    |--------------------------------------------------------------------------
    | Country Change
    |--------------------------------------------------------------------------
    */

    $countrySelect.on('change', function () {

        loadStates(
            $(this).val()
        );

    });



    /*
    |--------------------------------------------------------------------------
    | State Change
    |--------------------------------------------------------------------------
    */

    $stateSelect.on('change', function () {

        loadCities(
            $(this).val()
        );

    });



    /*
    |--------------------------------------------------------------------------
    | Restore Category After Validation Error
    |--------------------------------------------------------------------------
    */

    if (oldType) {

        loadCategories(
            oldType,
            oldCategoryId
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Restore Location After Validation Error
    |--------------------------------------------------------------------------
    */

    if (oldCountry) {

        loadStates(
            oldCountry,
            oldStateId
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Image Preview
    |--------------------------------------------------------------------------
    */

    $imageInput.on('change', function () {

        $imagePreview.empty();


        const files = Array.from(this.files);


        /*
        |--------------------------------------------------------------------------
        | Maximum 10 Images
        |--------------------------------------------------------------------------
        */

        if (files.length > 10) {

            alert(
                'You can upload maximum 10 images.'
            );


            $(this).val('');

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Preview
        |--------------------------------------------------------------------------
        */

        $.each(
            files,
            function (index, file) {

                const reader = new FileReader();


                reader.onload = function (event) {

                    const $col = $('<div>', {

                        class: 'col-6 col-md-3'

                    });


                    const $card = $('<div>', {

                        class: 'card h-100'

                    });


                    const $image = $('<img>', {

                        src: event.target.result,

                        class: 'card-img-top'

                    });


                    $image.css({

                        height: '120px',

                        objectFit: 'cover'

                    });


                    $card.append($image);

                    $col.append($card);

                    $imagePreview.append($col);

                };


                reader.readAsDataURL(file);

            }
        );

    });

});

</script>

@endpush