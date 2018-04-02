/*
|--------------------------------------------------------------------------
| Store
|--------------------------------------------------------------------------
*/

var store = {

    url: 'store',

    cart: {
        contents: [],
        count: 0,
        subtotal: 0,
        shipping: 0,
        total: 0,
    },

    init: function () {
        this.updateCartCount();
        this.updateCart();
    },

    updateCart: function () {
        var _store = this;
        $.ajax({
            type: "GET",
            url: _url+"/"+_store.url+"/cart",
            cache: false,
            dataType: "html",
            success: function(data){
                _store.cart = JSON.parse(data).data;
            }
        });
    },

    updateCartCount: function(_id) {
        var _store = this;
        $.ajax({
            type: "GET",
            url: _url+"/"+_store.url+"/cart/count",
            cache: false,
            dataType: "html",
            success: function(data){
                _store.cart.count = JSON.parse(data).data;
                $('.cart-count').html(JSON.parse(data).data);
            }
        });
    },

    favoriteToggle: function(_id, _button, _content, _isFavorite, _isNotFavorite) {
        var _store = this;
        $.ajax({
            type: "GET",
            url: $(_button).attr('data-url'),
            cache: false,
            dataType: "html",
            success: function(data) {
                var _response = JSON.parse(data);
                if (_response.data == 1) {
                    var _requestUrl = _url+"/"+_store.url+"/favorites/remove/"+_id;
                    $(_button).html(_content + ' ' + _isFavorite)
                } else {
                    var _requestUrl = _url+"/"+_store.url+"/favorites/add/"+_id;
                    $(_button).html(_content + ' ' + _isNotFavorite)
                }

                $(_button).attr('data-url', _requestUrl);
            }
        });
    },

    addToCart: function(_id, _quantity, _type) {
        var _variants = [];
        var _store = this;

        $('.product_variants').each(function(){
            _variants.push({
                'variant': $(this).find(':selected').data('variant'),
                'value': $(this).val()
            });
        });

        if ($('.product_variants').length == 0) {
            _variants = {};
        };

        var _product = {
            id: _id,
            variants: JSON.stringify(_variants),
            type: _type,
            quantity: _quantity
        };

        $.ajax({
            type: "GET",
            url: _url+"/"+_store.url+"/cart/add",
            data: _product,
            cache: false,
            dataType: "html",
            success: function (data) {
                _store.updateCartCount();
                _store.updateCart();
                _store.cart.contents.push(_product);
            }
        });
    },

    removeFromCart: function(_id, _type) {
        var _store = this;
        $.ajax({
            type: "GET",
            url: _url+"/"+_store.url+"/cart/remove",
            data: { id: _id, type: _type },
            cache: false,
            dataType: "html",
            success: function (data) {
                $('tr[data-cart-row="'+_id+'"]').remove();
                _store.updateCartCount();
                _store.updateCart();
            }
        });
    },

    changeItemQuantity: function(_id, _count) {
        var _store = this;
        $.ajax({
            type: "GET",
            url: _url+"/"+_store.url+"/cart/change-count",
            data: {
                id: _id,
                count: _count
            },
            cache: false,
            dataType: "html",
            success: function(data){
                _store.updateCartCount();
                _store.updateCart();
            }
        });
    }
}

$(document).ready(function(){

    store.init();

    $('.product-count').bind('change', function(){
        var _product = $(this).data('product');
        var _count = $(this).val();

        store.changeItemQuantity(_product, _count);
    });

    $('.details').popover({ html : true });

    $('.cart-subtract').bind('click', function(){
        var _productCount = $(this).parent().siblings('.product-count');
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
        var _productCount = $(this).parent().siblings('.product-count');
        var _product = _productCount.data('product');
        var _count = _productCount.val();
        _count++;
        _productCount.val(_count);
        store.changeItemQuantity(_product, _count);
    });

    $('.dropdown-toggle').dropdown();
});