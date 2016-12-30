<div class="row">
    <h1>Customer Profile</h1>

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="tabs-title {{ Request::is('store/account/profile') ? 'active' : '' }}">
            <a href="{{ url('store/account/profile') }}">Profile</a>
        </li>
        <li role="presentation" class="tabs-title {{ Request::is('store/account/card') ? 'active' : '' }}">
            <a href="{{ url('store/account/card') }}">Credit Card</a>
        </li>
        <li role="presentation" class="tabs-title {{ Request::is('store/account/upcoming') ? 'active' : '' }}">
            <a href="{{ url('store/account/upcoming') }}">Upcoming Invoice</a>
        </li>
    </ul>
</div>