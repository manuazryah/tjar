<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<style>
    .panel{
        padding: 20px 10px;
    }
</style>
<div>
    <h3>Add New Location</h3>
</div>
<div class="clearfix"></div>
<div class="panel panel-default">
    <div class="panel-body" style="padding-top:0px;">
        <div class="col-md-6">
            <div class="new-address-box">
                <?php $form = ActiveForm::begin(); ?>

                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'city')->dropDownList(['1' => 'city1', '2' => 'city2']) ?>
                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'street')->dropDownList(['1' => 'street1', '2' => 'street2']) ?>
                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'building_no')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'landline')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'postbox_no')->textInput() ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <?= $form->field($model, 'dafault_address')->checkBox() ?>

                </div>
                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                    <div class="form-group">
                        <?= Html::a('Discard', ['/settings/locations'], ['class' => 'btn btn-gray', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
                        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float: right;']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="col-md-6">
        </div>
    </div>
</div>