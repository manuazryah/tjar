$(document).ready(function () {
        getcartcount();
//    getcarttotal();
//    getcartdata();
        $(".add_to_cart").click(function () {
                showLoader();
                $(".shopping-cart").css("display", "none");
//        $("html, body").animate({
//            scrollTop: 0
//        }, 1500);
                var vendor_prdct = $(this).attr('id');
//        var qty = $('.q_ty').val();
                var qty = '1';
                addtocart(vendor_prdct, qty, 'add_to');
        });
        $('body').on('change keyup', '.cart_qty', function () {
                showLoader();
                var quantity = this.value;
                var $ids = $(this).attr('id');
                var $count = $('#cart_count').val();
//        console.log($ids);
                if (quantity != '' && parseInt(quantity) > '0') {
                        findstock($ids, quantity);
                        updatecart($ids, quantity, $count);
                } else if (quantity != '') {
                        $('#' + $ids).val('1');
                }
        });

        $('.login_checkout').click(function () {
                $.ajax({
                        type: "POST",
                        url: homeUrl + 'site/loginstatus',
                        data: {login: '1'},
                        success: function (data) {
                                if (data === '1') {
                                        location.reload();
                                } else {
                                        $('#Login').modal('show');
                                }
//
                        }
                });
        });
        $('.checkout_check').click(function () {
                var count = $('#cart_count').val();
                useraddress(count);
        });

        $('body').on('click', '.continue_shipping', function (e) {
                e.preventDefault();
                showLoader();
                var data = $('#shipping_id').serialize();
                var billing = $('#billing').val();
                if (billing === "") {
                        var first_name = $('#useraddress-first_name').val();
                        var last_name = $('#useraddress-last_name').val();
                        var address = $('#useraddress-address').val();
                        var city_id = $('#useraddress-city_id').val();
                        if (first_name === '' || last_name === '' || address === '' || city_id === '') {
                                alert('Fill the Field');
                                hideLoader();
                        } else {
                                ship_bill_address(data);
                        }
                } else {
                        ship_bill_address(data);
                }



        });
        $('body').on('click', '.continue_billing', function (e) {
                e.preventDefault();
                showLoader();
                var data = $('#shipping_id').serialize();
                var billing = $('#billing').val();
                if (billing === "") {
                        var first_name = $('#useraddress-first_name').val();
                        var last_name = $('#useraddress-last_name').val();
                        var address = $('#useraddress-address').val();
                        var city_id = $('#useraddress-city_id').val();
                        if (first_name === '' || last_name === '' || address === '' || city_id === '') {
                                alert('Fill the Field');
                                hideLoader();
                        } else {
                                bill_address(data);
                        }
                } else {
                        bill_address(data);
                }



        });
        $('body').on('change', '#useraddress-city_id', function () {
                var city = $(this).val();
                $.ajax({
                        url: homeUrl + 'cart/street',
                        type: "post",
                        data: {city: city},
                        success: function (data) {
                                var $data = JSON.parse(data);
                                if ($data.msg === "success") {
//                $('.change_category').removeAttr('disabled');

                                        $('#useraddress-street_id').html('').html($data.field);
//                $('#products-category').html('').html($data.val);
                                        hideLoader();
                                } else {
                                        alert('Internal Error');
                                        hideLoader();
                                }
                        }, error: function () {

                        }
                });
        });
        /***************Remove Item from cart********************/
        $('body').on('click', '.remove_cart', function () {
                showLoader();
                var $id = $(this).attr('data-product_id');
                var $count = $('#cart_count').val();
                $('.error_' + $id).html('');
                $.ajax({
                        url: homeUrl + 'cart/cart_remove',
                        type: "post",
                        data: {id: $id, count: $count},
                        success: function (data) {
                                var $data = JSON.parse(data);
                                if ($data.msg === "success") {
                                        getcartcount();
                                        $('.tr_' + $id).remove();
                                        getcartcount();
//                    if ($data.content !== '0') {
//                        $('.cart_item').remove();
//                        $('.cart_table').prepend($data.content);
//                    }
                                        $('.cart_subtotal').html($data.subtotal + '<span class="woocommerce-Price-currencySymbol"> AED</span>');
                                        $('.grand_total').html($data.grandtotal + '<span class="woocommerce-Price-currencySymbol"> AED</span>');
                                        hideLoader();
                                }
                        }, error: function () {
                                $('.error_' + $id).html('Cannot Find');
                        }
                });
        });

});
/******************************************************************/
function bill_address(data) {
        $.ajax({
                type: "POST",
                url: homeUrl + 'cart/add-billing',
                data: data,
                success: function (data) {
                        var $data = JSON.parse(data);
                        if ($data.msg === "success") {
                                $('#checkout').modal('hide');
                                $('#ordermaster-bill_address_id').val($data.id);
                                hideLoader();
                                $('.proceed-to-checkout').addClass('hide');
                                $('.confirm-checkout').removeClass('hide');
                                $('#order_master_form').attr('action', 'checkout');
                        }
//
                }
        });
}
function ship_bill_address(data) {
        var count = $('#cart_count').val();
        $.ajax({
                type: "POST",
                url: homeUrl + 'cart/add-shipping',
                data: data,
                success: function (data) {
                        var $data = JSON.parse(data);
                        if ($data.msg === "success") {
                                if ($data.delivery === '') {
//                    alert('Shipping Address Added Successfully');
                                        $("#checkout").hide();
                                        // Show the div after 1s
                                        $("#checkout").delay(1000).fadeIn(100);
                                        $('#ordermaster-ship_address_id').val($data.id);
                                        useraddress(count);
                                        $('#shipping_id')[0].reset();
                                        $('.section__title').html('Billing Address');
                                        $('#billing').val('');
                                        $('#billing').prop('disabled', false);
                                        $('.new_address_area').css({'display': 'none'});
                                        $('.delivery_address').html('');
                                        $('#proceed_to_checkout').removeClass('continue_shipping');
                                        $('#proceed_to_checkout').addClass('continue_billing');
                                        hideLoader();
                                } else {
                                        $('#checkout').modal('hide');
                                        $('#ordermaster-ship_address_id').val($data.id);
                                        $('#ordermaster-bill_address_id').val($data.id);
                                        $('.proceed-to-checkout').addClass('hide');
                                        $('.confirm-checkout').removeClass('hide');
//                    $('#order_master_form').attr('action', 'checkout');
                                        hideLoader();
//                    location.reload();
                                }
//                        $('#checkout').modal('toggle');
                        }
//
                }
        });
}
function useraddress(count) {
        $.ajax({
                type: "POST",
                url: homeUrl + 'cart/useraddress',
                data: {login: '1', 'count': count},
                success: function (data) {
                        var $data = JSON.parse(data);
                        if ($data.msg === "success") {
                                $('#billing').html('').html($data.addres_field);
                                $('#checkout').modal('show');
                                hideLoader();
                        } else {
                                location.reload();
                        }
//
                }
        });
}

function findstock(id, quantity) {
        $.ajax({
                type: "POST",
                url: homeUrl + 'cart/findstock',
                data: {cartid: id, quantity: quantity},
                success: function (data) {
                        var $data = JSON.parse(data);
                        if ($data.msg === "success") {
                                $('.total_' + id).html($data.total + '<span class="woocommerce-Price-currencySymbol"> AED</span>');
                                $('#' + id).val($data.quantity);
                                hideLoader();
                        }
//
                }
        });
}
function updatecart(id, quantity, count) {
        $.ajax({
                type: "POST",
                url: homeUrl + 'cart/updatecart',
                data: {cartid: id, quantity: quantity, count: count},
                success: function (data) {
                        var $data = JSON.parse(data);
                        if ($data.msg === "success") {
                                getcartcount();
//                if ($data.content !== '0') {
//                    $('.cart_item').remove();
//                    $('.cart_table').prepend($data.content);
//                }
//                $('.cart_content').html($data.content);
                                $('.cart_subtotal').html($data.subtotal + '<span class="woocommerce-Price-currencySymbol"> AED</span>');
                                $('.grand_total').html($data.grandtotal + '<span class="woocommerce-Price-currencySymbol"> AED</span>');
                                hideLoader();
                        }
                }
        });
}
function getcartcount() {

        $.ajax({
                type: "POST",
                cache: 'false',
                async: false,
                url: homeUrl + 'cart/getcartcount',
                data: {}
        }).done(function (data) {
                $(".cart_count").html(data);
                $("#cart_count").val(data);
//        hideLoader();
        });
}
function getcarttotal() {

        $.ajax({
                type: "POST",
                cache: 'false',
                async: false,
                url: homeUrl + 'cart/getcarttotal',
                data: {}
        }).done(function (data) {

                $(".cart_amount").html(data);
//        hideLoader();
        });
}
function getcartdata() {
        showLoader();
        $.ajax({
                type: "POST",
                cache: 'false',
                async: false,
                url: homeUrl + 'cart/selectcart',
                data: {}
        }).done(function (data) {
                $(".shopping-cart-items").html(data);
                //$(".cart_box").show('fast');
                hideLoader();
        });
}
function addtocart(vendor_prdct, qty, action) {

        $.ajax({
                type: "POST",
                url: homeUrl + 'cart/buynow',
                data: {vendor_prdct: vendor_prdct, qty: qty}
        }).done(function (data) {
                $(".shopping-cart-items").html(data);
                $(".shopping-cart").css("display", "block");
                getcartcount();
                hideLoader();

        });
}
function showLoader() {
        $('.page-loading-overlay').removeClass('loaded');
}
function hideLoader() {
        $('.page-loading-overlay').addClass('loaded');
}


