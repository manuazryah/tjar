<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Features */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="features-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'filter_tittle')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'table_name')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'model_name')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'tablevalue__name')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'table_value_id')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'category')->textInput() ?>

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