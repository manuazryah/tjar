<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MenuManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'main_menu') ?>

    <?= $form->field($model, 'main_menu_arabic') ?>

    <?= $form->field($model, 'sub_menu') ?>

    <?php // echo $form->field($model, 'sub_menu_arabic') ?>

    <?php // echo $form->field($model, 'sub_menu_link') ?>

    <?php // echo $form->field($model, 'child_menu') ?>

    <?php // echo $form->field($model, 'child_menu_arabic') ?>

    <?php // echo $form->field($model, 'child_menu_link') ?>

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
