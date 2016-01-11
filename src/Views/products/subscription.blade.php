{!! Form::model($product, ['url' => 'quarx/products/subscription/'.CryptoService::encrypt($product->id), 'method' => 'post']) !!}

<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="Frequency">Frequency</label>
            <select name="frequency" class="form-control">
                <option value="Weekly">Weekly</option>
                <option value="Monthly">Monthly</option>
                <option value="Yearly">Yearly</option>
            </select>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="SignUp">Sign up Fee</label>
            <input id="SignUp" class="form-control" type="text" name="signupfee" placeholder="SignUp Fee (&cent;)">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="Trial">Free Trial (Days)</label>
            <input id="Trial" class="form-control" type="text" name="trialDays" placeholder="Free Trial (Days)">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="Limit">Limit Per Customer</label>
            <input id="Limit" class="form-control" type="text" name="limit" placeholder="Limit Per Customer">
        </div>
    </div>
</div>
<div class="form-group text-right">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}
