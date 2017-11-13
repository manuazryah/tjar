<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Products;
use yii\helpers\Url;
use common\components\ModalViewWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Wise Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .panel .panel-body {
        padding: 0;
        padding-top: 0px;
        color: #979898;
    }
</style>
<div class="order-details-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body" style="margin-top: 20px">
                    <div class="row" style="margin-left: 0px;margin-bottom: 20px;">
                        <div class="col-md-8" style="padding: 0px;">

                            <?= $this->render('item_search', ['model' => $searchModel, 'from' => $from, 'to' => $to]) ?>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <table cellspacing="0" class="table table-small-font table-bordered table-striped" style="">
                                    <tr>
                                        <th>Total Order</th>
                                        <th>Total Amount</th>
                                    </tr>
                                    <?php
//                                    $amount_total = common\models\OrderDetails::getTotal($from, $to, $searchModel->product_id, 'amount');
                                    $amount_total = common\models\OrderDetails::getTotal($item_data);
                                    ?>
                                    <tr>
                                        <td><?= $dataProvider->getTotalCount(); ?></td>
                                        <td><?= sprintf('%0.2f', $amount_total); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?= ModalViewWidget::widget() ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
                        'columns' => [
//                            ['class' => 'yii\grid\SerialColumn'],
//                            'id',
//                            'master_id',
                            [
                                'attribute' => 'order_id',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (isset($data->order_id)) {
                                        return \yii\helpers\Html::a($data->order_id, ['/orders/order-master/view', 'id' => $data->order_id], ['target' => '_blank']);
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            [
                                'attribute' => 'vendor_id',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (isset($data->vendor_id)) {
                                        $name = \common\models\Vendors::findOne($data->vendor_id)->first_name;
                                        return \yii\helpers\Html::a($name, ['/vendors/vendors/view', 'id' => $data->vendor_id], ['target' => '_blank']);
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            [
                                'attribute' => 'product_id',
                                'format' => 'raw',
                                'value' => function($data) {
                                    $product_data = Products::findOne($data->product_id);
                                    return \yii\helpers\Html::button($product_data->product_name, ['value' => Url::to(['/product/products/view', 'id' => $product_data->id]), 'class' => 'modalButton', 'style' => 'border: none;background: #f9f9f9;']);
                                }
                            ],
                            'quantity',
                            'amount',
                            // 'sub_total',
                            // 'delivered_date',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => ['0' => 'Pending', '1' => 'Confirm', '2' => 'Canceled'],
                                'value' => function ($data) {
                                    if ($data->status == 0) {
                                        return 'Pending';
                                    } elseif ($data->status == 1) {
                                        return 'Confirm';
                                    } elseif ($data->status == 2) {
                                        return 'Canceled';
                                    }
                                },
                            ],
                            [
                                'attribute' => 'DOC',
                                'label' => 'Order Date',
                                'value' => function($data) {
                                    return $data->DOC;
                                }
                            ],
//                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

