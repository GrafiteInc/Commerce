@extends('quazar-frontend::layouts.store')

@section('stylesheets')
    @parent
    {!! Minify::stylesheet('/css/card.css') !!}
@stop

@section('store-content')

    <h1>Checkout: Payment</h1>

    <div class="col-md-8">
        @include('quazar-frontend::checkout.products')
    </div>
    <div class="col-md-4">
            <div class="form-group">
                <div class="card-wrapper"></div>
            </div>

            <form id="userPayment" method="post" action="{{ route('quazar.process') }}">
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

            @if (StoreHelper::customer()->hasProfile() && ! is_null(StoreHelper::customer()->lastCard('card_last_four')))
                <form method="post" action="{{ route('quazar.process.last-card') }}">
                    {!! csrf_field() !!}
                    <button class="btn btn-default" id="lastCardBtn" type="submit">Pay with last card used (ending with {!! StoreHelper::customer()->lastCard('card_last_four') !!})</button>
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
