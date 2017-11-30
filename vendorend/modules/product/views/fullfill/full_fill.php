<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */

$this->title = 'Order Full Filled by Tjar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">
    <?php
    yii\bootstrap\Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'modal',
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]);
    ?>
    <div id='modalContent'></div>;
    <?php yii\bootstrap\Modal::end(); ?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <div class="" style="border: none">
                        <div class="table-responsive" style="border: none">
                            <button class="btn btn-white" id="search-option" style="float: right;">
                                <i class="linecons-search"></i>
                                <span>Search</span>
                            </button>
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'rowOptions' => function ($model, $key, $index, $grid) {
                                    return ['id' => $model['id']];
                                },
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
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
                                        'attribute' => 'product_id',
                                        'format' => 'raw',
                                        'value' => function($model) {
                                            $product_vendor = \common\models\ProductVendor::findOne($model->product_id);
                                            if (!empty($product_vendor)) {
                                                $product_detail = common\models\Products::findOne($product_vendor->product_id);
                                                if (isset($product_detail->product_name)) {
                                                    $str= Html::tag('p', Html::encode(substr($product_detail->product_name, 0, 29)), ['title' => $product_detail->product_name, 'class' => 'username color']);
                                                    return $str;
                                                } else {
                                                    return '';
                                                }
                                            }
                                        },
                                        'filter' => ArrayHelper::map(common\models\ProductVendor::find()->where(['admin_status' => 2, 'full_fill' => 1, 'vendor_id' => Yii::$app->user->identity->id])->all(), 'id', 'productName'),
                                        'filterOptions' => array('id' => "product_name_search"),
                                    ],
                                    'quantity',
                                    'sub_total',
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'filter' => ['0' => 'Pending', '1' => 'Placed', '2' => 'Dispatched', '3' => 'Delivered'],
                                        'value' => function ($data) {
                                            if ($data->status == 0) {
                                                return 'Pending';
                                            } if ($data->status == 1) {
                                                return 'Placed';
                                            } if ($data->status == 2) {
                                                return 'Dispatched';
                                            } if ($data->status == 3) {
                                                return 'Delivered';
                                            }
                                        },
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'template' => '{track}',
                                        'buttons' => [
                                            'track' => function ($url, $model) {

                                                return Html::button('<i class="fa fa-truck"></i>', ['value' => Url::to(['/orders/order/track', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
                                            },
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });

        $('#product_name_search select').attr('id', 'full_fill_product');
        $("#full_fill_product").select2({
            placeholder: '',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
    });
</script>
