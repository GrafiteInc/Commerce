{!! Form::model($product, ['url' => config('cms.backend-route-prefix', 'cms').'/products/discounts/'.$product->id, 'method' => 'post']) !!}

    {!! FormMaker::setColumns(2)->fromObject($product, config('commerce.forms.discounts')) !!}

    <div class="form-group text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}
