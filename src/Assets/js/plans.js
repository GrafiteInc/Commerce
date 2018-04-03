function _visualizeThePlan() {
    if ($('#Name').val() > '') {
        $('.plan-title').text($('#Name').val());
    } else {
        $('.plan-title').text('Plan Name');
    }

    $('.plan-price').text(parseFloat($('#Amount').val() / 100));
    if ($('#Currency').length == 1) {
        $('.plan-currency').text($('#Currency').val().toUpperCase());
        $('.plan-interval').text($('#Interval').val().toUpperCase());
    }

    if ($('#Descriptor').val() > '') {
        $('.plan-descriptor').text($('#Descriptor').val());
    } else {
        $('.plan-descriptor').text('Credit Card Descriptor');
    }

    $('.plan-description').text($('#Description').val());
}

$('input, textarea, select').bind('change keyup', function(){
    _visualizeThePlan();
});

$(document).ready(function(){
    $(".cancel-form").submit(function(e){
        e.preventDefault();
        var _form = $(this);
        $('#cancelSubscription').modal('show');
        $('#cancelBtn').bind('click', function(){
            _form[0].submit();
            $('#cancelSubscription').modal('hide');
        });
    });

    $('#deletePlanForm').submit(function(e){
        e.preventDefault();
        $('#deletePlanDialog').modal('show');
    });

    $('#deletePlanBtn').click(function(e){
        $('#deletePlanForm')[0].submit();
        $('#deletePlanDialog').modal('hide');
    });
});