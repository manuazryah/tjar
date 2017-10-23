<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ZpmScreenSize */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zpm-screen-size-form form-inline">

        <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-12 col-sm-6 col-xs-12 left_padd'> 
        <?= $form->field($model, 'main_category')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category']) ?>

    </div>
    <div class='col-md-12 col-sm-6 col-xs-12 left_padd'> 
        <?php
        echo $form->field($model, 'category')->widget(DepDrop::classname(), [
            'options' => ['id' => 'zpmscreensize-category'],
            'data' => ArrayHelper::map(\common\models\ProductCategory::find()->where(['category_id' => $model->main_category])->all(), 'id', 'category_name'),
            'pluginOptions' => [
                'depends' => ['zpmscreensize-main_category'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-category/categories'])
            ]
        ]);
        ?>
    </div>
    <div class='col-md-12 col-sm-6 col-xs-12 left_padd'>  
        <?php
        echo $form->field($model, 'subcategory')->widget(DepDrop::classname(), [
            'pluginOptions' => [
                'depends' => ['zpmscreensize-main_category', 'zpmscreensize-category'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-sub-category/subcat'])
            ]
        ]);
        ?>
    </div>
    <div class='col-md-12 col-sm-6 col-xs-12 left_padd'>    
        <?= $form->field($model, 'value')->textInput(['maxlength' => true])->label('Value (<i>in Inch</i>)') ?>
    </div>
    <div class='col-md-12 col-sm-6 col-xs-12 left_padd'>    
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>
    </div>
    <div class='col-md-12 col-sm-6 col-xs-12' style="float:right;">
        <div class="form-group" style="float: right;">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
