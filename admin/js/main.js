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


