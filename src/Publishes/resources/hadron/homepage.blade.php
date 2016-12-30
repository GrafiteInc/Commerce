@extends('hadron-frontend::layouts.store')

@section('store-content')

    @include('hadron-frontend::products.featured')

    <h1>Products</h1>
    <table class="table table-stripped">
        <thead>
            <td>Name</td>
            <td>Code</td>
            <td>Price</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><a href="{{ StoreHelper::productUrl($product->url) }}">{!! $product->name !!}</a></td>
                    <td>{!! $product->code !!}</td>
                    <td>${!! $product->price !!}</td>
                    <td>{!! StoreHelper::addToCartBtn($product->id, 'product', 'Add To Cart <span class="fa fa-shopping-cart"></span>') !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h1>Subscriptions</h1>
    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-md-3">
                <a href="{{ StoreHelper::subscriptionUrl($plan->id) }}">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <h3 class="plan-title">{{ $plan->name }}</h3>
                        </div>
                        <div class="panel-body text-center plan-details">
                            <h2>$ {{ $plan->amount/100 }} {{ strtoupper($plan->currency) }}/ {{ strtoupper($plan->interval) }}</h2>
                            <p><span class="plan-slogan">{{ $plan->slogan }}</span></p>
                            <p><span class="plan-description">{{ $plan->description }}</span></p>
                        </div>
                        <div class="panel-footer">
                            <p><span class="plan-descriptor">{{ $plan->descriptor }}</span></p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@endsection
