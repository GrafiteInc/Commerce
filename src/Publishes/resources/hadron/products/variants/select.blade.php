<div class="row">

    <label>{{ ucfirst($variant->key) }}</label>
    <select class="form-control product_variants">
        {!! StoreHelper::variantOptions($variant) !!}
    </select>

</div>
