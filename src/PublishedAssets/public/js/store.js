/*
|--------------------------------------------------------------------------
| Store
|--------------------------------------------------------------------------
*/

var store = {
    updateCartCount: function(_id) {
        $.ajax({
            type: "GET",
            url: _url+"/store/cart/count",
            cache: false,
            dataType: "html",
            success: function(data){
                $('.cart-count').html(JSON.parse(data).data);
            }
        });
    },

    addToCart: function(_id, _quantity, _type) {
        var _variants = [];

        $('.product_variants').each(function(){
            _variants.push({
                'variant': $(this).find(':selected').data('variant'),
                'value': $(this).val()
            });
        });

        if ($('.product_variants').length == 0) {
            _variants = {};
        };

        $.ajax({
            type: "GET",
            url: _url+"/store/cart/add",
            data: {
                id: _id,
                variants: JSON.stringify(_variants),
                type: _type,
                quantity: _quantity
            },
            cache: false,
            dataType: "html",
            success: function(data) {
                store.updateCartCount();
            }
        });
    },

    removeFromCart: function(_id, _type) {
        $.ajax({
            type: "GET",
            url: _url+"/store/cart/remove",
            data: { id: _id, type: _type },
            cache: false,
            dataType: "html",
            success: function(data) {
                $('tr[data-cart-row="'+_id+'"]').remove();
                store.updateCartCount();
            }
        });
    },

    changeItemQuantity: function(_id, _count) {
        $.ajax({
            type: "GET",
            url: _url+"/store/cart/change-count",
            data: {
                id: _id,
                count: _count
            },
            cache: false,
            dataType: "html",
            success: function(data){
                store.updateCartCount();
            }
        });
    }
}

$(document).ready(function(){

    store.updateCartCount();

    $('.product-count').bind('change', function(){
        var _product = $(this).data('product');
        var _count = $(this).val();

        store.changeItemQuantity(_product, _count);
    });

    $('.details').popover({ html : true });

    $('.cart-subtract').bind('click', function(){
        var _productCount = $(this).siblings('.product-count');
        var _product = _productCount.data('product');
        var _count = _productCount.val();
        _count--;
        if (_count < 0) {
            _count = 0;
        };
        _productCount.val(_count);
        store.changeItemQuantity(_product, _count);
    });

    $('.cart-add').bind('click', function(){
        var _productCount = $(this).siblings('.product-count');
        var _product = _productCount.data('product');
        var _count = _productCount.val();
        _count++;
        _productCount.val(_count);
        store.changeItemQuantity(_product, _count);
    });

});