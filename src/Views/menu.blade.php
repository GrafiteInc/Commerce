
<li class="sidebar-header"><span><span class="fa fa-bank"></span> E-Commerce</span></li>

<li class="@if (Request::is(config('quarx.backend-route-prefix', 'quarx').'/commerce-analytics') || Request::is(config('quarx.backend-route-prefix', 'quarx').'/commerce-analytics/*')) active @endif">
    <a href="{{ url(config('quarx.backend-route-prefix', 'quarx').'/commerce-analytics') }}"><span class="fa fa-line-chart"></span> Analytics</a>
</li>
<li class="@if (Request::is(config('quarx.backend-route-prefix', 'quarx').'/products') || Request::is(config('quarx.backend-route-prefix', 'quarx').'/products/*')) active @endif">
    <a href="{{ url(config('quarx.backend-route-prefix', 'quarx').'/products') }}"><span class="fa fa-archive"></span> Products</a>
</li>
<li class="@if (Request::is(config('quarx.backend-route-prefix', 'quarx').'/plans') || Request::is(config('quarx.backend-route-prefix', 'quarx').'/plans/*')) active @endif">
    <a href="{{ url(config('quarx.backend-route-prefix', 'quarx').'/plans') }}"><span class="fa fa-credit-card"></span> Subscription Plans</a>
</li>
<li class="@if (Request::is(config('quarx.backend-route-prefix', 'quarx').'/transactions') || Request::is(config('quarx.backend-route-prefix', 'quarx').'/transactions/*')) active @endif">
    <a href="{{ url(config('quarx.backend-route-prefix', 'quarx').'/transactions') }}"><span class="fa fa-dollar"></span> Transactions</a>
</li>
<li class="@if (Request::is(config('quarx.backend-route-prefix', 'quarx').'/orders') || Request::is(config('quarx.backend-route-prefix', 'quarx').'/orders/*')) active @endif">
    <a href="{{ url(config('quarx.backend-route-prefix', 'quarx').'/orders') }}"><span class="fa fa-ship"></span> Orders</a>
</li>
