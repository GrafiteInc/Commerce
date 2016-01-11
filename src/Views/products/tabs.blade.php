<div class="row raw-margin-bottom-24">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" {!! (isset($details)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.CryptoService::encrypt($product->id).'/edit?details') !!}" role="tab">Details</a></li>
        <li role="presentation" {!! (isset($variants)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.CryptoService::encrypt($product->id).'/edit?variants') !!}" role="tab">Variants</a></li>
        @if ($product->is_subscription)
            <li role="presentation" {!! (isset($subscription)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.CryptoService::encrypt($product->id).'/edit?subscription') !!}" role="tab">Subscription</a></li>
        @endif
        @if ($product->is_download)
            <li role="presentation" {!! (isset($download)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.CryptoService::encrypt($product->id).'/edit?download') !!}" role="tab">Download</a></li>
        @endif
        <li role="presentation" {!! (isset($discount)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.CryptoService::encrypt($product->id).'/edit?discount') !!}" role="tab">Discounts</a></li>
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

@if (isset($download))
    @include('hadron::products.download')
@endif

@if (isset($discount))
    @include('hadron::products.discount')
@endif

@if (isset($related))
    @include('hadron::products.related')
@endif