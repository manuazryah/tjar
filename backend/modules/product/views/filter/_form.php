<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Filter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filter-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(common\models\ProductCategory::find()->all(), 'id', 'category_name'), ['prompt' => 'select category', 'class' => 'form-control change_category']) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?php $cat = []; ?>
        <?= $form->field($model, 'subcategory')->dropDownList($cat, ['prompt' => 'Select Sub Category', 'class' => 'form-control']) ?>
        
    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?php
        if (!$model->isNewRecord) {
            if (isset($model->filters)) {
                $model->filters = explode(',', $model->filters);
            }
        }
        ?>
        <?= $form->field($model, 'features')->dropDownList(ArrayHelper::map(\common\models\Features::find()->where(['status' => '1'])->all(), 'id', 'filter_tittle'), ['class' => 'form-control', 'id' => 'filter-filters', 'multiple' => 'multiple']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'comments')->textarea(['rows' => '4']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float: right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#filter-filters").select2({
            placeholder: '- select -',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#filter-category").select2({
            placeholder: '- Select Category',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#filter-subcategory").select2({
            placeholder: '- select -Sub Category',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
    });
</script>
