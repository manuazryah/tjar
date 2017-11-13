<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-details-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <div class="row" style="margin-left: 0px;margin-bottom: 20px;">
                        <div class="col-md-6" style="padding: 0px;">

                            <?= $this->render('_search', ['model' => $searchModel, 'from' => $from, 'to' => $to]) ?>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <table cellspacing="0" class="table table-small-font table-bordered table-striped" style="">
                                    <tr>
                                        <th>Total Order</th>
                                        <th>Total Amount</th>
                                    </tr>
                                    <?php
                                    $amount_total = common\models\OrderMaster::getTotal($from, $to, 'net_amount');
                                    ?>
                                    <tr>
                                        <td><?= $dataProvider->getTotalCount(); ?></td>
                                        <td><?= sprintf('%0.2f', $amount_total); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
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
                                'attribute' => 'user_id',
                                'format' => 'raw',
                                'filter' => ArrayHelper::map(User::find()->all(), 'id', 'first_name'),
                                'value' => function ($data) {
                                    $name = User::findOne($data->user_id);
                                    return \yii\helpers\Html::a($name->first_name . ' ' . $name->last_name, ['/user/user/update', 'id' => $data->user_id], ['target' => '_blank']);
                                },
                            ],
                            'net_amount',
                            'order_date',
                            // 'ship_address_id',
                            // 'bill_address_id',
                            // 'currency_id',
                            // 'user_comment:ntext',
                            // 'payment_mode',
                            // 'admin_comment',
                            [
                                'attribute' => 'admin_status',
                                'format' => 'raw',
                                'filter' => ['0' => 'Pending', '1' => 'Approved'],
                                'value' => function ($data) {
                                    return $data->admin_status == 0 ? 'Pending' : 'Approved';
                                },
                            ],
//                            [
//                                'class' => 'yii\grid\ActionColumn',
////                                    'contentOptions' => ['style' => 'width:100px;'],
//                                'header' => 'Actions',
//                                'template' => '{view}{print}',
//                                'buttons' => [
//                                    'view' => function ($url, $model) {
//                                        return Html::a('<span><i class="fa fa-eye" aria-hidden="true"></i></span>', $url, [
//                                                    'title' => Yii::t('app', 'view'),
//                                                    'class' => '',
//                                        ]);
//                                    },
//                                    'print' => function ($url, $model) {
////                                            if ($model->status == 4) {
//                                        return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
//                                                    'title' => Yii::t('app', 'print'),
//                                                    'class' => '',
//                                                    'target' => '_blank',
//                                        ]);
////                                            }
//                                    },
//                                ],
//                                'urlCreator' => function ($action, $model) {
//                                    if ($action === 'view') {
//                                        $url = Url::to(['view', 'id' => $model->order_id]);
//                                        return $url;
//                                    }
//                                    if ($action === 'print') {
//                                        $url = Url::to(['print', 'id' => $model->order_id]);
//                                        return $url;
//                                    }
//                                }
//                            ],
                        ],
                    ]);
                    ?>
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
    });
</script>

