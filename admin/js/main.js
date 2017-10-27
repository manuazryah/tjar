/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('.change_main_cat').change(function () {
       
        var id = $(this).attr('id');
        var main_category = $(this).val();
        main_category_(main_category, id);
    });
});
function main_category_(main_category, ids) {
    $.ajax({
        url: homeUrl + 'product/product-category/category',
//        url: 'category',
        type: "post",
        data: {main_cat: main_category},
        success: function (data) {
            var $data = JSON.parse(data);
            if ($data.con === "1") {
                $('.change_category').removeAttr('disabled');
                $('.change_category').html($data.val);
//                $(".change_category").select2({
//                    placeholder: 'Choose Category',
//                    allowClear: true
//                }).on('select2-open', function ()
//                {
//                    // Adding Custom Scrollbar
//                    $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
//                });
            }

//            $('#' + ids[0] + idr).html("").html(data);
//            $('#product-prcat ').html("").html(data);
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


