<div class="row customer-tabs">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="tabs-title {{ Request::is('store/account/profile') ? 'active' : '' }}">
            <a href="{{ url('store/account/profile') }}">Profile</a>
        </li>
        <li role="presentation" class="tabs-title {{ Request::is('store/account/card') ? 'active' : '' }}">
            <a href="{{ url('store/account/card') }}">Credit Card</a>
        </li>
    </ul>
</div>