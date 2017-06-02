{!! Form::model($product, ['url' => config('quarx.backend-route-prefix', 'quarx').'/products/discounts/'.$product->id, 'method' => 'post']) !!}

    {!! FormMaker::fromObject($product, config('quazar.forms.discounts')) !!}

    <div class="form-group text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}
