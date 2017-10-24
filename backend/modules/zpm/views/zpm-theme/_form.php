<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ZpmTheme */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zpm-theme-form form-inline">

        <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'main_category')->dropDownList(ArrayHelper::map(common\models\ProductMainCategory::find()->all(), 'id', 'name'), ['prompt' => 'select category']) ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'> 
        <?php
        echo $form->field($model, 'category')->widget(DepDrop::classname(), [
            'options' => ['id' => 'zpmtheme-category'],
            'data' => ArrayHelper::map(\common\models\ProductCategory::find()->where(['category_id' => $model->main_category])->all(), 'id', 'category_name'),
            'pluginOptions' => [
                'depends' => ['zpmtheme-main_category'],
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
                'placeholder' => 'Select...',
                'url' => Url::to(['/product/product-sub-category/subcat'])
            ]
        ]);
        ?>
    </div>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    
        <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
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
