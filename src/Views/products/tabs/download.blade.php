{!! Form::model($product, ['url' => config('cms.backend-route-prefix', 'cms').'/products/download/'.$product->id, 'method' => 'post', 'files' => true]) !!}

    <div class="row">
        <div class="col-lg-6">
            <a class="btn btn-default raw-margin-top-24" href="{!! url(app(FileService::class)->fileAsDownload($product->file, $product->file)) !!}">Download File</a>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="control-label" for="productFile">File</label>
                <input id="productFile" class="form-control" type="file" name="file" placeholder="Product File">
            </div>
        </div>
    </div>
    <div class="form-group text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}
