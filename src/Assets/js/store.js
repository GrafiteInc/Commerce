function _visualizeThePlan() {
    $('.plan-title').text($('#Name').val());
    $('.plan-price').text(parseFloat($('#Amount').val() / 100));
    $('.plan-currency').text($('#Currency').val().toUpperCase());
    $('.plan-interval').text($('#Interval').val().toUpperCase());
    $('.plan-slogan').text($('#Slogan').val());
    $('.plan-descriptor').text($('#Descriptor').val());
    $('.plan-description').text($('#Description').val());
}

$('input').bind('change keyup', function(){
    _visualizeThePlan();
});

_visualizeThePlan();
