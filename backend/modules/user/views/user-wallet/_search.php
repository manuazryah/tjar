<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserWalletSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-wallet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'type_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'entry_date') ?>

    <?php // echo $form->field($model, 'credit_debit') ?>

    <?php // echo $form->field($model, 'balance_amount') ?>

    <?php // echo $form->field($model, 'reference_id') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'field_2') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
