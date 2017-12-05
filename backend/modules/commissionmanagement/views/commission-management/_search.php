<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CommissionManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="commission-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'vendor_id') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'product_price') ?>

    <?php // echo $form->field($model, 'offer_price') ?>

    <?php // echo $form->field($model, 'commission') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <?php // echo $form->field($model, 'DOU') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
