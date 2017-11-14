<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchTag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-tag-form form-inline">

        <?php $form = ActiveForm::begin(); ?>

        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
                <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(common\models\ProductCategory::find()->all(), 'id', 'category_name'), ['prompt' => 'select category', 'class' => 'form-control change_category']) ?>
        </div>
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
                <?php
                $subcat = [];
                if (!$model->isNewRecord) {
                        $subcat = ArrayHelper::map(common\models\ProductSubCategory::find()->where(['category_id' => $model->category, 'status' => '1'])->all(), 'id', 'subcategory_name');
                }
                ?>
                <?= $form->field($model, 'subcategory')->dropDownList($subcat, ['prompt' => 'Select Sub Category', 'class' => 'form-control']) ?>

        </div>
        <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
                <?= $form->field($model, 'tag_name')->textInput() ?>
        </div>
        <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
                <?= $form->field($model, 'tag_name_arabic')->textInput() ?>
        </div>

        <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
                <?= $form->field($model, 'canonical_name')->textInput(['readOnly' => true]) ?>
        </div>
        <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
                <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

        </div>
        <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
                </div>
        </div>

        <?php ActiveForm::end(); ?>

</div>

<script>
        $("#searchtag-category").select2({
                placeholder: 'Choose Category',
                allowClear: true
        }).on('select2-open', function ()
        {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#searchtag-subcategory").select2({
                placeholder: 'Choose Sub Category',
                allowClear: true
        }).on('select2-open', function ()
        {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
</script>

<script>
        $(document).ready(function () {
                $('#searchtag-tag_name').keyup(function () {
                        var name = slug($(this).val());
                        $('#searchtag-canonical_name').val(slug($(this).val()));
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