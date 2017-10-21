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
        <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category']) ?>
    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?php
        echo $form->field($model, 'subcategory')->widget(DepDrop::classname(), [
            'options' => ['id' => 'productbrand-subcategory'],
            'data' => ArrayHelper::map(\common\models\ProductSubCategory::find()->where(['category_id' => $model->category])->all(), 'id', 'subcategory_name'),
            'pluginOptions' => [
                'depends' => ['productbrand-category'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-sub-category/subcat'])
            ]
        ]);
        ?>
        <?php // $form->field($model, 'subcategory')->dropDownList(ArrayHelper::map(common\models\ProductSubCategory::find()->all(), 'id', 'subcategory_name'), ['prompt' => 'select subcategory']) ?>
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
