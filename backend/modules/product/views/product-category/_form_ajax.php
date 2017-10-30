<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ProductCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-category-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category']) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'category_name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'canonical_name')->textInput(['maxlength' => true, 'readOnly' => true]) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'category_name_arabic')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'comments')->textarea(['rows' => '4']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton('Create', ['id' => 'add_category', 'class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $('#add_category').click(function (event) {
        event.preventDefault();
        if (valid()) {
            var category_id = $('#productcategory-category_id').val();
            var catname = $('#productcategory-category_id option:selected').text();
            var category_name = $('#productcategory-category_name').val();
            var canonical_name = $('#productcategory-canonical_name').val();
            var category_name_arabic = $('#productcategory-category_name_arabic').val();
            var comments = $('#productcategory-comments').val();
            var status = $('#productcategory-status').val();
            $.ajax({
                url: homeUrl + 'product/product-category/ajaxcreate',
                type: "post",
                data: {category_id: category_id, category_name: category_name, canonical_name: canonical_name, category_name_arabic: category_name_arabic, status: status, comments: comments},
                success: function (data) {
                    var $data = JSON.parse(data);
                    if ($data.con === "1") {
//                        field
                        $('#products-category').html($data.field);
                        $('#products-main_category').append($('<option value="' + category_id + '" selected="selected">' + catname + '</option>'));
                        $('#s2id_products-main_category').select2('data', {id: category_id, text: catname});
                        $('#products-category').append($('<option value="' + $data.id + '" selected="selected">' + $data.name + '</option>'));
                        $('#s2id_products-category').select2('data', {id: $data.id, text: $data.name});
//               
                        $('#modal_category').modal('toggle');
                        $('#products-category').removeAttr('disabled');
                    } else {
                        alert($data.error);
                    }

                }, error: function () {

                }
            });
        } else {
            alert('Please fill the Field');
        }

    });
    var valid = function () { //Validation Function - Sample, just checks for empty fields
        var valid;
        $("input").each(function () {
            if ($('#productcategory-category_id').val() === "" || $('#productcategory-category_name').val() === "" || $('#productcategory-canonical_name').val() === "" || $('#productcategory-category_name_arabic').val() === "") {
                valid = false;
            }
        });
        if (valid !== false) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script>
    $(document).ready(function () {
        $('#productcategory-category_name').keyup(function () {
            var name = slug($(this).val());
            $('#productcategory-canonical_name').val(slug($(this).val()));
        });
    });

    var slug = function (str) {
        var $slug = '';
        var trimmed = $.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
                replace(/-+/g, '-').
                replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    }
    $("#productcategory-category_id").select2({
        placeholder: '- select Category',
        allowClear: true
    }).on('select2-open', function ()
    {
        // Adding Custom Scrollbar
        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
    });
</script>
