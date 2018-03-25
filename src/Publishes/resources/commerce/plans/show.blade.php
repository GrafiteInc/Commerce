@extends('commerce-frontend::layouts.store')

@section('store-content')

    <div class="row">
        <h1>{{ $plan->name }}</h1>
        <label>Price</label>
        <p>${{ $plan->price }} / {{ $plan->frequency }}</p>
        <span>{!! $plan->subscribeBtn('Subscribe <span class="fa fa-shopping-cart"></span>', 'btn btn-primary') !!}</span>
        {!! $plan->details !!}
    </div>

@endsection
