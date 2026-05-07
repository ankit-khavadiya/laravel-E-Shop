@extends('web.master')

@section('title', 'Shop - E-Shop')

@section('page-content')
    <div class="shop-section">
        <div class="page-header">
            <div class="container">
                <h1>Shop Collection</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Shop</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3">
                    <div class="filter-sidebar">
                        <div class="filter-widget">
                            <h4>Categories</h4>
                            <ul class="filter-list">
                                @foreach($categories as $category)
                                    @if($category['parent_id'] === 0)
                                        <li>
                                            <label class="checkbox-label">
                                                <input type="checkbox" value="{{ $category->id }}" class="category-filter">
                                                <span>{{ $category->name }}</span>
                                                <span class="count">({{ $category->products_count }})</span>
                                            </label>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <div class="filter-widget">
                            <h4>Price Range</h4>
                            <div class="price-range">
                                <input type="range" id="priceRange" min="0" max="10000" step="3">
                                <div class="price-values">
                                    <span>$<span id="minPrice">0</span></span>
                                    <span>-</span>
                                    <span>$<span id="maxPrice">1000</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="filter-widget">
                            <h4>Brands</h4>
                            <ul class="filter-list">
                                @foreach($categories as $category)
                                    @if($category['parent_id'] != 0)
                                        <li>
                                            <label class="checkbox-label">
                                                <input type="checkbox" value="{{ $category->id }}" class="brand-filter">
                                                <span>{{ $category->name }}</span>
                                            </label>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <div class="filter-widget">
                            <h4>Rating</h4>
                            <ul class="filter-list">
                                <li>
                                    <label class="checkbox-label">
                                        <input type="checkbox" value="4" class="rating-filter">
                                        <span><i class="fas fa-star"></i> 4 & above</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox-label">
                                        <input type="checkbox" value="3" class="rating-filter">
                                        <span><i class="fas fa-star"></i> 3 & above</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <button class="btn btn-primary w-100" id="clearFilters">Clear All Filters</button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <div class="shop-header">
                        <div class="showing-results">
                            Showing <span id="showingCount">0</span> of <span id="totalCount">
{{--                                {{ $products->total() }}--}}
                            </span> results
                        </div>
                        <div class="sort-options">
                            <select id="sortBy" class="form-select">
                                <option value="latest">Latest</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="popular">Popularity</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4" id="productsGrid">
                        @include('web.shop.product-grid-component')
                    </div>

                    <div class="pagination-wrapper mt-5">
{{--                        {{ $products->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('webJs')
    <script>
        let filters = {
            categories: [],
            brands: [],
            ratings: [],
            minPrice: 0,
            maxPrice: 1000,
            sort: 'latest'
        };

        /*
        |--------------------------------------------------------------------------
        | APPLY FILTER
        |--------------------------------------------------------------------------
        */
        function applyFilters() {
            $('#productsGrid').html(`
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary"></div>
            </div>
            `);

            $.ajax({
                url: "{{ route('shop-filter') }}",
                type: "POST",
                data: {
                    filters: filters,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response)
                    if (response.status) {
                        $('#productsGrid').html(response.data.html);
                        $('#showingCount').text(response.data.count);
                    }
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */
        $('.category-filter').change(function () {
            let value = $(this).val();
            if ($(this).is(':checked')) {
                filters.categories.push(value);
            } else {
                filters.categories = filters.categories.filter(v => v != value);
            }
            applyFilters();
        });

        /*
        |--------------------------------------------------------------------------
        | BRAND FILTER
        |--------------------------------------------------------------------------
        */
        $('.brand-filter').change(function () {
            let value = $(this).val();
            if ($(this).is(':checked')) {
                filters.brands.push(value);
            } else {
                filters.brands = filters.brands.filter(v => v != value);
            }
            applyFilters();
        });

        /*
        |--------------------------------------------------------------------------
        | RATING FILTER
        |--------------------------------------------------------------------------
        */
        $('.rating-filter').change(function () {
            let value = $(this).val();

            if ($(this).is(':checked')) {
                filters.ratings.push(value);
            } else {
                filters.ratings = filters.ratings.filter(v => v != value);
            }
            applyFilters();
        });

        /*
        |--------------------------------------------------------------------------
        | PRICE FILTER
        |--------------------------------------------------------------------------
        */
        $('#priceRange').on('input', function () {
            let max = $(this).val();
            $('#maxPrice').text(max);
            filters.maxPrice = max;
            applyFilters();
        });

        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */
        $('#sortBy').change(function () {
            filters.sort = $(this).val();
            applyFilters();
        });

        /*
        |--------------------------------------------------------------------------
        | CLEAR FILTER
        |--------------------------------------------------------------------------
        */
        $('#clearFilters').click(function () {
            $('.category-filter').prop('checked', false);
            $('.brand-filter').prop('checked', false);
            $('.rating-filter').prop('checked', false);
            filters = {
                categories: [],
                brands: [],
                ratings: [],
                minPrice: 0,
                maxPrice: 1000,
                sort: 'latest'
            };
            $('#priceRange').val(10000);
            $('#maxPrice').text(10000);
            applyFilters();
        });
    </script>
@endsection
