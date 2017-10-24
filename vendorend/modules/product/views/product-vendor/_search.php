<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductVendorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-vendor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'vendor_id') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'sku') ?>

    <?php // echo $form->field($model, 'offer_note') ?>

    <?php // echo $form->field($model, 'handling_time') ?>

    <?php // echo $form->field($model, 'pick_up_location') ?>

    <?php // echo $form->field($model, 'free_shipping') ?>

    <?php // echo $form->field($model, 'courier_handover') ?>

    <?php // echo $form->field($model, 'conditions') ?>

    <?php // echo $form->field($model, 'offer_price') ?>

    <?php // echo $form->field($model, 'full_fill') ?>

    <?php // echo $form->field($model, 'field1') ?>

    <?php // echo $form->field($model, 'field2') ?>

    <?php // echo $form->field($model, 'field3') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'CB') ?>

    <?php // echo $form->field($model, 'UB') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <?php // echo $form->field($model, 'DOU') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
