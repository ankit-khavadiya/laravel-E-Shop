@foreach($products as $product)
<div class="col-lg-4 col-md-6">
    <div class="product-card">

        <div class="product-badge">
            @if($product->discount_price)
            <span class="badge-sale">
                        -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                    </span>
            @endif
        </div>

        <div class="product-image">
            @php
            $imagePath = public_path('upload/product/' . $product->image);
            $imageUrl = file_exists($imagePath) && !empty($product->image)
            ? asset('upload/product/' . $product->image)
            : asset('assets/images/web/placeholders/no-image.png');
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
        </div>

        <div class="product-info">
            <h4>{{ $product->name }}</h4>

            <div class="product-price">
                @if($product->discount_price)
                <span>${{ $product->discount_price }}</span>
                <del>${{ $product->price }}</del>
                @else
                <span>${{ $product->price }}</span>
                @endif
            </div>
        </div>

    </div>
</div>
@endforeach
