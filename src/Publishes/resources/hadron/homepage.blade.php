@extends('hadron-frontend::layouts.store')

@section('store-content')

    @include('hadron-frontend::homepage.banner')

    @include('hadron-frontend::products.featured')

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <span class="plan-title"><a href="{{ StoreHelper::productUrl($product->url) }}">{!! $product->name !!}</a></span>
                    </div>
                    <div class="panel-body text-center plan-details">
                        <img class="thumbnail img-responsive" alt="" src="{{ StoreHelper::heroImage($product) }}" />
                        ${!! $product->price !!}<br>
                        {!! $product->code !!}
                    </div>
                    <div class="panel-footer">
                        {!! StoreHelper::addToCartBtn($product->id, 'product', 'Add To Cart <span class="fa fa-shopping-cart"></span>', 'btn btn-primary btn-block') !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <span class="plan-title"><a href="{{ StoreHelper::subscriptionUrl($plan->id) }}">{{ $plan->name }}</a></span>
                    </div>
                    <div class="panel-body text-center plan-details">
                        <span class="lead">$ {{ $plan->amount/100 }} {{ strtoupper($plan->currency) }}/ {{ strtoupper($plan->interval) }}</span><br>
                        <span class="plan-slogan">{{ $plan->slogan }}</span><br>
                        <span class="plan-description">{{ $plan->description }}</span>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ StoreHelper::subscriptionUrl($plan->id) }}">Subscribe</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
