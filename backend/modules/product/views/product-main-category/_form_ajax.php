<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

s

/* @var $this yii\web\View */
/* @var $model common\models\ProductMainCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-main-category-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'canonical_name')->textInput(['maxlength' => true, 'readOnly' => true]) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'name_arabic')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'comments')->textarea(['rows' => '4']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton('Create', ['id' => 'add_maincategory', 'class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $('#add_maincategory').click(function (event) {
        event.preventDefault();
        if (valid()) {
            var name = $('#productmaincategory-name').val();
            var canonical_name = $('#productmaincategory-canonical_name').val();
            var name_arabic = $('#productmaincategory-name_arabic').val();
            var status = $('#productmaincategory-status').val();
            var comments = $('#productmaincategory-comments').val();
            $.ajax({
                url: homeUrl + 'product/product-main-category/ajaxcreate',
                type: "post",
                data: {name: name, canonical_name: canonical_name, name_arabic: name_arabic, comments: comments, status: status},
                success: function (data) {
                    var $data = JSON.parse(data);
                    if ($data.con === "1") {
                        $('#products-main_category').append($('<option value="' + $data.id + '" selected="selected" >' + $data.name + '</option>'));
                      
                        $('#modal_maincat').modal('toggle');
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
            if ($('#productmaincategory-name').val() === "" || $('#productmaincategory-canonical_name').val() === "" || $('#productmaincategory-name_arabic').val() === "" ) {
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
        $('#productmaincategory-name').keyup(function () {
            var name = slug($(this).val());
            $('#productmaincategory-canonical_name').val(slug($(this).val()));
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
</script>
