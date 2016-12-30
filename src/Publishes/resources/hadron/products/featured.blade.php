<div class="row">

    @foreach ($products as $product)
        @if ($product->is_featured)
            <a href="{{ StoreHelper::productUrl($product->url) }}">
                <div class="col-lg-4">
                    <img class="thumbnail img-responsive" alt="" src="{{ StoreHelper::heroImage($product) }}" />
                </div>
            </a>
        @endif
    @endforeach

</div>
