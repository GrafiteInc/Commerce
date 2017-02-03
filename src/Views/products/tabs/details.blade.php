{!! Form::model($product, ['route' => ['quarx.products.update', $product->id], 'method' => 'patch', 'files' => true]) !!}

    {!! FormMaker::fromObject($product, Quarx::moduleConfig('quazar', 'details')) !!}

    <div class="form-group text-right">
        <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}