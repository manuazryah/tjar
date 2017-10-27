<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ProductBrand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-brand-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'main_category')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category']) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?php
        echo $form->field($model, 'category')->widget(DepDrop::classname(), [
            'options' => ['id' => 'productbrand-category'],
            'data' => ArrayHelper::map(\common\models\ProductCategory::find()->where(['category_id' => $model->main_category])->all(), 'id', 'category_name'),
            'pluginOptions' => [
                'depends' => ['productbrand-main_category'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-category/categories'])
            ]
        ]);
        ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?php
        echo $form->field($model, 'subcategory')->widget(DepDrop::classname(), [
            'data' => ArrayHelper::map(\common\models\ProductSubCategory::find()->where(['category_id' => $model->category])->all(), 'id', 'subcategory_name'),
            'pluginOptions' => [
                'depends' => ['productbrand-main_category', 'productbrand-category'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-sub-category/subcat'])
            ]
        ]);
        ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'brand_name')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'brand_name_arabic')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'comments')->textarea(['rows' => '4']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton('Create', ['id' => 'add_brand', 'class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $('#add_brand').click(function (event) {
        event.preventDefault();
        if (valid()) {
            var main_category = $('#productbrand-main_category').val();
            var category = $('#productbrand-category').val();
            var subcategory = $('#productbrand-subcategory').val();
            var brand_name = $('#productbrand-brand_name').val();
            var brand_name_arabic = $('#productbrand-brand_name_arabic').val();
            var comments = $('#productbrand-comments').val();
            var status = $('#productbrand-status').val();
            $.ajax({
                url: homeUrl + 'product/product-brand/ajaxcreate',
                type: "post",
                data: {main_category: main_category, category: category, subcategory: subcategory, brand_name: brand_name, brand_name_arabic: brand_name_arabic, status: status, comments: comments},
                success: function (data) {
                    var $data = JSON.parse(data);
                    if ($data.con === "1") {
                        $('#products-main_category').val(main_category);
                        $('#products-category').html($data.field_category);
                        $('#products-category').val(category);
                        $('#products-subcategory').html($data.field_subcat);
                        $('#products-subcategory').val(subcategory);
                         $('#products-brand').html($data.field);
                        $('#products-brand').val($data.id);
                         $('#products-brand').append($('<option value="' + $data.id + '" selected="selected">' + $data.name + '</option>'));
////               
                        $('#modal_brand').modal('toggle');
                        $('#products-category').removeAttr('disabled');
                        $('#products-subcategory').removeAttr('disabled');
                        $('#products-brand').removeAttr('disabled');
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
            if ($('#productbrand-main_category').val() === "" || $('#productbrand-category').val() === "" || $('#productbrand-subcategory').val() === "" || $('#productbrand-brand_name').val() === "" || $('#productbrand-brand_name_arabic').val() === "") {
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
