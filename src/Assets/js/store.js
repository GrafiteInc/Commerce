/*
|--------------------------------------------------------------------------
| Store
|--------------------------------------------------------------------------
*/

var store = {
    quarxNotify: function(info, type) {
        $('.alert').remove();
        $('body').prepend('<div class="container-fluid"><div class="alert '+ type +' alert-dismissible" role="alert">'+ info +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>');
    },

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
        var _variables = [];

        $('.product_variables').each(function(){
            _variables.push({
                'variable': $(this).find(':selected').data('variable'),
                'value': $(this).val()
            });
        });

        if ($('.product_variables').length == 0) {
            _variables = {};
        };

        $.ajax({
            type: "GET",
            url: _url+"/store/cart/add",
            data: {
                id: _id,
                variables: JSON.stringify(_variables),
                type: _type,
                quantity: _quantity
            },
            cache: false,
            dataType: "html",
            success: function(data) {
                store.quarxNotify(JSON.parse(data).data, 'alert-success');
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
                store.quarxNotify(JSON.parse(data).data, 'alert-success');
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


});