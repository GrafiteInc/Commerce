$(document).ready(function(){
    $('.variable-row').each(function(){
        var _variable = $(this).data('variable');
        var _row = $(this);
        $(this).children('td').children('.save-variable').click(function(){
            var _key = _row.children('td').children('.key').val();
            var _value = _row.children('td').children('.value').val();
             $.ajax({
                type: "POST",
                url: _url+"/quarx/products/variable/save",
                data: {
                    id: _variable,
                    key: _key,
                    value: _value
                },
                cache: false,
                dataType: "html",
                success: function(data){
                    gondolynNotify('Your varaible was saved', 'alert-success')
                }
            });
        });

        $(this).children('td').children('.delete-variable').click(function(){
             $.ajax({
                type: "POST",
                url: _url+"/quarx/products/variable/delete",
                data: { id: _variable },
                cache: false,
                dataType: "html",
                success: function(data){
                    gondolynNotify('Your varaible was deleted', 'alert-success')
                    _row.remove();
                }
            });
        });
    });
});