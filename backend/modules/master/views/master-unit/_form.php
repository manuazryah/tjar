<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MasterUnit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-unit-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'value_arabic')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-6 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12' style="float:right;">
        <div class="form-group" style="float: right;">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
