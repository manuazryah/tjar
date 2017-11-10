<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ProductMapping */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-mapping-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(common\models\ProductCategory::find()->all(), 'id', 'category_name'), ['prompt' => 'select category', 'class' => 'form-control']) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'subcategory')->dropDownList(ArrayHelper::map(common\models\ProductSubCategory::find()->all(), 'id', 'subcategory_name'), ['prompt' => 'select Subcategory', 'class' => 'form-control']) ?>

    </div>
    <?php
    if (!$model->isNewRecord && $model->product_id != '') {
        $model->product_id = explode(',', $model->product_id);
    }
    ?>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(common\models\Products::find()->all(), 'id', 'product_name'), ['prompt' => 'select Product', 'class' => 'form-control', 'multiple' => 'multiple']) ?>

    </div>
    <?php
    if (!$model->isNewRecord && $model->variants != '') {
        $model->variants = explode(',', $model->variants);
    }
    ?>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?php
//        $form->field($model, 'variants', ['template' => "<div class='overly'></div>\n{label}\n{input}\n{hint}\n{error}"]
//        )->dropDownList(ArrayHelper::map(\common\models\Features::findAll(['status' => 1]), 'id', 'filter_tittle'), ['options' => Yii::$app->SetValues->Selected($model->variants), 'prompt' => '-Choose Features-', 'multiple' => true])
        ?>
        <?= $form->field($model, 'variants')->dropDownList(ArrayHelper::map(common\models\Features::find()->all(), 'id', 'filter_tittle'), ['class' => 'form-control', 'multiple' => 'multiple']) ?>


    </div>
    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).ready(function () {
        $("#productmapping-category").select2({
            placeholder: 'Choose Category',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#productmapping-subcategory").select2({
            placeholder: 'Choose Category',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#productmapping-product_id").select2({
            placeholder: 'Choose Category',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#productmapping-variants").select2({
//            placeholder: 'Choose Category',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#productmapping-category").on('change', function () {
            var category_id = $(this).val();
            $.ajax({
                url: homeUrl + 'product/product-mapping/change-category',
                type: "post",
                data: {category: category_id},
                success: function (data) {
                    var res = $.parseJSON(data);
                    $('#productmapping-subcategory').html(res.result['subcategory']);
                    $('#productmapping-product_id').html(res.result['products']);
                }, error: function () {
                }
            });
        });
        $("#productmapping-subcategory").on('change', function () {
            var category_id = $("#productmapping-category").val();
            var subcategory_id = $(this).val();
            $.ajax({
                url: homeUrl + 'product/product-mapping/change-sbcategory',
                type: "post",
                data: {category: category_id, subcategory: subcategory_id},
                success: function (data) {
                    $('#productmapping-product_id').html(data);
                }, error: function () {
                }
            });
        });

//        jQuery("#productmapping-variants").on("change", function ($) {
//
//            var count = 0;
//            var principal = jQuery(this).val();
//            var last = principal[principal.length - 1];
//            for (var i = 0; i < this.options.length; i++)
//            {
//                var option = this.options[i];
//
//                option.selected ? count++ : null;
//                if (count == 2)
//                {
//                    jQuery("#productmapping-variants option[value='" + last + "']").prop("disabled", true);
//                    option.selected = false;
//                    option.disabled = true;
//                } else {
//                    option.disabled = false;
//                }
//            }
//        });

    });
</script>

