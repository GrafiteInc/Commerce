@extends('commerce-frontend::layouts.store')

@section('store-content')

    @include('commerce-frontend::profile.tabs')

    <div class="tabs-content">
        <div role="tabpanel" class="tab-pane tab-active">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="number">Card Brand</label>
                    <input class="form-control" disabled type="text" name="number" value="{{ auth()->user()->meta->card_brand }}">
                </div>
                <div class="form-group">
                    <label for="number">Card Number</label>
                    <input class="form-control" disabled type="text" name="number" value="**** **** **** {{ auth()->user()->meta->card_last_four }}">
                </div>
                <div class="form-group">
                    <a href="{{ route('commerce.account.card-change') }}" class="btn btn-warning pull-right">Change Card</a>
                </div>
            </div>
        </div>
    </div>

@endsection

