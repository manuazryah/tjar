/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('.change_main_cat').change(function () {

        var id = $(this).attr('id');
        var main_category = $(this).val();
        main_category_cat(main_category, id);
    });
    $('.change_category').change(function () {

        var id = $(this).attr('id');
        var category = $(this).val();
        category_subcat(category, id);
    });
    $('.change_subcategory').change(function () {

        var id = $(this).attr('id');
        var category = $(this).val();
        subcategory_brand(category, id);
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
                $('#products-category').html('').html($data.val);
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
//                $('.change_subcategory').removeAttr('disabled');
                $('#products-subcategory').html('').html($data.val);
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
    $('.modalButton').click(function () {
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


