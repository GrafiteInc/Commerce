<div class="row raw-margin-bottom-24">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" {!! (isset($details)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.Crypto::encrypt($products->id).'/edit?details') !!}" role="tab">Details</a></li>
        <li role="presentation" {!! (isset($variables)) ? 'class="active"': '' !!}><a href="{!! URL::to('quarx/products/'.Crypto::encrypt($products->id).'/edit?variables') !!}" role="tab">Variants</a></li>
    </ul>
</div>

@if (isset($details))

    @include('quarx::quarx.products.details')

@endif

@if (isset($variables))

    @include('quarx::quarx.products.variables')

@endif

@if (isset($iterations))

    @include('quarx::quarx.products.iterations')

@endif

@if (isset($editIteration))

    @include('quarx::products.edit-iteration')

@endif