@extends('commerce-frontend::layouts.store')

@section('stylesheets')
    @parent
    {!! Minify::stylesheet('/css/card.css') !!}
@stop

@section('store-content')

    <h1 class="mb-4">Checkout: Payment</h1>

    <div class="row">
        <div class="col-md-8">
            @include('commerce-frontend::checkout.products')
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div class="card-wrapper"></div>
            </div>

            <form id="userPayment" method="post" action="{{ route('commerce.process') }}">
                {!! csrf_field() !!}
                <input id="exp_month" type="hidden" name="exp_month" data-stripe="exp-month" />
                <input id="exp_year" type="hidden" name="exp_year" data-stripe="exp-year"/>
                <div class="row">
                    <div class="col-md-12">
                        <label for="number">Card Number</label>
                        <input id="number" required type="text" name="number" class="form-control" placeholder="Card Number" data-stripe="number">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="name">Full Name</label>
                        <input id="name" required type="text" name="name" class="form-control" placeholder="Full Name" data-stripe="name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="cvc">CVV</label>
                        <input id="cvc" required type="text" name="cvc" class="form-control" placeholder="CVV" data-stripe="cvc">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cvc">Expiry</label>
                        <input id="expiry" required type="text" name="expiry" class="form-control" placeholder="MM/YY">
                    </div>
                </div>
                <div>
                    <input id="pay" type="submit" class="btn btn-primary pull-right" value="Pay">
                </div>
            </form>

            @if (commerce()->customer()->hasProfile() && ! is_null(commerce()->customer()->lastCard('card_last_four')))
                <form method="post" action="{{ route('commerce.process.last-card') }}">
                    {!! csrf_field() !!}
                    <button class="btn btn-outline-primary" id="lastCardBtn" type="submit">Pay with card (ending in {!! commerce()->customer()->lastCard('card_last_four') !!})</button>
                </form>
            @endif
        </div>
    </div>
@stop

@section('pre-javascript')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script> Stripe.setPublishableKey('{{ config("services.stripe.key") }}'); </script>
@stop

@section('javascript')
    @parent
    {!! Minify::javascript('/js/card.js') !!}
    {!! Minify::javascript('/js/purchases.js') !!}
@stop
