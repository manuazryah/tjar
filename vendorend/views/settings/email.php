<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update Email';
?>



<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                        </div>
                        <div class="panel-body">

                                <div class="panel-body"><div class="vendors-create">
                                                <?php $form = ActiveForm::begin(); ?>

                                                <div class='col-md-12 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                                                </div>

                                                <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                                                        <div class="form-group">
                                                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;float: right;']) ?>
                                                        </div>
                                                </div>
                                                <?php ActiveForm::end(); ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>
