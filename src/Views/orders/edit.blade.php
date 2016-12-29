@extends('quarx::layouts.dashboard')

@section('content')

    <div class="modal fade" id="cancelDialog" tabindex="-3" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="refundModalLabel">Cancel Order</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to cancel this order?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a id="refundBtn" type="button" class="btn btn-warning" href="#">Confirm Cancel</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h1 class="page-header">Orders: Edit</h1>
    </div>

    @include('hadron::orders.breadcrumbs', ['location' => ['edit']])

    {!! Form::model($order, ['route' => ['quarx.orders.update', Crypto::encrypt($order->id)], 'method' => 'patch']) !!}

        <div class="row">
            <div class="col-md-12 raw-margin-bottom-24">
                <h2 class="text-center raw-margin-bottom-24">#{{ $order->uuid }} @if ($order->is_shipped) <span class="fa fa-truck"></span> @endif</h2>
                @if ($order->status == 'cancelled')
                    <div class="alert alert-danger text-center">
                        <span>Cancelled on: {{ Carbon\Carbon::parse($order->refund_date)->toFormattedDateString() }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    @foreach(json_decode($order->details) as $item)
                    <tr>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->name }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-striped">
                    @foreach(json_decode($order->shipping_address) as $address => $detail)
                    <tr>
                        <td>{{ ucfirst($address) }}</td>
                        <td>{{ $detail }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

        </div>

        {!! FormMaker::fromObject($order, [
            'tracking_number' => [
                'type' => 'string'
            ],
            'is_shipped' => [
                'type' => 'checkbox'
            ],
            'notes' => [
                'type' => 'text'
            ],
        ]) !!}

        <div class="form-group pull-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

    @if ($order->status !== 'cancelled')
        {!! Form::open(['id' => 'cancelForm', 'url' => 'quarx/orders/cancel', 'method' => 'post', 'class' => 'inline-form pull-left']) !!}
            @input_maker_create('id', ['type' => 'hidden'], $order)
            {!! Form::submit('Cancel this Order', ['class' => 'btn btn-warning']) !!}
        {!! Form::close() !!}
    @endif
@endsection

@section('javascript')
    @parent
    <script type="text/javascript">
        $(function(){
            $('#cancelForm').submit(function(e){
                e.preventDefault();
                $('#cancelDialog').modal('show');
            });

            $('#refundBtn').click(function(e){
                $('#cancelForm')[0].submit();
                $('#cancelDialog').modal('hide');
            });
        });
    </script>
@endsection
