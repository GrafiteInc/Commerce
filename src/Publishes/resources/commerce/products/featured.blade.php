<div class="row">

    @foreach ($products as $product)
        @if ($product->is_featured)
            <a href="{{ $product->href }}">
                <div class="col-lg-4">
                    <img class="thumbnail img-responsive" alt="" src="{{ $product->hero_image_url }}" />
                </div>
            </a>
        @endif
    @endforeach

</div>
