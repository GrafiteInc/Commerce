{!! Form::model($product, ['url' => config('cms.backend-route-prefix', 'cms').'/products/dimensions/'.$product->id, 'method' => 'post']) !!}

    {!! FormMaker::fromObject($product, config('commerce.forms.dimensions')) !!}

    <div class="form-group text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}