<div class="row">

    <label>{{ ucfirst($variant->key) }}</label>
    <select class="form-control product_variants">
        {!! $variant->options !!}
    </select>

</div>
