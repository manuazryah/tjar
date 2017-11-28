/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/****price>offerprice*****/
$('#productvendor-offer_price').keyup(function () {
    $('#offer_price').addClass('hide');
    var offer = parseInt($(this).val());
    var price = parseInt($('#productvendor-price').val());
    if (price != '') {
        if (offer >= price) {
            $('#productvendor-offer_price').val('0.00');
            $('#offer_price').removeClass('hide');
        }
    }
});
$(function () {
    $('.modalButton').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr("value"));
    });


});


