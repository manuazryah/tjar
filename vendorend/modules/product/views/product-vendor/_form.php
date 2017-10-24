<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-vendor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'vendor_id')->textInput() ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sku')->textInput() ?>

    <?= $form->field($model, 'offer_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'handling_time')->textInput() ?>

    <?= $form->field($model, 'pick_up_location')->textInput() ?>

    <?= $form->field($model, 'free_shipping')->textInput() ?>

    <?= $form->field($model, 'courier_handover')->textInput() ?>

    <?= $form->field($model, 'conditions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'offer_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_fill')->textInput() ?>

    <?= $form->field($model, 'field1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'CB')->textInput() ?>

    <?= $form->field($model, 'UB')->textInput() ?>

    <?= $form->field($model, 'DOC')->textInput() ?>

    <?= $form->field($model, 'DOU')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
