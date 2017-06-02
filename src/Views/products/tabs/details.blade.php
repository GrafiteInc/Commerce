{!! Form::model($product, ['route' => [config('quarx.backend-route-prefix', 'quarx').'.products.update', $product->id], 'method' => 'patch', 'files' => true]) !!}

    {!! FormMaker::fromObject($product, config('quazar.forms.details')) !!}

    <div class="form-group text-right">
        <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}