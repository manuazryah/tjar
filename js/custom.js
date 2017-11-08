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
    $('.cart_qty').on('change keyup', function () {
        showLoader();
        var quantity = this.value;
        var $ids = $(this).attr('id');
        console.log($ids);
        if (quantity != '' && parseInt(quantity) > '0') {
            findstock($ids, quantity);
            updatecart($ids, quantity);
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
        useraddress();
//        $.ajax({
//            type: "POST",
//            url: homeUrl + 'cart/useraddress',
//            data: {login: '1'},
//            success: function (data) {
//                var $data = JSON.parse(data);
//                if ($data.msg === "success") {
//                    $('#billing').html('').html($data.addres_field);
//                    $('#checkout').modal('show');
//                } else {
//                    location.reload();
//                }
////
//            }
//        });
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


});
/******************************************************************/
function ship_bill_address(data) {
    $.ajax({
        type: "POST",
        url: homeUrl + 'cart/add-address',
        data: data,
        success: function (data) {
            var $data = JSON.parse(data);
            if ($data.msg === "success") {
                if ($data.delivery === '') {
                    alert('Shipping Address Added Successfully');
//                    $('#checkout').modal('hide');
//                    $('#checkout').modal('show');
                    useraddress();
                        $('#shipping_id')[0].reset();
                        $('.section__title').html('Billing Address');
                        $('#billing').val('');
                        $('#billing').prop('disabled', false);
                        $('.new_address_area').css({'display': 'none'});
                        $('.delivery_address').html('');
                        hideLoader();
                } else {
                    location.reload();
                }
//                        $('#checkout').modal('toggle');
            }
//
        }
    });
}
function useraddress() {
    $.ajax({
        type: "POST",
        url: homeUrl + 'cart/useraddress',
        data: {login: '1'},
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
function updatecart(id, quantity) {
    $.ajax({
        type: "POST",
        url: homeUrl + 'cart/updatecart',
        data: {cartid: id, quantity: quantity},
        success: function (data) {
            var $data = JSON.parse(data);
            if ($data.msg === "success") {
                $('.cart_subtotal').html($data.subtotal + '<span class="woocommerce-Price-currencySymbol">AED</span>');
                $('.grand_total').html($data.grandtotal + '<span class="woocommerce-Price-currencySymbol">AED</span>');
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
