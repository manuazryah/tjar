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
$('.order_detail').click(function () {
    showLoader();
    var id = $(this).attr('id');
    $('.detail_row').addClass('hide');
    $('#row_' + id).removeClass('hide');
    setTimeout(function () {
        hideLoader();
    }, 500);

});
$('.status_field').on('change', function () {
        showLoader();
        var change_id = $(this).attr('id').match(/\d+/);
        var vendor_status = $(this).val();
        $.ajax({
            url: homeUrl + 'orders/order/change-vendor-status',
            type: "post",
            data: {status: vendor_status, id: change_id},
            success: function (data) {
                alert('Status Changed Sucessfully');
                 hideLoader();
            }, error: function () {
                 hideLoader();
            }
        });
    });

    $('body').on('click', '.comment_submit', function () {
        $('.error').html('');
        var id = $(this).attr("id");
        var comment = $('#comment_box_' + id).val();
        if (comment !== '') {
        showLoader();
            $.ajax({
                url: homeUrl + 'orders/order/order-history-comment',
                type: "post",
                data: {comment: comment, id: id},
                success: function (data) {
                    var $data = JSON.parse(data);
                    if ($data.msg === "success") {
                        alert('Comment Successfully Added');
                        $('#modal-1').modal('hide');
                        $("ol").append("<li>" + comment + "</li>");
                        $('.comment_box').val('');
                        hideLoader();
//                        $.pjax.reload({container: '#order-detail_' + id});
//                            
                    } else {
                        alert('Sorry, Internal error');
                        hideLoader();
//                            $('#prdct_main_category').submit();
                    }
                }, error: function () {

                }
            });

        } else {
            $('.error').html('Cannot be Null');
        }
    });
/************************************/
$(function () {
    $('.modalButton').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr("value"));
    });


});

function showLoader() {
    $('.page-loading-overlay').removeClass('loaded');
}
function hideLoader() {
    $('.page-loading-overlay').addClass('loaded');
}


