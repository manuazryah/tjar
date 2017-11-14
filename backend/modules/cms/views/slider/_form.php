<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form-inline .form-group {
        min-height: 0px;
    }
</style>
<div class="slider-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'slider_image')->fileInput()->label('Slider Image (File Size : 1064x462)') ?>

    </div>

    <?php if (isset($model->slider_image)) { ?>
        <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
            <img src="<?= Yii::$app->homeUrl ?>../uploads/cms/slider/<?= $model->id ?>/large.<?= $model->slider_image; ?>?<?= rand() ?>" width="260" height="100" style="padding-bottom: 15px;"/>
        </div>
        <?php
    } elseif (!empty($model->slider_image)) {
        echo "";
    }
    ?>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'slider_image_arabic')->fileInput()->label('Slider Image Arabic (File Size : 1064x462)') ?>

    </div>
    <?php if (isset($model->slider_image_arabic)) { ?>
        <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
            <img src="<?= Yii::$app->homeUrl ?>../uploads/cms/slider/<?= $model->id ?>/large_arabic.<?= $model->slider_image_arabic; ?>?<?= rand() ?>" width="260" height="100" style="padding-bottom: 15px;"/>
        </div>
        <?php
    } elseif (!empty($model->slider_image_arabic)) {
        echo "";
    }
    ?>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'slider_link')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>

    </div>

    <div class='col-md-12 col-sm-12 col-xs-12' style="padding-left: 0px;">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
            <?php if (!empty($model->id)) { ?>
                <?= Html::a('Reset', ['index'], ['class' => 'btn btn-gray btn-reset', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
            <?php }
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
