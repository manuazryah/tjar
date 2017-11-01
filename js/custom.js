$(document).ready(function () {
    getcartcount();
//    getcarttotal();
    getcartdata();
    $(".add_to_cart").click(function () {
//        $("html, body").animate({
//            scrollTop: 0
//        }, 1500);
        var canname = $(this).attr('id');
//        var qty = $('.q_ty').val();
        var qty = '1';
        addtocart(canname, qty, 'add_to');
    });


});
function getcartcount() {

    $.ajax({
        type: "POST",
        cache: 'false',
        async: false,
        url: homeUrl + 'cart/getcartcount',
        data: {}
    }).done(function (data) {
        $(".cart_count").html(data);
        hideLoader();
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
        hideLoader();
    });
}
function getcartdata() {
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
function addtocart(canname, qty, action) {

    $.ajax({
        type: "POST",
        url: homeUrl + 'cart/buynow',
        data: {cano_name: canname, qty: qty}
    }).done(function (data) {


    });
}
