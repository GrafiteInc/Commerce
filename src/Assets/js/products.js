$(document).ready(function(){
    $('.variant-row').each(function(){
        var _variant = $(this).data('variant');
        var _row = $(this);
        $(this).children('td').children('.save-variant').click(function(){
            var _key = _row.children('td').children('.key').val();
            var _value = _row.children('td').children('.value').val();
             $.ajax({
                type: "POST",
                url: _url+"/quarx/products/variant/save",
                data: {
                    _token: _token,
                    id: _variant,
                    key: _key,
                    value: _value
                },
                cache: false,
                dataType: "html",
                success: function(data){
                    quarxNotify('Your variant was saved', 'alert-success')
                }
            });
        });

        $(this).children('td').children('.delete-variant').click(function(){
             $.ajax({
                type: "POST",
                url: _url+"/quarx/products/variant/delete",
                data: { id: _variant, _token: _token },
                cache: false,
                dataType: "html",
                success: function(data){
                    quarxNotify('Your variant was deleted', 'alert-success')
                    _row.remove();
                }
            });
        });
    });
});