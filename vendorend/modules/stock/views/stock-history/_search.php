<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-history-search">

        <?php
        $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
        ]);
        $model->createdFrom = $from;
        $model->createdTo = $to;
        ?>

        <div class="col-md-3" style="padding-left: 0px;">
                <?php
                $prdctvendor = \common\models\ProductVendor::find()->where(['vendor_id' => Yii::$app->user->identity->id])->all();
                foreach ($prdctvendor as $value) {
                        $product_array[] = $value->product_id;
                }
                ?>
                <?= $form->field($model, 'productvendor_id')->dropDownList(ArrayHelper::map(common\models\Products::find()->where(['in', 'id', $product_array])->all(), 'id', 'product_name'), ['prompt' => 'select Product', 'class' => 'form-control'])->label('Product Name'); ?>
        </div>
        <div class="col-md-3" style="padding-left: 0px;">
                <?php
//                echo DatePicker::widget([
//                    'model' => $model,
//                    'form' => $form,
//                    'type' => DatePicker::TYPE_INPUT,
//                    'attribute' => 'createdFrom',
//                    'pluginOptions' => [
//                        'autoclose' => true,
//                        'format' => 'yyyy-mm-dd',
//                    ]
//                ]);

                echo $form->field($model, 'createdFrom')->widget(DatePicker::className(), [
                    'type' => DatePicker::TYPE_INPUT,
                    'removeButton' => ['icon' => 'trash'],
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ])
                ?>
        </div>
        <div class="col-md-3" style="padding-left: 0px;">
                <?php
//                echo DatePicker::widget([
//                    'model' => $model,
//                    'form' => $form,
//                    'type' => DatePicker::TYPE_INPUT,
//                    'attribute' => 'createdTo',
//                    'pluginOptions' => [
//                        'autoclose' => true,
//                        'format' => 'yyyy-mm-dd',
//                    ]
//                ]);

                echo $form->field($model, 'createdTo')->widget(DatePicker::className(), [
                    'type' => DatePicker::TYPE_INPUT,
                    'removeButton' => ['icon' => 'trash'],
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ])
                ?>
        </div>

        <div class="col-md-2" style="margin-top: 23px;">
                <div class="form-group">
                        <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
                        <?php // Html::resetButton('Reset', ['class' => 'btn btn-default', 'style' => 'background-color: #e6e6e6;'])    ?>
                </div>
        </div>

        <?php ActiveForm::end(); ?>

</div>
