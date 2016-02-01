$(function($) {
    $('#userPayment').submit(function(event) {
        var $form = $(this);
        $form.find('button').prop('disabled', true);

        var _month = $("#expiry").val().substring(0, 2);
        var _year = $("#expiry").val().substring($("#expiry").val().indexOf("/")+2, $("#expiry").val().length);

        $('#exp_month').val(_month);
        $('#exp_year').val(_year);

        $('#userPayment').submit();
    });

    $('#userPayment').card({ container: $('.card-wrapper') });

    $("#lastCardBtn").click(function(e){
        e.preventDefault();
        $('#userPayment').attr('action', _url+'/store/process/last-card');
        $('#userPayment')[0].submit();
    });
});
