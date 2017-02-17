@extends('quarx::layouts.dashboard')

@section('content')

    <div class="row">
        <div class="raw-m-hide pull-right">
            {!! Form::open(['method' => 'get']) !!}
            <input type="number" class="form-control header-input pull-right raw-margin-right-24" name="months" placeholder="Months In History" value="{{ request()->months }}">
            {!! Form::close() !!}
        </div>
        <h1 class="page-header">Analytics: Last {{ request()->months }} @if (request()->months > 1) Months @else Month @endif</h1>
    </div>

    <div class="row">
        <div class="col-md-4">
            <h2>Transaction Balance</h2>
            <canvas id="pieGraph"></canvas>
        </div>
        <div class="col-md-8">
            <h2>Transactions &amp; Subscriptions</h2>
            <canvas id="lineGraph"></canvas>
        </div>
    </div>

    <div class="row">
        <h2 class="text-center raw-margin-bottom-24">Transaction History</h2>
        @if ($transactions->count() === 0)
            <div class="well text-center">No Transactions found.</div>
        @else
            @include('quazar::analytics.transaction-table')
        @endif
    </div>

    <div class="row">
        <h2 class="text-center raw-margin-bottom-24">Subscription History</h2>
        @if ($subscriptions->count() === 0)
            <div class="well text-center">No Subscriptions found.</div>
        @else
            @include('quazar::analytics.subscription-table')
        @endif
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
    <script type="text/javascript" src="{{ Quarx::moduleAsset('quazar', 'js/analytics.js', 'application/javascript') }}"></script>
@endsection