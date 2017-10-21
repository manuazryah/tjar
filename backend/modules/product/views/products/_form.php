<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'main_category')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category']) ?>
    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?php
        echo $form->field($model, 'category')->widget(DepDrop::classname(), [
            'options' => ['id' => 'products-category'],
            'data' => ArrayHelper::map(\common\models\ProductCategory::find()->where(['category_id' => $model->main_category])->all(), 'id', 'category_name'),
            'pluginOptions' => [
                'depends' => ['products-main_category'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-category/categories'])
            ]
        ]);
        ?>
    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?php
        echo $form->field($model, 'subcategory')->widget(DepDrop::classname(), [
            'options' => ['id' => 'products-subcategory'],
            'data' => ArrayHelper::map(\common\models\ProductSubCategory::find()->where(['category_id' => $model->category])->all(), 'id', 'subcategory_name'),
            'pluginOptions' => [
                'depends' => ['products-main_category', 'products-category'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-sub-category/subcat'])
            ]
        ]);
        ?>
    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'canonical_name')->textInput(['maxlength' => true]) ?>

    </div>

    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'brand')->textInput() ?>

    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'item_ean')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'gender')->textInput() ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'main_description')->textarea(['rows' => 6]) ?>

    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'related_products')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'search_tags')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

    </div>
    <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'meta_keyword')->textarea(['rows' => 6]) ?>

    </div>
    <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'gallery_images')->fileInput() ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
