<table class="table table-stripped mb-4">
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
                <td>${!! $product->price !!}</td>
                <td class="text-right">{!! $product->quantity !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="table table-stripped mt-4">
    <tr>
        <td><b>Shipping</b> <span class="shipping-choice"></span></td>
        <td class="text-right">${!! StoreHelper::checkoutShipping() !!}</td>
    </tr>
    <tr>
        <td><b>Tax</b></td>
        <td class="text-right">${!! StoreHelper::checkoutTax() !!}</td>
    </tr>
    <tr>
        <td><b>Subtotal</b></td>
        <td class="text-right">${!! StoreHelper::checkoutSubtotal() !!}</td>
    </tr>
    <tr>
        <td><b>Total</b></td>
        <td class="text-right">${!! StoreHelper::checkoutTotal() !!}</td>
    </tr>
</table>