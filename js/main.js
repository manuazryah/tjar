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
                var promotion_amount = $('#promotion-code-amount').val();
                $.ajax({
                        url: homeUrl + 'cart/promotion-check',
                        type: "POST",
                        data: {code: code, promotion_amount: promotion_amount},
                        success: function (data) {
                                var res = $.parseJSON(data);
                                if (res.result['msg'] == 6) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red">In order to avail the benefits of this promotional code, please Login/Sign Up.</div>');
                                } else if (res.result['msg'] == 1) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red">Invalid Code! Please try another one.</div>');
                                } else if (res.result['msg'] == 2) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red">Code validity expired !</div>');
                                } else if (res.result['msg'] == 3) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red">Sorry!! You are already used this code!</div>');
                                } else if (res.result['msg'] == 4) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red">Invalid Code! Please try another one.</div>');
                                } else if (res.result['msg'] == 5) {
                                        $("#coupon_code").after('<div class="help-block" style="color:red">This code is only when purchase items above AED  ' + res.result['amount'] + '</div>');
                                } else if (res.result['msg'] == 7) {
                                        var promo_values = $('#promotion-codes').val() + ',' + res.result['discount_id'];
                                        $('#promotion-codes').val(promo_values);
                                        $('#coupon_code').val('');
                                        $('#promotion-code-amount').val(res.result['total_promotion_amount']);
                                        $('#promotions-listing').append('<p id="disc_' + res.result['discount_id'] + '">Promotion code  ' + res.result['code'] + ' is added with ' + res.result['amount'] + 'AED <a class="promotion-remove" title="Remove" id="' + res.result['discount_id'] + '">x</a></p>')
                                        $('.cart-promotion').show();
                                        $('.promotion_discount').text(res.result['total_promotion_amount']);
                                        $('.grand_total').html(res.result['overall_grand_total'] + '<span class="woocommerce-Price-currencySymbol">AED</span>');
                                }


                        }
                });

        });
        $('.cart_qty').on('change keyup', function () {
                var promo_codes = $('#promotion-codes').val();
                $.ajax({
                        url: homeUrl + 'cart/promotion-quantity-change',
                        type: "POST",
                        data: {promo_codes: promo_codes},
                        success: function (data) {
                                var obj = $.parseJSON(data);
                                $('#promotions-listing').empty();
                                $.each(obj.promotion, function (index, value) {
                                        $('#promotions-listing').append('<p id="disc_' + value.discount_id + '">Promotion code  ' + value.code + ' is added with ' + value.amount + ' AED <a class="promotion-remove" title="Remove" id="' + value.discount_id + '">x</a></p>')
                                });
                                $('#promotion-codes').val(obj.code);
                                $('#promotion-code-amount').val(obj.promotion_total_discount);
                                $('.cart-promotion').show();
                                $('.promotion_discount').text(obj.promotion_total_discount);
                                $('.grand_total').html(obj.overall_grand_total + '<span class="woocommerce-Price-currencySymbol"> AED</span>');
                        }
                });
        });

        $(document).on('click', '.promotion-remove', function () {
                var id = $(this).attr('id');
                var promo_codes = $('#promotion-codes').val();
                $.ajax({
                        url: homeUrl + 'cart/promotion-remove',
                        type: "POST",
                        data: {id: id, promo_codes: promo_codes},
                        success: function (data) {
                                var obj = $.parseJSON(data);
                                $('#disc_' + id).remove();
                                $('#promotion-codes').val(obj.code);
                                $('#promotion-code-amount').val(obj.total_promotion_amount);
                                $('.cart-promotion').show();
                                $('.promotion_discount').text(obj.total_promotion_amount);
                                $('.grand_total').html(obj.overall_grand_total + '<span class="woocommerce-Price-currencySymbol"> AED</span>');
                        }
                });
        });

});

