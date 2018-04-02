@extends('cms::layouts.dashboard')

@section('pageTitle') Analytics: Last {{ request()->months }} @if (request()->months > 1) Months @else Month @endif @stop

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="m-hidden float-right">
                {!! Form::open(['method' => 'get']) !!}
                <input type="number" class="form-control header-input float-right raw-margin-right-24" name="months" placeholder="Months In History" value="{{ request()->months }}">
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <h4 class="raw-margin-bottom-24">Transaction Balance</h4>
            <canvas id="pieGraph"></canvas>
        </div>
        <div class="col-md-8">
            <h4 class="raw-margin-bottom-24">Transactions &amp; Subscriptions</h4>
            <canvas id="lineGraph"></canvas>
        </div>
    </div>

    <div class="row raw-margin-bottom-24">
        <div class="col-md-12">
            <h4 class="raw-margin-bottom-24">Transaction History</h4>
            @if ($transactions->count() === 0)
                <div class="card">
                    <div class="card-body text-center">No Transactions found.</div>
                </div>
            @else
                @include('commerce::analytics.transaction-table')
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4 class="raw-margin-bottom-24">Subscription History</h4>
            @if ($subscriptions->count() === 0)
                <div class="card">
                    <div class="card-body text-center">No Subscriptions found.</div>
                </div>
            @else
                @include('commerce::analytics.subscription-table')
            @endif
        </div>
    </div>
</div>

@endsection

@section('javascript')
    @parent
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script type="text/javascript">
        var _chartData = {
            _days : {!! json_encode($transactionDays) !!},
            _subscriptions : {!! json_encode($subscriptionsByDay) !!},
            _transactions : {!! json_encode($transactionsByDay) !!},
            _balanceValues : {!! json_encode($balanceValues) !!}
        };
    </script>
    <script type="text/javascript" src="{{ Cms::moduleAsset('commerce', 'js/analytics.js', 'application/javascript') }}"></script>
@endsection