$(document).ready(function () {
        $('.review-success').hide();
        $(document).on('submit', '#add-review-form', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                        type: 'POST',
                        url: homeUrl + 'products/add-review',
                        data: data,
                        success: function (data) {
                                $('#add-review-form')[0].reset();
                                $('#addreview').css({'display': 'none'});
                                $('.review-success').show();
                                $('.review-success').delay(4000).fadeOut();
                        }
                });
        });


        $('.language-choose').on('click', function () {
                var language = $(this).attr('id');
                $.ajax({
                        type: 'POST',
                        url: homeUrl + 'ajax/language',
                        data: {language: language},
                        success: function (data) {
                                location.reload();
                        }
                });
        });

        /********************Promotion Codes ***************/
        $('.apply-coupen').on('click', function (e) {
                e.preventDefault();
                var code = $('#coupon_code').val();
                $.ajax({
                        url: homeUrl + 'cart/promotion-check',
                        type: "POST",
                        data: {code: code},
                        success: function (data) {
                                if (data == 1) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red">Invalid Code! Please try another one.</div>');
                                } else if (data == 2) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red"> Code validity expired !</div>');

                                } else if (data == 3) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red"> Sorry!! You are already used this code!</div>');

                                } else if (data == 4) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red"> Invalid Code! Please try another one.</div>');

                                } else if (data == 5) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red"> Sorry!! You are already used this code!</div>');

                                } else {
                                        var res = $.parseJSON(data);
                                        if (res.result['con'] == 1) {
                                                location.reload();
                                        } else {
                                                $(".promotion-code").after('<div class="help-block" style="color:red"> This code is only when purchase items above AED  ' + res.result['amount'] + '</div>');
                                        }
                                }

                        }
                });

        });

});