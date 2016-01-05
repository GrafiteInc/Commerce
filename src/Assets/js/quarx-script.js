/*
|--------------------------------------------------------------------------
| Quarx JS
|--------------------------------------------------------------------------
*/

var _redactorConfig = {
    toolbar: true,
    minHeight: 175,
    convertVideoLinks: true,
    imageUpload: true,
    buttonSource: true,
    replaceDivs: false,
    pastePlaintext: true,
    deniedTags: ['script'],
    imageManagerJson: _url+'/quarx/api/images/list',
    // fileManagerJson: _url+'/quarx/images/api/list',
    fileCategoriesManagerJson: _url+'files/api/all_categories',
    plugins: ['table','video','imagemanager','specialchar'],
    buttons: ['html', 'formatting', 'bold', 'italic', 'underline', 'deleted', 'unorderedlist', 'orderedlist',
          'outdent', 'indent', 'image', 'video', 'link', 'alignment', 'horizontalrule'], // + 'underline'
};

$(window).load(function() {

    $('.pull-down').each(function() {
        var height = 300 - $(this).siblings('.thumbnail').height() - $(this).height() - 48;
        $(this).css('margin-top', height);
    });

    $('textarea.redactor').redactor(_redactorConfig);
});

$(function(){
    function _urlPrepare (title) {
        return title.replace(/[^\w\s]/gi, '').replace(/ /g, '-').toLowerCase();
    }

    $('#Title, #Name').bind('keyup', function() {
        $('#Url').val(_urlPrepare($(this).val()));
    });

    $('.timepicker').datetimepicker({ format: 'LT' });
    $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('.tags').tagsinput();
});
