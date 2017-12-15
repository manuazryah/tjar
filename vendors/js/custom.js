

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
/**/

$('.add_unit').click(function () {
    var unit = $(this).attr('attr_id');
    $('.modal-title').attr('field_id', unit);
});


$('#product-main_category').change(function () {
    var $ids = $(this).attr('id');
    var ids = $ids.split('-');
    var main_category = $(this).val();
//    var main_category = $('input:radio[name="Product[main_category]"]:checked').val();
    main_category_(main_category, ids);

});
$('#subcategory-main_category').click(function () {
    var $ids = $(this).attr('id');
    var ids = $ids.split('-');
    var main_category = $(this).val();
//    var main_category = $('input:radio[name="SubCategory[main_category]"]:checked').val();
    main_category_(main_category, ids);

});

$("#product-category").change(function () {
    $.ajax({
//            url: $base_url + 'event_item/select_event',
        url: 'subcategory',
        type: "post",
        data: {category: this.value},
        success: function (data) {

            $('#product-subcategory ').html("").html(data);
        }, error: function () {

        }
    });
});
//$('#product-sort').keyup(function () {
//    var sort = $(this).val();
//});


var valid = function () { //Validation Function - Sample, just checks for empty fields
    var valid;
    $("input").each(function () {
        if ($('#subcategory-category').val() === "") {
            var a = $(this).val();
            valid = false;
        }
    });
    if (valid !== false) {
        return true;
    } else {
        return false;
    }
}
//    });
//});

function main_category_(main_category, ids) {
    $.ajax({
        url: homeUrl + 'product/product/category',
//        url: 'category',
        type: "post",
        data: {main_cat: main_category},
        success: function (data) {
            if (ids[0] === 'subcategory') {
                var idr = '-category_id';
            } else {
                var idr = '-category';
            }
            $('#' + ids[0] + idr).html("").html(data);
            $('#product-prcat ').html("").html(data);
        }, error: function () {

        }
    }
    );
}