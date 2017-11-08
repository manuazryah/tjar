<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\User;
use common\models\Products;

/* @var $this yii\web\View */

$this->title = 'Order Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .tab-content{
        background: #f9f9f9 !important;
    }
    .nav.nav-tabs>li>a {
        background-color: #f9f9f9;
    }
    .nav.nav-tabs>li {
        background: #f9f9f9;
    }
    .nav.nav-tabs>li.active>a {
        background-color: #f9f9f9 !important;
    }
    .nav.nav-tabs.nav-tabs-justified, .nav-tabs-justified .nav.nav-tabs {
        background: #f9f9f9;
    }
    .nav.nav-tabs>li>a:hover {
        background-color: #f9f9f9;
    }
    .nav-tabs {
        border-bottom: 1px solid #f9f9f9 !important;
    }
    .hidden-xs{
        padding-left: 5px;
    }
</style>
<div class="products-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <div class="" style="border: none">

                        <div class="row">

                            <div class="col-md-12">

                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#all-order" data-toggle="tab" aria-expanded="true">
                                            <span class="visible-xs"><i class="fa-home"></i></span>
                                            <i class="fa fa-th-list" aria-hidden="true"></i>
                                            <span class="hidden-xs">All Orders</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#confirm-order" data-toggle="tab" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa-user"></i></span>
                                            <i class="fa fa-th-list" aria-hidden="true"></i>
                                            <span class="hidden-xs">Confirmed</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#pending-order" data-toggle="tab" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa-envelope-o"></i></span>
                                            <i class="fa fa-th-list" aria-hidden="true"></i>
                                            <span class="hidden-xs">Pending</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#cancel-order" data-toggle="tab" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa-cog"></i></span>
                                            <i class="fa fa-th-list" aria-hidden="true"></i>
                                            <span class="hidden-xs">Canceled</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!--                                    <button class="btn btn-white" id="search-option" style="float: right;">
                                                                            <i class="linecons-search"></i>
                                                                            <span>Search</span>
                                                                        </button>-->
                                    <div class="tab-pane active" id="all-order">

                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
//                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                    'attribute' => 'order_id',
                                                    'format' => 'raw',
                                                    'value' => function ($data) {
                                                        if (isset($data->order_id)) {
                                                            return \yii\helpers\Html::a($data->order_id, ['/orders/order/view', 'id' => $data->order_id], ['target' => '_blank']);
                                                        } else {
                                                            return '';
                                                        }
                                                    },
                                                ],
                                                [
                                                    'attribute' => 'product_id',
                                                    'value' => function($data) {
                                                        $name = Products::findOne($data->product_id)->product_name;
                                                        return $name;
                                                    }
                                                ],
                                                'quantity',
                                                'amount',
//                                                'sub_total',
//
                                                [
                                                    'attribute' => 'status',
                                                    'format' => 'raw',
                                                    'filter' => ['0' => 'Pending', '1' => 'Confirm', '1' => 'Canceled'],
                                                    'value' => function ($data) {
                                                        return \yii\helpers\Html::dropDownList('status', null, ['0' => 'Pending', '1' => 'Confirm', '2' => 'Canceled'], ['options' => [$data->status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
                                                    },
                                                ],
                                                'delivered_date',
                                                [
                                                    'class' => 'yii\grid\ActionColumn',
                                                    'header' => 'Actions',
                                                    'template' => '{print}',
                                                    'buttons' => [
                                                        'print' => function ($url, $model) {
                                                            return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
                                                                        'title' => Yii::t('app', 'print'),
                                                                        'class' => '',
                                                                        'target' => '_blank',
                                                            ]);
                                                        },
                                                    ],
                                                    'urlCreator' => function ($action, $model) {
                                                        if ($action === 'print') {
                                                            $url = Url::to(['print', 'id' => $model->order_id]);
                                                            return $url;
                                                        }
                                                    }
                                                ],
                                            ],
                                        ]);
                                        ?>

                                    </div>
                                    <div class="tab-pane" id="confirm-order">
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider1,
//                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],
                                                'order_id',
                                                [
                                                    'attribute' => 'product_id',
                                                    'value' => function($data) {
                                                        $name = Products::findOne($data->product_id)->product_name;
                                                        return $name;
                                                    }
                                                ],
                                                'quantity',
                                                'amount',
//                                                'sub_total',
//
                                                [
                                                    'attribute' => 'status',
                                                    'format' => 'raw',
                                                    'filter' => ['0' => 'Pending', '1' => 'Confirm', '1' => 'Canceled'],
                                                    'value' => function ($data) {
                                                        return \yii\helpers\Html::dropDownList('status', null, ['0' => 'Pending', '1' => 'Confirm', '2' => 'Canceled'], ['options' => [$data->status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
                                                    },
                                                ],
                                                'delivered_date',
                                                [
                                                    'class' => 'yii\grid\ActionColumn',
                                                    'header' => 'Actions',
                                                    'template' => '{print}',
                                                    'buttons' => [
                                                        'print' => function ($url, $model) {
                                                            return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
                                                                        'title' => Yii::t('app', 'print'),
                                                                        'class' => '',
                                                                        'target' => '_blank',
                                                            ]);
                                                        },
                                                    ],
                                                    'urlCreator' => function ($action, $model) {
                                                        if ($action === 'print') {
                                                            $url = Url::to(['print', 'id' => $model->order_id]);
                                                            return $url;
                                                        }
                                                    }
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                    <div class="tab-pane" id="pending-order">
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider2,
//                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],
                                                'order_id',
                                                [
                                                    'attribute' => 'product_id',
                                                    'value' => function($data) {
                                                        $name = Products::findOne($data->product_id)->product_name;
                                                        return $name;
                                                    }
                                                ],
                                                'quantity',
                                                'amount',
//                                                'sub_total',
//
                                                [
                                                    'attribute' => 'status',
                                                    'format' => 'raw',
                                                    'filter' => ['0' => 'Pending', '1' => 'Confirm', '1' => 'Canceled'],
                                                    'value' => function ($data) {
                                                        return \yii\helpers\Html::dropDownList('status', null, ['0' => 'Pending', '1' => 'Confirm', '2' => 'Canceled'], ['options' => [$data->status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
                                                    },
                                                ],
                                                'delivered_date',
                                                [
                                                    'class' => 'yii\grid\ActionColumn',
                                                    'header' => 'Actions',
                                                    'template' => '{print}',
                                                    'buttons' => [
                                                        'print' => function ($url, $model) {
                                                            return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
                                                                        'title' => Yii::t('app', 'print'),
                                                                        'class' => '',
                                                                        'target' => '_blank',
                                                            ]);
                                                        },
                                                    ],
                                                    'urlCreator' => function ($action, $model) {
                                                        if ($action === 'print') {
                                                            $url = Url::to(['print', 'id' => $model->order_id]);
                                                            return $url;
                                                        }
                                                    }
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>

                                    <div class="tab-pane" id="cancel-order">
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider3,
//                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],
                                                'order_id',
                                                [
                                                    'attribute' => 'product_id',
                                                    'value' => function($data) {
                                                        $name = Products::findOne($data->product_id)->product_name;
                                                        return $name;
                                                    }
                                                ],
                                                'quantity',
                                                'amount',
//                                                'sub_total',
//
                                                [
                                                    'attribute' => 'status',
                                                    'format' => 'raw',
                                                    'filter' => ['0' => 'Pending', '1' => 'Confirm', '1' => 'Canceled'],
                                                    'value' => function ($data) {
                                                        return \yii\helpers\Html::dropDownList('status', null, ['0' => 'Pending', '1' => 'Confirm', '2' => 'Canceled'], ['options' => [$data->status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
                                                    },
                                                ],
                                                'delivered_date',
                                                [
                                                    'class' => 'yii\grid\ActionColumn',
                                                    'header' => 'Actions',
                                                    'template' => '{print}',
                                                    'buttons' => [
                                                        'print' => function ($url, $model) {
                                                            return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
                                                                        'title' => Yii::t('app', 'print'),
                                                                        'class' => '',
                                                                        'target' => '_blank',
                                                            ]);
                                                        },
                                                    ],
                                                    'urlCreator' => function ($action, $model) {
                                                        if ($action === 'print') {
                                                            $url = Url::to(['print', 'id' => $model->order_id]);
                                                            return $url;
                                                        }
                                                    }
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
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
        $('.admin_status_field').on('change', function () {
            var change_id = $(this).attr('id').match(/\d+/);
            var order_status = $(this).val();
            $.ajax({
                url: homeUrl + 'orders/order/change-order-status',
                type: "post",
                data: {status: order_status, id: change_id},
                success: function (data) {
                    alert('Status Changed Sucessfully');
                }, error: function () {
                }
            });
        });
    });
</script>

