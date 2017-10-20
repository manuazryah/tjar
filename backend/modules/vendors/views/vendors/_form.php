<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Vendors */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vendors-form form-inline">
        <?php
        if (!$model->isNewRecord) {

        }
        ?>
        <?php $form = ActiveForm::begin(); ?>

        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        </div>
        <?php if ($model->isNewRecord) { ?>
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                </div>
        <?php } ?>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'post_code')->textInput() ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'bank_account_details')->textarea(['rows' => 1]) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>     <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12' style="float:right;">
                <div class="form-group" style="float: right;">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
                </div>
        </div>

        <?php ActiveForm::end(); ?>

</div>


<!---------------------------------staff password reset-------------------------->
<div class="modal" id="modal-reset">
        <div class="modal-dialog" style="z-index: 99999;">
                <div class="modal-content">
                        <form id="reset_password_form">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Reset Password</h4>
                                </div>

                                <div class="modal-body">
                                        <div class="row">
                                                <input type="hidden" id="user_id" value="">
                                                <div class="col-md-6">
                                                        <div class="form-group">
                                                                <input type="text" class="form-control some_class" id="new-password" name="new-password" required="required" placeholder="New Password">
                                                        </div>
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-group">
                                                                <input type="text" class="form-control some_class" id="confirm-password" name="confirm-password" required="required" placeholder="Confirm Password">
                                                                <div class="mismatch_error" style="color: rgba(255, 0, 0, 0.78);"></div>
                                                        </div>

                                                </div>
                                        </div>

                                </div>

                                <div class="modal-footer" style="border: none;">
                                        <!--                                        <button type="button" class="btn btn-info" id="addFollowupsubmit">Submit</button>-->
                                        <input  type="submit" class="btn btn-success" value="Submit">
                                </div>
                        </form>
                </div>
        </div>
</div>