<div class="row">
    <div class="col-md-12">
        <form id="couponForm" method="post" action="{{ route('commerce.coupon') }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="coupon">Coupon Code</label>
                <div class="input-group">
                    <input id="coupon" class="form-control" type="text" name="coupon" placeholder="Coupon Code" value="{{ Session::get('coupon_code') }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Apply</button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
