{!! Form::model($product, ['url' => 'quarx/products/dimensions/'.$product->id, 'method' => 'post']) !!}

    {!! FormMaker::fromObject($product, config('quazar.forms.dimensions')) !!}

    <div class="form-group text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}