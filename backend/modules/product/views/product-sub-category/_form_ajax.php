<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ProductMainCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-main-category-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'main_category_id')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category']) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?php
        echo $form->field($model, 'category_id')->widget(DepDrop::classname(), [
            'options' => ['id' => 'productsubcategory-category_id'],
            'data' => ArrayHelper::map(\common\models\ProductCategory::find()->where(['category_id' => $model->main_category_id])->all(), 'id', 'subcategory_name'),
            'pluginOptions' => [
                'depends' => ['productsubcategory-main_category_id'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-category/categories'])
            ]
        ]);
        ?>
        <?php // $form->field($model, 'subcategory')->dropDownList(ArrayHelper::map(common\models\ProductSubCategory::find()->all(), 'id', 'subcategory_name'), ['prompt' => 'select subcategory']) ?>
    </div>

    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'subcategory_name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'canonical_name')->textInput(['maxlength' => true, 'readOnly' => true]) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'subcategory_name_arabic')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'comments')->textarea(['rows' => '4']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton('Create', ['id' => 'add_subcategory', 'class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $('#add_subcategory').click(function (event) {
        event.preventDefault();
        if (valid()) {
            var main_category_id = $('#productsubcategory-main_category_id').val();
//            var main_catname = $('#productsubcategory-main_category_id option:selected').text();
            var category_id = $('#productsubcategory-category_id').val();
//            var cat_name = $('#productsubcategory-category_id option:selected').text();
            var subcategory_name = $('#productsubcategory-subcategory_name').val();
            var canonical_name = $('#productsubcategory-canonical_name').val();
            var subcategory_name_arabic = $('#productsubcategory-subcategory_name_arabic').val();
            var comments = $('#productsubcategory-comments').val();
            var status = $('#productsubcategory-status').val();
            $.ajax({
                url: homeUrl + 'product/product-sub-category/ajaxcreate',
                type: "post",
                data: {main_category_id: main_category_id, category_id: category_id, subcategory_name: subcategory_name, canonical_name: canonical_name, subcategory_name_arabic: subcategory_name_arabic, status: status, comments: comments},
                success: function (data) {
                    var $data = JSON.parse(data);
                    if ($data.con === "1") {
                        $('#products-subcategory').html($data.field);
                        $('#products-main_category').val(main_category_id);
                        $('#products-category').html($data.field_category);
                        $('#products-category').val(category_id);
                        $('#products-subcategory').append($('<option value="' + $data.id + '" selected="selected">' + $data.name + '</option>'));
////               
                        $('#modal_subcategory').modal('toggle');
                        $('#products-category').removeAttr('disabled');
                        $('#products-subcategory').removeAttr('disabled');
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
            if ($('#productsubcategory-main_category_id').val() === "" || $('#productsubcategory-category_id').val() === "" || $('#productsubcategory-subcategory_name').val() === "" || $('#productsubcategory-canonical_name').val() === "" || $('#productsubcategory-subcategory_name_arabic').val() === "") {
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
        $('#productsubcategory-subcategory_name').keyup(function () {
            var name = slug($(this).val());
            $('#productsubcategory-canonical_name').val(slug($(this).val()));
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
