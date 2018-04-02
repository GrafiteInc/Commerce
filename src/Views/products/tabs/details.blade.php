{!! Form::model($product, ['route' => [config('cms.backend-route-prefix', 'cms').'.products.update', $product->id], 'method' => 'patch', 'files' => true]) !!}

    {!! FormMaker::setColumns(2)->fromObject($product, config('commerce.forms.details.identity')) !!}
    {!! FormMaker::setColumns(2)->fromObject($product, config('commerce.forms.details.price')) !!}

    <div class="row">
        <div class="col-md-6">
            {!! FormMaker::setColumns(1)->fromObject($product, config('commerce.forms.details.content')) !!}
        </div>
        <div class="col-md-6 raw-margin-bottom-24">
            @if ($product->hero_image)
                <img class="img-thumbnail img-fluid" style="display: inline-block;" src="{{ $product->hero_image_url }}" />
            @endif
        </div>
    </div>

    {!! FormMaker::setColumns(2)->fromObject($product, config('commerce.forms.details.seo')) !!}
    {!! FormMaker::setColumns(2)->fromObject($product, config('commerce.forms.details.options')) !!}

    <div class="form-group text-right">
        <a href="{!! URL::previous() !!}" class="btn btn-secondary float-left">Cancel</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}