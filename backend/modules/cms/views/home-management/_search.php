<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HomeManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="home-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'image_1') ?>

    <?= $form->field($model, 'image_1_arabic') ?>

    <?php // echo $form->field($model, 'link_1') ?>

    <?php // echo $form->field($model, 'image_2') ?>

    <?php // echo $form->field($model, 'image_2_arabic') ?>

    <?php // echo $form->field($model, 'link_2') ?>

    <?php // echo $form->field($model, 'image_3') ?>

    <?php // echo $form->field($model, 'image_3_arabic') ?>

    <?php // echo $form->field($model, 'link_3') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

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
