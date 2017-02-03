@extends('quazar-frontend::layouts.store')

@section('store-content')

    <div class="row">
        <img class="thumbnail img-responsive" alt="" src="{{ StoreHelper::heroImage($product) }}" />

        <table class="table table-stripped">
            <tr>
                <td>Name</td>
                <td class="text-right">{{ $product->name }}</td>
            </tr>
            <tr>
                <td>Options</td>
                <td class="text-right">{!! StoreHelper::productVariants($product) !!}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td class="text-right">{{ $product->price }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    {!! $product->details !!}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">
                    {!! StoreHelper::addToCartBtn($product->id, 'product', 'Add To Cart <span class="fa fa-shopping-cart"></span>', 'btn btn-primary') !!}
                </td>
            </tr>
        </table>
    </div>

@endsection
