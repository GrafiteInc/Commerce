<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavbar">
            <span class="sr-only">Home</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ URL::to('/') }}">Home</a>
    </div>
    <div class="collapse navbar-collapse navbar-right" id="mainNavbar">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-bars"></span> Menu <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    @if (Auth::user())
                        <li><a href="{{ URL::to('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
                        <li><a href="{{ URL::to('account/settings') }}"><span class="fa fa-user"></span> Account</a></li>
                        <li><a href="{{ URL::to('store/account/orders') }}"><span class="fa fa-user"></span> Orders</a></li>
                        <li><a href="{{ URL::to('store/account/subscriptions') }}"><span class="fa fa-user"></span> Subscriptions</a></li>
                        <li><a href="{{ URL::to('logout') }}"><span class="fa fa-sign-out"></span> Logout</a></li>
                    @else
                        <li><a href="{{ URL::to('login') }}"><span class="fa fa-sign-in"></span> Login</a></li>
                    @endif
                </ul>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
</div>
