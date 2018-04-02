@extends('commerce-frontend::layouts.store')

@section('store-content')

    <div class="row">
        <h3 class="mb-4">{{ $plan->name }}</h3>

        <table class="table table-stripped">
            <tr>
                <td>
                    Price
                </td>
                <td class="text-right">
                    ${{ $plan->amount }} / {{ $plan->frequency }}
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="col-md-12">
                {!! $plan->details !!}
            </div>
        </div>
        {!! $plan->subscribeBtn('Subscribe <span class="fa fa-shopping-cart"></span>', 'btn btn-primary') !!}</span>
    </div>

@endsection
