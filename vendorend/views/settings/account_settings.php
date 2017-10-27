<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
?>
<style>
        .panel{
                padding: 20px 10px;
        }
</style>
<div>
        <h3>Account Settings</h3>
</div>
<div class="clearfix"></div>
<div class="panel panel-default" id="account-settings">
        <div class="panel-body" style="padding-top:0px;">

                <div class="row section-title">
                        <div class="col-md-6">Name</div>

                </div>

                <div class="row row-padd">
                        <div class="col-md-4">
                                <?= $model->getAttributeLabel('first_name'); ?>
                        </div>

                        <div class="col-md-4">
                                <?= $model->first_name; ?>
                        </div>
                </div>

                <div class="row row-padd">
                        <div class="col-md-4">
                                <?= $model->getAttributeLabel('last_name'); ?>
                        </div>

                        <div class="col-md-4">
                                <?= $model->last_name; ?>
                        </div>
                </div>

                <div class="row row-padd">
                        <div class="col-md-4">
                                <?= $model->getAttributeLabel('username'); ?>
                        </div>

                        <div class="col-md-4">
                                <?= $model->username; ?>
                        </div>
                </div>


                <div class="row section-title">
                        <div class="col-md-6">Email</div>
                        <div class="col-md-6 edit"><?= Html::button('[ Edit ]', ['value' => Url::to('email'), 'class' => 'modalButton']) ?></div>

                </div>

                <div class="row row-padd">
                        <div class="col-md-4">
                                <?= $model->getAttributeLabel('email'); ?>
                        </div>

                        <div class="col-md-4">
                                <?= $model->email; ?>
                        </div>
                </div>

                <div class="row section-title">
                        <div class="col-md-6">Phone</div>
                        <div class="col-md-6 edit">
                                <?= Html::button('[ Edit ]', ['value' => Url::to('contact'), 'class' => 'modalButton']) ?>
                        </div>

                        <?php
                        Modal::begin([
                            'header' => '',
                            'id' => 'modal',
                            'size' => 'modal-lg',
                        ]);
                        echo "<div id = 'modalContent'></div>";
                        Modal::end();
                        ?>
                </div>

                <div class="row row-padd">
                        <div class="col-md-4">
                                <?= $model->getAttributeLabel('phone_number'); ?>
                        </div>

                        <div class="col-md-4">
                                <?= $model->phone_number; ?>
                        </div>
                </div>

                <div class="row row-padd">
                        <div class="col-md-4">
                                <?= $model->getAttributeLabel('mobile_number'); ?>
                        </div>

                        <div class="col-md-4">
                                <?= $model->mobile_number; ?>
                        </div>
                </div>


                <div class="row section-title">
                        <div class="col-md-6">Password</div>
                        <div class="col-md-6 edit"><?= Html::button('[ Edit ]', ['value' => Url::to('change-password'), 'class' => 'modalButton']) ?></div>
                </div>

                <div class="row row-padd">

                        <div class="col-md-4">
                                <?= '*******' ?>
                        </div>
                </div>

        </div>
</div>


