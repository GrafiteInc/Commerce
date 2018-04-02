<div class="modal fade" id="deleteModal" tabindex="-3" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel">Delete Images</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this image?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="deleteBtn" class="btn btn-danger" href="#">Confirm Delete</a>
            </div>
        </div>
    </div>
</div>

<div class="row raw-margin-bottom-48">
    @foreach($images as $image)
        <div class="col-md-3 image-panel raw-margin-top-24">
            <div class="thumbnail">
                <a href="{!! route(config('cms.backend-route-prefix', 'cms').'.images.edit', [$image->id]) !!}">
                    <div class="img" style="background-image: url('{!! $image->url !!}')"></div>
                </a>
            </div>
            <div data-id="{{ $image->id }}" class="well pull-down overflow-hidden">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        @if ($image->is_published)
                            <span clas="float-left"><span class="float-left fa fa-check raw-margin-right-8"></span> Published</span>
                        @else
                            <span clas="float-left"><span class="float-left fa fa-close raw-margin-right-8"></span> Published</span>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <form method="post" action="{!! url(config('cms.backend-route-prefix', 'cms').'/products/images/'.$image->id) !!}">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button class="delete-btn btn btn-sm img-alter-btn btn-danger float-right" type="submit"><i class="fa fa-trash"></i></button>
                        </form>
                        <a class="btn btn-sm btn-secondary float-right img-alter-btn raw-margin-right-8" href="{!! route(config('cms.backend-route-prefix', 'cms').'.images.edit', [$image->id]) !!}"><i class="fa fa-edit"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


<div class="row">
    <div class="col-md-12">
        {!! Form::open(['url' => 'cms/images/upload', 'files' => true, 'class' => 'dropzone', 'id' => 'fileDropzone']); !!}
        {!! Form::close() !!}

        {!! Form::open(['url' => config('cms.backend-route-prefix', 'cms').'/products/images', 'files' => true, 'id' => 'fileDetailsForm', 'class' => 'add']) !!}

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="form-group text-right">
                <a href="{!! url(config('cms.backend-route-prefix', 'cms').'/images') !!}" class="btn btn-secondary raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary', 'id' => 'saveImagesBtn']) !!}
            </div>

        {!! Form::close() !!}
    </div>
</div>