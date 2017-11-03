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


});
/******************************************************************/
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
