<div class="row customer-tabs">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="tabs-title {{ (Request::isRouteName('commerce.account.profile')) ? 'active' : '' }}">
            <a href="{{ route('commerce.account.profile') }}">Profile</a>
        </li>
        <li role="presentation" class="tabs-title {{ Request::isRouteName('commerce.account.card') ? 'active' : '' }}">
            <a href="{{ route('commerce.account.card') }}">Credit Card</a>
        </li>
        <li role="presentation" class="tabs-title {{ Request::is('store/account/coupon') ? 'active' : '' }}">
            <a href="{{ url('store/account/coupon') }}">Coupon</a>
        </li>
    </ul>
</div>