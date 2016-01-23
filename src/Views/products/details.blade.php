{!! Form::model($product, ['route' => ['quarx.products.update', CryptoService::encrypt($product->id)], 'method' => 'patch', 'files' => true]) !!}

    {!! FormMaker::fromObject($product, config('hadron.details')) !!}

    <div class="form-group text-right">
        <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}