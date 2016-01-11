<div class="row raw-margin-bottom-24">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" {!! (isset($details)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.CryptoService::encrypt($product->id).'/edit?details') !!}" role="tab">Details</a></li>
        <li role="presentation" {!! (isset($variants)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.CryptoService::encrypt($product->id).'/edit?variants') !!}" role="tab">Variants</a></li>
        @if ($product->is_subscription)
            <li role="presentation" {!! (isset($subscription)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.CryptoService::encrypt($product->id).'/edit?subscription') !!}" role="tab">Subscription</a></li>
        @endif
        <li role="presentation" {!! (isset($related)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.CryptoService::encrypt($product->id).'/edit?related') !!}" role="tab">Related Products</a></li>
    </ul>
</div>

@if (isset($details))
    @include('hadron::products.details')
@endif

@if (isset($variants))
    @include('hadron::products.variants')
@endif

@if (isset($subscription))
    @include('hadron::products.subscription')
@endif

@if (isset($related))
    @include('hadron::products.related')
@endif