/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('body').on('change', '.change_main_cat', function () {
        var id = $(this).attr('id');
        var main_category = $(this).val();
        main_category_cat(main_category, id);
    });
    $('body').on('change', '.change_category', function () {
        var id = $(this).attr('id');
        var category = $(this).val();
        category_subcat(category, id);
    });
    $('body').on('change', '.change_subcategory', function () {

        var id = $(this).attr('id');
        var category = $(this).val();
        subcategory_brand(category, id);
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

    $(document).on('change', '.admin_status_field', function (e) {
        var change_id = $(this).attr('id').match(/\d+/);
        var admin_status = $(this).val();
        $.ajax({
            url: homeUrl + 'orders/order-master/change-admin-status',
            type: "post",
            data: {status: admin_status, id: change_id},
            success: function (data) {
                alert('Status Changed Sucessfully');
                $.pjax.reload({container: '#order-manage'});
            }, error: function () {
            }
        });
    });

    $('.status_field').on('change', function () {
        showLoader();
        var change_id = $(this).attr('id').match(/\d+/);
        var vendor_status = $(this).val();
        $.ajax({
            url: homeUrl + 'orders/order-master/change-vendor-status',
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

    $('body').on('click', '.order_comment', function () {
//            e.preventDefault();
        $('.comment_box').val('');
        $('.error').html('');
        var id = $(this).attr('id');
        $('#modal-1').modal('show');
        $('.comment_box').attr("id", id);
    });
    $('body').on('click', '.comment_submit', function () {
        $('.error').html('');
        var id = $(this).attr("id");
        var comment = $('#comment_box_' + id).val();
        if (comment !== '') {
            $.ajax({
                url: homeUrl + 'orders/order-master/order-history-comment',
                type: "post",
                data: {comment: comment, id: id},
                success: function (data) {
                    var $data = JSON.parse(data);
                    if ($data.msg === "success") {
                        alert('Comment Successfully Added');
                        $('#modal-1').modal('hide');
                        $("ol").append("<li>" + comment + "</li>");
                        $('.comment_box').val('');
//                        $.pjax.reload({container: '#order-detail_' + id});
//                            
                    } else {
                        alert('Sorry, Internal error');
//                            $('#prdct_main_category').submit();
                    }
                }, error: function () {

                }
            });

        } else {
            $('.error').html('Cannot be Null');
        }
    });



});
/****main ctegory to category*****/
function main_category_cat(main_category, ids) {
    showLoader();
    $.ajax({
        url: homeUrl + 'product/product-category/category',
//        url: 'category',
        type: "post",
        data: {main_cat: main_category},
        success: function (data) {
            var $data = JSON.parse(data);
            if ($data.con === "1") {
//                $('.change_category').removeAttr('disabled');
                var $ids = ids.split("-");
                if ($ids['1'] === 'main_category_id') {
                    var $form = 'category_id';
                } else {
                    var $form = 'category';
                }
                $('#' + $ids['0'] + '-' + $form).html('').html($data.val);
                $('#s2id_' + $ids['0'] + '-' + $form).select2('data', {id: '', text: 'Select Category'});
//                $('#products-category').html('').html($data.val);
                hideLoader();
            } else {
                alert('Internal Error');
                hideLoader();
            }
        }, error: function () {

        }
    }
    );





}
/****category to subcategory*****/
function category_subcat(category, ids) {
    showLoader();
    $.ajax({
        url: homeUrl + 'product/product-sub-category/subcategory',
//        url: 'category',
        type: "post",
        data: {category: category},
        success: function (data) {
            var $data = JSON.parse(data);
            if ($data.con === "1") {
                var $ids = ids.split("-");
                if ($ids['1'] === 'category_id') {
                    var $form = 'subcategory_id';
                } else {
                    var $form = 'subcategory';
                }
                $('#' + $ids['0'] + '-' + $form).html('').html($data.val);
                $('#s2id_' + $ids['0'] + '-' + $form).select2('data', {id: '', text: 'Select Sub Category'});
//                $('#products-subcategory').html('').html($data.val);
                hideLoader();
            } else {
                alert('Internal Error');
                hideLoader();
            }
        }, error: function () {

        }
    }
    );
}
/****Subcategory to brand*****/
function subcategory_brand(category, id) {
    showLoader();
    $.ajax({
        url: homeUrl + 'product/product-brand/brand',
//        url: 'category',
        type: "post",
        data: {category: category},
        success: function (data) {
            var $data = JSON.parse(data);
            if ($data.con === "1") {
//                $('.change_subcategory').removeAttr('disabled');
                $('#products-brand').html('').html($data.val);
                $('#s2id_products-brand').select2('data', {id: '', text: 'Select Brand'});
                hideLoader();
            } else {
                alert('Internal Error');
                hideLoader();
            }
        }, error: function () {

        }
    }
    );
}



$(function () {
    $(document).on('click', '.modalButton', function () {

        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr("value"));

    });


    /****seacrchtag**/
    $('.searchtag').click(function () {
        $('#modal_searchtag').modal('show')
                .find('#modalContent')
                .load($(this).attr("value"));
    });
    /****main category**/
    $('.main_cat').click(function () {
        $('#modal_maincat').modal('show')
                .find('#modalContent')
                .load($(this).attr("value"));
    });
    /****category**/
    $('.ajax_category').click(function () {
        $('#modal_category').modal('show')
                .find('#modalContent')
                .load($(this).attr("value"));
    });
    /****Subcategory**/
    $('.sub_category').click(function () {
        $('#modal_subcategory').modal('show')
                .find('#modalContent')
                .load($(this).attr("value"));
    });
    /****Brand**/
    $('.product_brand').click(function () {
        $('#modal_brand').modal('show')
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


