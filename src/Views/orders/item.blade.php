@extends('quarx::layouts.dashboard')

@section('content')

    <div class="modal fade" id="cancelItemDialog" tabindex="-3" role="dialog" aria-labelledby="cancelItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="cancelItemModalLabel">Cancel an Order Item</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to cancel this item? This item will be refunded to the customer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a id="cancelItemBtn" type="button" class="btn btn-warning" href="#">Confirm Cancel Order Item</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h1 class="page-header">Order Items: Edit</h1>
    </div>

    @include('quazar::orders.breadcrumbs', ['location' => [['Order' => url(config('quarx.backend-route-prefix', 'quarx').'/orders/'.$orderItem->order_id.'/edit')], 'item']])

    <div class="row">
        <div class="col-md-12 raw-margin-bottom-24">
            <h2 class="text-center raw-margin-bottom-24">#{{ $orderItem->order->uuid }} @if ($orderItem->order->is_shipped) <span class="fa fa-truck"></span> @endif</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 raw-margin-bottom-24">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Product</th>
                        <td class="text-right"><a href="{!! route(config('quarx.backend-route-prefix', 'quarx').'.products.edit', [$orderItem->product_id]) !!}">{{ ucfirst($orderItem->product->name) }}</a></td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td class="text-right">{{ $orderItem->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Variants</th>
                        <td class="text-right">
                            @foreach($orderItem->product_variants as $variant => $value)
                                <b>{{ ucfirst($variant) }}</b>: {{ $value }}<br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6 raw-margin-bottom-24">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Subtotal</th>
                        <td class="text-right">${{ $orderItem->subtotal }}</td>
                    </tr>
                    <tr>
                        <th>Tax</th>
                        <td class="text-right">${{ $orderItem->tax }}</td>
                    </tr>
                    <tr>
                        <th>Shipping</th>
                        <td class="text-right">${{ $orderItem->shipping }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td class="text-right">${{ $orderItem->total }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="text-right">
                <a id="cancelItemForm" href="" class="btn btn-warning">Cancel Order Item</a>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    @parent
    <script type="text/javascript">
        $(function(){
            $('#cancelItemForm').click(function(e){
                e.preventDefault();
                $('#cancelItemDialog').modal('show');
            });

            $('#cancelItemBtn').click(function(e){
                $('#cancelItemForm')[0].submit();
                $('#cancelItemDialog').modal('hide');
            });
        });
    </script>
@endsection