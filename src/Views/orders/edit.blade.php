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
                    <p>Are you sure want to cancel this order? This will refund the customer's transaction.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a id="cancelBtn" type="button" class="btn btn-warning" href="#">Confirm Cancel</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h1 class="page-header">Orders: Edit</h1>
    </div>

    @include('quazar::orders.breadcrumbs', ['location' => ['edit']])

    {!! Form::model($order, ['route' => [config('quarx.backend-route-prefix', 'quarx').'.orders.update', $order->id], 'method' => 'patch']) !!}

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
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    @foreach($order->items as $item)
                    <tr>
                        <td><a href="{{ url(config('quarx.backend-route-prefix', 'quarx').'/orders/item/'.$item->id) }}">{{ $item->product->name }}</a></td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->total }}</td>
                        <td class="text-right">
                            <a href="{{ url(config('quarx.backend-route-prefix', 'quarx').'/orders/item/'.$item->id) }}" class="btn btn-xs btn-default">Review</a>
                        </td>
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
            'status' => [
                'type' => 'string'
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
        {!! Form::open(['id' => 'cancelForm', 'url' => config('quarx.backend-route-prefix', 'quarx').'/orders/cancel', 'method' => 'post', 'class' => 'inline-form pull-left']) !!}
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

            $('#cancelBtn').click(function(e){
                $('#cancelForm')[0].submit();
                $('#cancelDialog').modal('hide');
            });
        });
    </script>
@endsection
