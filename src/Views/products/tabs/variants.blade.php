{!! Form::model($product, ['url' => config('cms.backend-route-prefix', 'cms').'/products/variants/'.$product->id, 'method' => 'post']) !!}

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="control-label" for="Key">Key</label>
                <input id="Key" class="form-control" type="text" name="key" placeholder="Key">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="control-label" for="Value">Value</label>
                <input id="Value" class="form-control" type="text" name="value" placeholder="Value - separated by | (+price) [+weight]">
            </div>
        </div>
    </div>
    <div class="form-group text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}

<div class="row raw-margin-bottom-24">
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <th>Key</th>
                <th>Value</th>
                <th class="text-right">Actions</th>
            </thead>
            <tbody>
            @foreach ($productVariants as $variant)
                <tr data-variant="{!! $variant->id !!}" class="variant-row">
                    <td><input class="key form-control" value="{!! $variant->key !!}"></td>
                    <td><input class="value form-control" value="{!! $variant->value !!}"></td>
                    <td class="text-right">
                        <button class="save-variant btn btn-primary"><span class="fa fa-save"></span></button>
                        <button class="delete-variant btn btn-danger"><span class="fa fa-remove"></span></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
