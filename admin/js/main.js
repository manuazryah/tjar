/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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


