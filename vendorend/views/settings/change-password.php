<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change Password';
?>



<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                        </div>
                        <div class="panel-body">

                                <div class="panel-body"><div class="vendors-create">
                                                <?php
                                                $form = ActiveForm::begin(['id' => 'update-password',
                                                ]);
                                                ?>

                                                <div class='col-md-12 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'old_password')->textInput(['maxlength' => true]) ?>

                                                </div><div class='col-md-12 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>

                                                </div><div class='col-md-12 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'repeat_password')->textInput(['maxlength' => true]) ?>

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


<script>
        $(document).ready(function () {
                $('#vendors-old_password').on('blur', function () {
                        var old_pwd = $('#vendors-old_password').val();
                        if (old_pwd) {
                                $.ajax({
                                        type: 'POST',
                                        cache: false,
                                        data: {old_pwd: old_pwd},
                                        url: homeUrl + 'settings/check-password',
                                        success: function (data) {
                                                if (data == 0) {
                                                        if (!$(".help-block3")[0]) {
                                                                $("#vendors-old_password").after('<div class="help-block3" style="color:#cc3f44"> Incorrect Password.</div>');
                                                        } else {
                                                                $('.help-block3').empty();
                                                                $('.help-block3').append('Incorrect Password.');
                                                        }
                                                } else {
                                                        $('.help-block3').empty();
                                                }
                                        }
                                });
                        }
                });
                $(document).on('submit', '#update-password', function (e) {
                        var old_pwd = $('#vendors-old_password').val();
                        $.ajax({
                                url: homeUrl + 'settings/check-password',
                                'async': false,
                                'type': "POST",
                                'global': false,
                                data: {old_pwd: old_pwd},

                        })
                                .done(function (data) {
                                        if (data == 1) {
                                                return true;

                                        } else {
                                                e.preventDefault();
                                                return false;
                                        }
                                });
                        return true;
                });
        });
</script>