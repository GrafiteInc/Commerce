@extends('commerce-frontend::layouts.store')

@section('store-content')

    <div class="row">
        <div class="col-md-8">
            <img class="img-thumbnail img-responsive" alt="" src="{{ $product->hero_image_url }}" />

            <table class="table table-stripped">
                <tr>
                    <td>Name</td>
                    <td class="text-right">{{ $product->name }}</td>
                </tr>
                <tr>
                    <td>Options</td>
                    <td class="text-right">{!! $product->variants !!}</td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td class="text-right">${{ $product->price }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        {!! $product->details !!}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        {!! $product->addToCartBtn('Add To Cart <span class="fa fa-shopping-cart"></span>', 'btn btn-primary float-right') !!}
                        {!! $product->favoriteToggleBtn('Favorite', '<span class="fa fa-heart-o"></span>', '<span class="fa fa-heart"></span>', 'btn btn-outline-secondary float-left') !!}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-4">
            @foreach($product->images as $image)
                <img class="img-thumbnail img-responsive mb-4" alt="" src="{{ $image->url }}" />
            @endforeach
        </div>
    </div>

@endsection
