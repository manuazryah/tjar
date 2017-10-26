<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Street */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="street-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(common\models\City::find()->all(), 'id', 'city_name'), ['prompt' => 'Select City']) ?>
    </div>

    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'street_name')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'street_name_arabic')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
