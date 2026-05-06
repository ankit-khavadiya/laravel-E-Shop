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
                                    <li>
                                        <label class="checkbox-label">
                                            <input type="checkbox" value="{{ $category->id }}" class="category-filter">
                                            <span>{{ $category->name }}</span>
                                            <span class="count">({{ $category->products_count }})</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="filter-widget">
                            <h4>Price Range</h4>
                            <div class="price-range">
                                <input type="range" id="priceRange" min="0" max="1000" step="10">
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
                                    @if($category['parent_id'] === 1)
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
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="product-card">
                                    <div class="product-badge">
                                        @if($product->discount_price)
                                            <span class="badge-sale">-{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%</span>
                                        @endif
                                    </div>
                                    <div class="product-actions">
                                        <a href="#" class="wishlist-btn" data-id="{{ $product->id }}">
                                            <i class="far fa-heart"></i>
                                        </a>
                                        <a href="#" class="quick-view-btn" data-id="{{ $product->id }}">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </div>
                                    <div class="product-image">
                                        <img src="{{ asset('upload/product/' . $product->image) }}" alt="{{ $product->name }}">
                                        <div class="hover-overlay">
                                            <button class="add-to-cart-btn" data-id="{{ $product->id }}">
                                                <i class="fas fa-shopping-bag"></i> Quick Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $product->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <h4 class="product-title">
                                            <a href="{{ route('product-slug', ['slug' => $product->name]) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="product-price">
                                            @if($product->discount_price)
                                                <span class="current-price">${{ number_format($product->discount_price, 2) }}</span>
                                                <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                            @else
                                                <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination-wrapper mt-5">
{{--                        {{ $products->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Filter functionality
        let filters = {
            categories: [],
            brands: [],
            ratings: [],
            minPrice: 0,
            maxPrice: 1000,
            sort: 'latest'
        };

        function applyFilters() {
            $.ajax({
                url: "{{ route('shop-filter') }}",
                type: "POST",
                data: {
                    filters: filters,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#productsGrid').html(response.html);
                    $('#showingCount').text(response.count);
                }
            });
        }

        // Category filter
        $('.category-filter').change(function() {
            let value = $(this).val();
            if ($(this).is(':checked')) {
                filters.categories.push(value);
            } else {
                filters.categories = filters.categories.filter(v => v != value);
            }
            applyFilters();
        });

        // Brand filter
        $('.brand-filter').change(function() {
            let value = $(this).val();
            if ($(this).is(':checked')) {
                filters.brands.push(value);
            } else {
                filters.brands = filters.brands.filter(v => v != value);
            }
            applyFilters();
        });

        // Price range
        $('#priceRange').on('input', function() {
            let max = $(this).val();
            $('#maxPrice').text(max);
            filters.maxPrice = max;
            applyFilters();
        });

        // Sort by
        $('#sortBy').change(function() {
            filters.sort = $(this).val();
            applyFilters();
        });

        // Clear filters
        $('#clearFilters').click(function() {
            $('.category-filter, .brand-filter, .rating-filter').prop('checked', false);
            filters = {
                categories: [],
                brands: [],
                ratings: [],
                minPrice: 0,
                maxPrice: 1000,
                sort: 'latest'
            };
            $('#priceRange').val(1000);
            $('#maxPrice').text(1000);
            applyFilters();
        });
    </script>
@endsection
