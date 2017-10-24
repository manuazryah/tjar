<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-vendor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->hiddenInput(['value' => $id])->label(false) ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sku')->textInput() ?>

    <?= $form->field($model, 'offer_note')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'handling_time')->dropDownList(['1' => 'Same Day', '2' => '2 Business days', '3' => '3 Business days'], ['prompt' => 'Please select from below']) ?>

    <?= $form->field($model, 'pick_up_location')->textInput() ?>

    <?= $form->field($model, 'free_shipping')->textInput() ?>

    <?= $form->field($model, 'courier_handover')->textInput() ?>

    <?= $form->field($model, 'conditions')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'offer_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_fill')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'style' => 'float: right;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
