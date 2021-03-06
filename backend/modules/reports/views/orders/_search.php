<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-invoice-master-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    $model->createdFrom = $from;
    $model->createdTo = $to;
    ?>

    <div class="col-md-4" style="padding-left: 0px;">
        <?php
        echo '<label class="control-label" for="orderdetailssearch-createdTo" style="color:black">Created From</label>';
        echo DatePicker::widget([
            'model' => $model,
//            'form' => $form,
            'type' => DatePicker::TYPE_INPUT,
            'attribute' => 'createdFrom',
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]);
        ?>
    </div>
    <div class="col-md-4" style="padding-left: 0px;">
        <?php
        echo '<label class="control-label" for="orderdetailssearch-createdTo" style="color:black">Created To</label>';
        echo DatePicker::widget([
            'model' => $model,
//            'form' => $form,
            'type' => DatePicker::TYPE_INPUT,
            'attribute' => 'createdTo',
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]);
        ?>
    </div>

    <div class="col-md-4" style="margin-top: 23px;">
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
            <?php // Html::resetButton('Reset', ['class' => 'btn btn-default', 'style' => 'background-color: #e6e6e6;'])   ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
