$(function () {
    $('body').on('click', '#get-date-temp-form-submit', function () {
        $.ajax({
            method: 'POST',
            url: '/weather/temperature/find-for-date',
            data: $('.get-date-temp-form').serialize(),
            success: function (result) {
                if (result.error) {
                    $('.get-date-temp-form-result')
                        .text(result.message)
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .css('display', 'block');
                } else {
                    $('.get-date-temp-form-result')
                        .text("Temperature at " + result.data.date + " has been " +  result.data.temp)
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .css('display', 'block');
                }
            }
        })
    });

});