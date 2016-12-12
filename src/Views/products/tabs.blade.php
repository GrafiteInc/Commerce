<div class="row raw-margin-bottom-24">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" {!! (! is_null(request('details')) || isset($tabs['details'])) ? 'class="active"': '' !!}>
            <a href="{!! URL::to('quarx/products/'.$product->id.'/edit?details') !!}" role="tab">Details</a>
        </li>
        <li role="presentation" {!! (! is_null(request('variants'))) ? 'class="active"': '' !!}>
            <a href="{!! URL::to('quarx/products/'.$product->id.'/edit?variants') !!}" role="tab">Variants</a>
        </li>
        @if ($product->is_download)
            <li role="presentation" {!! (! is_null(request('download'))) ? 'class="active"': '' !!}>
                <a href="{!! URL::to('quarx/products/'.$product->id.'/edit?download') !!}" role="tab">Download</a>
            </li>
        @else
            <li role="presentation" {!! (! is_null(request('dimensions'))) ? 'class="active"': '' !!}>
                <a href="{!! URL::to('quarx/products/'.$product->id.'/edit?dimensions') !!}" role="tab">Dimensions</a>
            </li>
        @endif
        <li role="presentation" {!! (! is_null(request('discount'))) ? 'class="active"': '' !!}>
            <a href="{!! URL::to('quarx/products/'.$product->id.'/edit?discount') !!}" role="tab">Discounts</a>
        </li>
    </ul>
</div>

@if (! is_null(request('details')) || isset($tabs['details']))
    @include('hadron::products.tabs.details')
@endif

@if (! is_null(request('variants')))
    @include('hadron::products.tabs.variants')
@endif

@if (! is_null(request('discount')))
    @include('hadron::products.tabs.discount')
@endif

@if (! is_null(request('download')))
    @include('hadron::products.tabs.download')
@endif

@if (! is_null(request('dimensions')))
    @include('hadron::products.tabs.dimensions')
@endif
