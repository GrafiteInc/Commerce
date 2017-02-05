<table class="table table-stripped">
    <thead>
        <td>Name</td>
        <td>Code</td>
        <td>Price</td>
        <td class="text-right">Quantity</td>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr data-cart-row="{!! $product->cart_id !!}">
                <td>
                    <a href="{{ $product->href }}">{!! $product->name !!}</a>
                    {!! $product->detailsBtn() !!}
                </td>
                <td>{!! $product->code !!}</td>
                <td>{!! $product->price !!}</td>
                <td class="text-right">{!! $product->quantity !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="table table-stripped">
    <tr class="text-right">
        <td>Shipping <span class="shipping-choice"></span></td>
        <td>{!! StoreHelper::checkoutShipping() !!}</td>
    </tr>
    <tr class="text-right">
        <td>Tax</td>
        <td>{!! StoreHelper::checkoutTax() !!}</td>
    </tr>
    <tr class="text-right">
        <td>Subtotal</td>
        <td>{!! StoreHelper::checkoutSubtotal() !!}</td>
    </tr>
    <tr class="text-right">
        <td>Total</td>
        <td>{!! StoreHelper::checkoutTotal() !!}</td>
    </tr>
</table>