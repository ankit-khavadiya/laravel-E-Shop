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
                <a href="{{ route('product-slug', ['slug' => base64_encode($product->id)]) }}" class="quick-view-btn" data-id="{{ $product->id }}">
                    <i class="far fa-eye"></i>
                </a>
            </div>
            <div class="product-image">
                @php
                    $imagePath = public_path('upload/product/' . $product->image);
                    $imageUrl = file_exists($imagePath) && !empty($product->image) ? asset('upload/product/' . $product->image) : asset('assets/images/web/placeholders/no-image.png');
                @endphp
                <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
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
                    <a href="{{ route('product-slug', ['slug' => base64_encode($product->id)]) }}">{{ $product->name }}</a>
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
