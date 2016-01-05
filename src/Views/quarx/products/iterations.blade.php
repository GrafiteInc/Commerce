{!! Form::model($products, ['url' => 'quarx/products/iterations/'.CryptoService::encrypt($products->id), 'method' => 'post', 'files' => true]) !!}

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label class="control-label" for="Key">Name</label>
                <input id="name" class="form-control" type="text" name="key" placeholder="Name">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label class="control-label" for="Value">Start Date</label>
                <input id="start_date" class="form-control datepicker" type="text" name="start_date" placeholder="Start Date">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label class="control-label" for="Value">End Date</label>
                <input id="end_date" class="form-control datepicker" type="text" name="end_date" placeholder="End Date">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label class="control-label" for="Value">Limit</label>
                <input id="limit" class="form-control" type="number" name="limit" placeholder="Limit">
            </div>
        </div>
    </div>

    <div class="row">
        <h3 class="text-center">Contents</h3>

        @if ($products->is_download)
            <div class="table-form">
                <div class="form-group">
                    <input class="form-control" name="" type="file" placeholder="File" />
                </div>
            </div>
        @else
            <table class="table table-form table-striped">
                <thead>
                    <th>Quantity</th>
                    <th>HS Code</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Weight</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <td><input class="form-control input-sm" name="" type="number" placeholder="Quantity" /></td>
                    <td><input class="form-control input-sm" name="" type="text" placeholder="HS Code" /></td>
                    <td><input class="form-control input-sm" name="" type="text" placeholder="Description" /></td>
                    <td><input class="form-control input-sm" name="" type="number" placeholder="Price" /></td>
                    <td><input class="form-control input-sm" name="" type="weight" placeholder="Weight" /></td>
                    <td><button class="btn btn-sm btn-primary raw-right"><i class="fa fa-plus"></i> Add Item</button></td>
                </tbody>
            </table>
        @endif

    </div>

    <div class="form-group text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}

<div class="row">
    <table class="table table-striped">
        <thead>
            <th>Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Limit</th>
            <th class="text-right">Actions</th>
        </thead>
        <tbody>
        @foreach ($productIterations as $iteration)
            <tr data-iteration="{!! $iteration->id !!}" class="iteration-row">
                <td><input disabled class="key form-control" value="{!! $iteration->name !!}"></td>
                <td><input disabled class="value form-control" value="{!! $iteration->start_date !!}"></td>
                <td><input disabled class="value form-control" value="{!! $iteration->end_date !!}"></td>
                <td><input disabled class="value form-control" value="{!! $iteration->limit !!}"></td>
                <td class="text-right">
                    <button class="edit-iteration btn btn-default"><span class="fa fa-pencil"></span></button>
                    <button class="delete-iteration btn btn-danger"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
