<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavbar">
            <span class="sr-only">Home</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('/') }}">Home</a>
    </div>
    <div class="collapse navbar-collapse navbar-right" id="mainNavbar">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
            @if (Auth::user())
                <li><a href="{{ url('user/settings') }}"><span class="fa fa-user"></span> Account</a></li>
                <li><a href="{{ url('store/account/profile') }}"><span class="fa fa-user"></span> Profile</a></li>
                <li><a href="{{ url('store/account/purchases') }}"><span class="fa fa-gift"></span> Purchases</a></li>
                <li><a href="{{ url('store/account/orders') }}"><span class="fa fa-gift"></span> Orders</a></li>
                <li><a href="{{ url('store/account/subscriptions') }}"><span class="fa fa-ticket"></span> Subscriptions</a></li>
                <li><a href="{{ url('logout') }}"><span class="fa fa-sign-out"></span> Logout</a></li>
            @else
                <li><a href="{{ url('login') }}"><span class="fa fa-sign-in"></span> Login</a></li>
            @endif
        </ul>
    </div><!--/.nav-collapse -->
</div>
