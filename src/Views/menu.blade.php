
<li class="sidebar-header"><span><span class="fa fa-bank"></span> E-Commerce</span></li>

<li class="@if (Request::is('quarx/products') || Request::is('quarx/products/*')) active @endif">
    <a href="<?= URL::to('quarx/products'); ?>"><span class="fa fa-archive"></span> Products</a>
</li>
<li class="@if (Request::is('quarx/plans') || Request::is('quarx/plans/*')) active @endif">
    <a href="<?= URL::to('quarx/plans'); ?>"><span class="fa fa-credit-card"></span> Subscription Plans</a>
</li>
<li class="@if (Request::is('quarx/transactions') || Request::is('quarx/transactions/*')) active @endif">
    <a href="<?= URL::to('quarx/transactions'); ?>"><span class="fa fa-dollar"></span> Transactions</a>
</li>
<li class="@if (Request::is('quarx/orders') || Request::is('quarx/orders/*')) active @endif">
    <a href="<?= URL::to('quarx/orders'); ?>"><span class="fa fa-ship"></span> Orders</a>
</li>
<li class="@if (Request::is('quarx/commerce-analytics') || Request::is('quarx/commerce-analytics/*')) active @endif">
    <a href="<?= URL::to('quarx/commerce-analytics'); ?>"><span class="fa fa-line-chart"></span> Analytics</a>
</li>
