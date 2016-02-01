{!! Form::model($product, ['url' => 'quarx/products/subscription/'.CryptoService::encrypt($product->id), 'method' => 'post']) !!}

<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="Frequency">Frequency</label>
            <select name="subscription_frequency" class="form-control">
                @foreach (['Weekly', 'Monthly', 'Yearly'] as $frequency)
                    <option  @if($product->subscription_frequency == $frequency) selected @endif value="{!! $frequency !!}">{!! $frequency !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="SignUp">Sign up Fee</label>
            <input id="SignUp" class="form-control" type="text" name="subscription_signup_fee" placeholder="SignUp Fee (&cent;)" value="{!! $product->subscription_signup_fee !!}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="Trial">Free Trial (Days)</label>
            <input id="Trial" class="form-control" type="text" name="subscription_free_trial" placeholder="Free Trial (Days)" value="{!! $product->subscription_free_trial !!}">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="Limit">Limit Per Customer</label>
            <input id="Limit" class="form-control" type="text" name="subscription_per_customer" placeholder="Limit Per Customer" value="{!! $product->subscription_per_customer !!}">
        </div>
    </div>
</div>
<div class="form-group text-right">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}
