<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StockHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'products_id') ?>

    <?= $form->field($model, 'vendor_id') ?>

    <?= $form->field($model, 'productvendor_id') ?>

    <?= $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'total_stock') ?>

    <?php // echo $form->field($model, 'purpose') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
