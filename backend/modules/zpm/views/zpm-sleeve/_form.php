<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ZpmSleeve */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zpm-sleeve-form form-inline">

         <?php $form = ActiveForm::begin(); ?>

   <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'main_category')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category', 'class' => 'form-control change_main_cat']) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'> 
        <?php
        $cat = [];
        if (!$model->isNewRecord) {
            $cat = ArrayHelper::map(common\models\ProductCategory::find()->where(['category_id' => $model->main_category, 'status' => '1'])->all(), 'id', 'category_name');
        }
        ?>
        <?= $form->field($model, 'category')->dropDownList($cat, ['prompt' => 'Select Category', 'class' => 'form-control change_category']) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>  
        <?php
        $subcat = [];
        if (!$model->isNewRecord) {
            $subcat = ArrayHelper::map(common\models\ProductSubCategory::find()->where(['category_id' => $model->category, 'status' => '1'])->all(), 'id', 'subcategory_name');
        }
        ?>
        <?= $form->field($model, 'subcategory')->dropDownList($subcat, ['prompt' => 'Select Sub Category']) ?>

    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>   
        <?= $form->field($model, 'canonical_name')->textInput(['maxlength' => true, 'readonly' => True]) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'value_arabic')->textInput(['maxlength' => true]) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>
    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float: right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $("#zpmsleeve-main_category").select2({
        placeholder: 'Select Main Category',
        allowClear: true
    }).on('select2-open', function ()
    {
        // Adding Custom Scrollbar
        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
    });
    $("#zpmsleeve-category").select2({
        placeholder: 'Select Category',
        allowClear: true
    }).on('select2-open', function ()
    {
        // Adding Custom Scrollbar
        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
    });
    $("#zpmsleeve-subcategory").select2({
        placeholder: 'Select Sub Category',
        allowClear: true
    }).on('select2-open', function ()
    {
        // Adding Custom Scrollbar
        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
    });
</script>
<script>
    $(document).ready(function () {
        $('#zpmsleeve-value').keyup(function () {
            $('#zpmsleeve-canonical_name').val(slug($(this).val()));
        });
        var slug = function (str) {
            var $slug = '';
            var trimmed = $.trim(str);
            $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
                    replace(/-+/g, '-').
                    replace(/^-|-$/g, '');
            return $slug.toLowerCase();
        };
    });
</script>