
<li class="sidebar-header"><span><span class="fa fa-bank"></span> E-Commerce</span></li>

<li class="nav-item @if (Request::is(config('cms.backend-route-prefix', 'cms').'/commerce-analytics') || Request::is(config('cms.backend-route-prefix', 'cms').'/commerce-analytics/*')) active @endif">
    <a class="nav-link" href="{{ url(config('cms.backend-route-prefix', 'cms').'/commerce-analytics') }}"><span class="fa fa-fw fa-line-chart"></span> Analytics</a>
</li>
<li class="nav-item @if (Request::is(config('cms.backend-route-prefix', 'cms').'/products') || Request::is(config('cms.backend-route-prefix', 'cms').'/products/*')) active @endif">
    <a class="nav-link" href="{{ url(config('cms.backend-route-prefix', 'cms').'/products') }}"><span class="fa fa-fw fa-archive"></span> Products</a>
</li>
<li class="nav-item @if (Request::is(config('cms.backend-route-prefix', 'cms').'/plans') || Request::is(config('cms.backend-route-prefix', 'cms').'/plans/*')) active @endif">
    <a class="nav-link" href="{{ url(config('cms.backend-route-prefix', 'cms').'/plans') }}"><span class="fa fa-fw fa-credit-card"></span> Subscription Plans</a>
</li>
<li class="nav-item @if (Request::is(config('cms.backend-route-prefix', 'cms').'/coupons') || Request::is(config('cms.backend-route-prefix', 'cms').'/coupons/*')) active @endif">
    <a class="nav-link" href="{{ url(config('cms.backend-route-prefix', 'cms').'/coupons') }}"><span class="fa fa-fw fa-ticket"></span> Coupons</a>
</li>
<li class="nav-item @if (Request::is(config('cms.backend-route-prefix', 'cms').'/transactions') || Request::is(config('cms.backend-route-prefix', 'cms').'/transactions/*')) active @endif">
    <a class="nav-link" href="{{ url(config('cms.backend-route-prefix', 'cms').'/transactions') }}"><span class="fa fa-fw fa-dollar"></span> Transactions</a>
</li>
<li class="nav-item @if (Request::is(config('cms.backend-route-prefix', 'cms').'/orders') || Request::is(config('cms.backend-route-prefix', 'cms').'/orders/*')) active @endif">
    <a class="nav-link" href="{{ url(config('cms.backend-route-prefix', 'cms').'/orders') }}"><span class="fa fa-fw fa-ship"></span> Orders</a>
</li>
