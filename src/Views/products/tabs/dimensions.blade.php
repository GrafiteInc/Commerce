{!! Form::model($product, ['url' => 'quarx/products/dimensions/'.$product->id, 'method' => 'post']) !!}

    {!! FormMaker::fromObject($product, Quarx::moduleConfig('quazar', 'dimensions')) !!}

    <div class="form-group text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}