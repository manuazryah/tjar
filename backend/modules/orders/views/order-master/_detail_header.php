<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\OrderMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-master-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>
    <div class="product-main-form">
        

        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php $user = \common\models\User::findOne($model->user_id) ?>
            <?= Html::button($user->first_name . ' ' . $user->last_name, ['value' => Url::to(['user-view', 'id' => $user->id]), 'class' => 'modalButton edit-btn']); ?>
        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?=
            Html::a('Print<span><i class="fa fa-print" aria-hidden="true"></i></span>', Url::to(['print-all', 'id' => $model->order_id]), [
                'title' => Yii::t('app', 'print'),
                'label' => 'Print',
                'class' => '',
                'target' => '_blank',]);
            ?>
        </div>
        <!--<div style="clear: both"></div>-->
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'admin_status')->dropDownList(['0' => 'Pending', '1' => 'Approved'])->label('') ?>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div><br>
