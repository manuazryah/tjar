<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->name, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


            </div>
            <div class="panel-body">
                <?php // Html::a('<i class="fa-th-list"></i><span> Manage Admin Users</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>

                <div class="panel-body">
                    <div class="employee-create">
                        <div class="col-lg-12" style="padding: 0px;">
                            <?php if (Yii::$app->session->hasFlash('succes')): ?>
                                <div class="alert alert-success" role="alert">
                                    <?= Yii::$app->session->getFlash('succes') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                        $form = ActiveForm::begin(
                                        [
                                            'id' => 'change-password',
                                            'method' => 'post',
                                            'options' => [
                                                'class' => 'login-form fade-in-effect'
                                            ]
                                        ]
                        );
                        ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'new_password')->passwordInput() ?>

                        <?= $form->field($model, 'confirm_password')->passwordInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton('Reset Password', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>