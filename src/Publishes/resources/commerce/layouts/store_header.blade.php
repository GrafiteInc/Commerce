<div class="store-header">
    <h2><a href="{!! route('commerce.home') !!}">{{ config('commerce.name', 'My Store') }}</a></h2>

    <div class="store-account" id="storeNavbar">
        <a class="btn btn-link" href="{{ route('commerce.products') }}">Products</a>
        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Account <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
            @if (auth()->user())
                <li><a href="{{ url('user/settings') }}"><span class="fa fa-user"></span> Settings</a></li>
                <li><a href="{{ route('commerce.account.profile') }}"><span class="fa fa-id-card"></span> Profile</a></li>
                <li><a href="{{ route('commerce.account.purchases') }}"><span class="fa fa-dollar"></span> Purchases</a></li>
                <li><a href="{{ route('commerce.account.orders') }}"><span class="fa fa-truck"></span> Orders</a></li>
                <li><a href="{{ route('commerce.account.subscriptions') }}"><span class="fa fa-ticket"></span> Subscriptions</a></li>
                <li><a href="{{ url('logout') }}"><span class="fa fa-sign-out"></span> Logout</a></li>
            @else
                <li><a href="{{ url('login') }}"><span class="fa fa-sign-in"></span> Login</a></li>
            @endif
        </ul>
    </div>
    <div class="store-menu">
        <a href="{!! route('commerce.cart.contents') !!}">
            <span class="fa fa-shopping-cart"></span>
            <span class="cart-count"></span> Items
        </a>
    </div>
</div>