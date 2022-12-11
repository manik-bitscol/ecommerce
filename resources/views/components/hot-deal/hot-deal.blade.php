<div class="item">
    <div class="products">
        <div class="hot-deal-wrapper">
            <div class="image">
                <img src="{{ asset($product->product_thumbnail) }}" alt="{{ $product->product_name_en }}">
            </div>
            <div class="sale-offer-tag">
                <div class="dicount-price">
                    @if ($product->discount_type == 'flat')
                        @if (session()->get('language') === 'bangla')
                            {{ toBanglaNumber($product->discount) }} TK Off
                        @else
                            {{ $product->discount }} TK Off
                        @endif
                    @else
                        @if (session()->get('language') === 'bangla')
                            {{ toBanglaNumber($product->discount) }}% Off
                        @else
                            {{ $product->discount }}% Off
                        @endif
                    @endif
                </div>
            </div>
            <div class="timing-wrapper">
                <div class="box-wrapper">
                    <div class="date box">
                        @if (session()->get('language') === 'bangla')
                            <span class="key">১২০</span>
                            <span class="value">দিন</span>
                        @else
                            <span class="key">120</span>
                            <span class="value">DAYS</span>
                        @endif
                    </div>
                </div>

                <div class="box-wrapper">
                    <div class="hour box">
                        @if (session()->get('language') === 'bangla')
                            <span class="key">২০</span>
                            <span class="value">ঘণ্টা</span>
                        @else
                            <span class="key">20</span>
                            <span class="value">HRS</span>
                        @endif
                    </div>
                </div>

                <div class="box-wrapper">
                    <div class="minutes box">
                        @if (session()->get('language') === 'bangla')
                            <span class="key">৩৬</span>
                            <span class="value">মিনিট</span>
                        @else
                            <span class="key">36</span>
                            <span class="value">MINS</span>
                        @endif
                    </div>
                </div>

                <div class="box-wrapper hidden-md">
                    <div class="seconds box">
                        @if (session()->get('language') === 'bangla')
                            <span class="key">৩৬</span>
                            <span class="value">সেকেন্ড</span>
                        @else
                            <span class="key">36</span>
                            <span class="value">SECONDS</span>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- /.hot-deal-wrapper -->

        <div class="product-info text-left m-t-20">
            <h3 class="name">
                <a href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->product_slug_en]) }}">
                    {{ session()->get('language') == 'bangla' ? $product->product_name_bn : $product->product_name_en }}
                </a>
            </h3>
            <div class="rating rateit-small"></div>

            <div class="product-price">
                <span class="price">
                    ৳{{ session()->get('language') == 'bangla' ? toBanglaNumber($product->discount_price) : $product->discount_price }}
                </span>

                <span
                    class="price-before-discount">৳{{ session()->get('language') == 'bangla' ? toBanglaNumber($product->selling_price) : $product->selling_price }}</span>

            </div><!-- /.product-price -->

        </div><!-- /.product-info -->

        <div class="cart clearfix animate-effect">
            <div class="action">

                <div class="add-cart-button btn-group">
                    <button class="btn btn-primary icon" type="button" onClick="viewProduct({{ $product->id }})"
                        data-toggle="modal" data-target="#view-product-modal">
                        <i class="fa fa-eye"></i>
                    </button>
                    <input type="hidden" name="add_to_cart" class="product-id" value="{{ $product->id }}">
                    <button class="btn btn-primary cart-btn" type="button"
                        onClick="addToCart()">{{ session()->get('language') == 'bangla' ? 'কার্টে যুক্ত করুন' : 'Add To Cart' }}</button>

                </div>

            </div><!-- /.action -->
        </div><!-- /.cart -->
    </div>
</div>
