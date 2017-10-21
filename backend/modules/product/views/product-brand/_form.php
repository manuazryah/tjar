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

    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'main_category')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category']) ?>
    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
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
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?php
        echo $form->field($model, 'subcategory')->widget(DepDrop::classname(), [
            'pluginOptions' => [
                'depends' => ['productbrand-main_category', 'productbrand-category'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-sub-category/subcat'])
            ]
        ]);
        ?>
    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'brand_name')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
            <?php if (!empty($model->id)) { ?>
                <?= Html::a('Reset', ['index'], ['class' => 'btn btn-gray btn-reset', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
            <?php }
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
