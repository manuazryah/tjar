<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'submit-complaint']);
?>
<div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Complaint</h4>
        </div>

        <div class="modal-body">





                <div class="row">
                        <div class="col-md-12">
                                <?= $form->field($model, 'user_id')->dropDownList(['' => '--Select--', '1' => 'Missing Information', '2' => 'Price issue', '3' => 'Images doeesnt match', '4' => 'Size chart issue', '5' => 'Product Details different from product', '6' => 'Incorrect information', '7' => 'Other'])->label(FALSE) ?>
                        </div>

                        <div class="col-md-12">
                                <?= $form->field($model, 'complaint')->textArea(['maxlength' => true, 'placeholder' => 'Complaint', 'required' => '', 'rows' => 4])->label(FALSE) ?>
                        </div>
                        <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(FALSE) ?>
                        <?= $form->field($model, 'product_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(FALSE) ?>
                        <?= $form->field($model, 'vendor_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(FALSE) ?>

                </div>



        </div>

        <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
</div>
<?php ActiveForm::end(); ?>


<style>
        .review-h5{
                font-size: 14px !important;
                color: #000 !important;
                font-weight: bold !important;
        }
</style>

