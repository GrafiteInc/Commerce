{!! Form::model($products, ['route' => ['quarx.products.update', CryptoService::encrypt($products->id)], 'method' => 'patch', 'files' => true]) !!}

    {!! FormMaker::fromObject($products, Quarx::config('forms.product')) !!}

    <div class="form-group text-right">
        <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}