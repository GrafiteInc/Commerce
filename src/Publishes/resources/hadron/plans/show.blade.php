@extends('quazar-frontend::layouts.store')

@section('store-content')

    <div class="row">
        <h1>{{ $plan->name }}</h1>
        <label>Price</label>
        <p>${{ $plan->price }} / {{ StoreHelper::subscriptionFrequency($plan->interval) }}</p>
        <span>{!! StoreHelper::subscribeBtn($plan->id, 'plan', 'Add To Cart <span class="fa fa-shopping-cart"></span>') !!}</span>
        {!! $plan->details !!}
    </div>

@endsection
