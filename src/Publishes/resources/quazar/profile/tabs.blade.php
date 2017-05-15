<div class="row customer-tabs">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="tabs-title {{ (Request::isRouteName('quazar.account.profile')) ? 'active' : '' }}">
            <a href="{{ route('quazar.account.profile') }}">Profile</a>
        </li>
        <li role="presentation" class="tabs-title {{ Request::isRouteName('quazar.account.card') ? 'active' : '' }}">
            <a href="{{ route('quazar.account.card') }}">Credit Card</a>
        </li>
    </ul>
</div>