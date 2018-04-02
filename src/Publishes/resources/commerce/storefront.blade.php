@extends('commerce-frontend::layouts.store')

@section('store-content')

    @include('commerce-frontend::storefront.banner')

    @include('commerce-frontend::products.featured')

    @include('commerce-frontend::plans.featured')

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3">
                <div class="card card-default mb-4">
                    <div class="card-header text-center">
                        <span class="plan-title"><a href="{{ $product->href }}">{!! $product->name !!}</a></span>
                    </div>
                    <div class="card-body text-center plan-details">
                        <img class="img-thumbnail img-responsive" alt="" src="{{ $product->hero_image_url }}" />
                        ${!! $product->price !!}<br>
                        {!! $product->code !!}
                    </div>
                    <div class="card-footer">
                        {!! $product->addToCartBtn('Add To Cart <span class="fa fa-shopping-cart"></span>', 'btn btn-primary btn-block') !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-md-3">
                <div class="card card-default mb-4">
                    <div class="card-header text-center">
                        <span class="plan-title"><a href="{{ $plan->href }}">{{ $plan->name }}</a></span>
                    </div>
                    <div class="card-body text-center plan-details">
                        <span class="lead">$ {{ $plan->amount }} {{ strtoupper($plan->currency) }}/ {{ strtoupper($plan->interval) }}</span><br>
                        <span class="plan-slogan">{{ $plan->slogan }}</span><br>
                        <span class="plan-description">{{ $plan->description }}</span>
                    </div>
                    <div class="card-footer">
                        <a href="{{ $plan->href }}">Subscribe</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
