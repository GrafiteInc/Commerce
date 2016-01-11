<!--- Uuid Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('uuid', 'Uuid:') !!}
    {!! Form::text('uuid', null, ['class' => 'form-control']) !!}
</div>

<!--- Provider Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('provider', 'Provider:') !!}
    {!! Form::text('provider', null, ['class' => 'form-control']) !!}
</div>

<!--- State Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('state', 'State:') !!}
    {!! Form::text('state', null, ['class' => 'form-control']) !!}
</div>

<!--- Subtotal Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('subtotal', 'Subtotal:') !!}
    {!! Form::text('subtotal', null, ['class' => 'form-control']) !!}
</div>

<!--- Tax Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('tax', 'Tax:') !!}
    {!! Form::text('tax', null, ['class' => 'form-control']) !!}
</div>

<!--- Total Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('total', 'Total:') !!}
    {!! Form::text('total', null, ['class' => 'form-control']) !!}
</div>

<!--- Shipping Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('shipping', 'Shipping:') !!}
    {!! Form::text('shipping', null, ['class' => 'form-control']) !!}
</div>

<!--- Refund Date Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('refund_date', 'Refund Date:') !!}
    {!! Form::text('refund_date', null, ['class' => 'form-control']) !!}
</div>

<!--- Provider Id Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('provider_id', 'Provider Id:') !!}
    {!! Form::text('provider_id', null, ['class' => 'form-control']) !!}
</div>

<!--- Provider Date Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('provider_date', 'Provider Date:') !!}
    {!! Form::text('provider_date', null, ['class' => 'form-control']) !!}
</div>

<!--- Provider Dispute Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('provider_dispute', 'Provider Dispute:') !!}
    {!! Form::text('provider_dispute', null, ['class' => 'form-control']) !!}
</div>

<!--- Customer Id Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    {!! Form::text('customer_id', null, ['class' => 'form-control']) !!}
</div>

<!--- Notes Field --->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('notes', 'Notes:') !!}
    {!! Form::text('notes', null, ['class' => 'form-control']) !!}
</div>


<!--- Submit Field --->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
