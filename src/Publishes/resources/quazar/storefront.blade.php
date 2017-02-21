@extends('quazar-frontend::layouts.store')

@section('store-content')

    @include('quazar-frontend::storefront.banner')

    @include('quazar-frontend::products.featured')

    @include('quazar-frontend::plans.featured')

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <span class="plan-title"><a href="{{ $product->href }}">{!! $product->name !!}</a></span>
                    </div>
                    <div class="panel-body text-center plan-details">
                        <img class="thumbnail img-responsive" alt="" src="{{ $product->hero_image_url }}" />
                        ${!! $product->price !!}<br>
                        {!! $product->code !!}
                    </div>
                    <div class="panel-footer">
                        {!! $product->addToCartBtn('Add To Cart <span class="fa fa-shopping-cart"></span>', 'btn btn-primary btn-block') !!}
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
                        <span class="plan-title"><a href="{{ $plan->href }}">{{ $plan->name }}</a></span>
                    </div>
                    <div class="panel-body text-center plan-details">
                        <span class="lead">$ {{ $plan->amount/100 }} {{ strtoupper($plan->currency) }}/ {{ strtoupper($plan->interval) }}</span><br>
                        <span class="plan-slogan">{{ $plan->slogan }}</span><br>
                        <span class="plan-description">{{ $plan->description }}</span>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ $plan->href }}">Subscribe</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
