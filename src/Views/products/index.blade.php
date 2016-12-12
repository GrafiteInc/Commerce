@extends('quarx::layouts.dashboard')

@section('content')

    <div class="modal fade" id="deleteModal" tabindex="-3" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="deleteModalLabel">Delete Products</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a id="deleteBtn" type="button" class="btn btn-warning" href="#">Confirm Delete</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <a class="btn btn-primary pull-right" href="{!! route('quarx.products.create') !!}">Add New</a>
        <div class="raw-m-hide pull-right">
            {!! Form::open(['url' => 'quarx/products/search']) !!}
            <input class="form-control header-input pull-right raw-margin-right-24" name="term" placeholder="Search">
            {!! Form::close() !!}
        </div>
        <h1 class="page-header">Products</h1>
    </div>

    <div class="row">
        @if (isset($term))
        <div class="well text-center">Searched for "{!! $term !!}".</div>
        @endif
        @if($products->count() === 0)
            <div class="well text-center">No Products found.</div>
        @else
            <table class="table table-striped">
                <thead>
                    <th>Name</th>
                    <th class="raw-m-hide">Code</th>
                    <th class="raw-m-hide">Price</th>
                    <th class="raw-m-hide">Stock</th>
                    <th class="raw-m-hide">Available</th>
                    <th class="raw-m-hide">Is Published</th>
                    <th class="raw-m-hide">Is Downloaded</th>
                    <th width="200px" class="text-right">Action</th>
                </thead>
                <tbody>

                @foreach($products as $product)
                    <tr>
                        <td>{!! $product->name !!}</td>
                        <td class="raw-m-hide">{!! $product->code !!}</td>
                        <td class="raw-m-hide">${!! $product->price !!}</td>
                        <td class="raw-m-hide">{!! $product->stock !!}</td>
                        <td class="raw-m-hide">
                            @if ($product->is_available)
                            <span class="fa fa-check"></span>
                            @endif
                        </td>
                        <td class="raw-m-hide">
                            @if ($product->is_published)
                            <span class="fa fa-check"></span>
                            @endif
                        </td>
                        <td class="raw-m-hide">
                            @if ($product->is_download)
                            <a href="{!! URL::to(FileService::fileAsDownload($product->name, $product->file)) !!}" target="_blank"><span class="fa fa-download"></span> Download</a>
                            @else
                            <span class="fa fa-close"></span>
                            @endif
                        </td>
                        <td class="text-right">
                            <form method="post" action="{!! url('quarx/product/'.$product->id) !!}">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <button class="delete-btn btn btn-xs btn-danger pull-right" type="submit"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                            <a class="btn btn-xs btn-default pull-right raw-margin-right-8" href="{!! route('quarx.products.edit', [$product->id]) !!}"><i class="fa fa-pencil"></i> Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="text-center">
        {!! $pagination !!}
    </div>

@endsection
