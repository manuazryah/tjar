<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ZpmPatternSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zpm-pattern-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'main_category') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'subcategory') ?>

    <?= $form->field($model, 'value') ?>

    <?php // echo $form->field($model, 'value_arabic') ?>

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
