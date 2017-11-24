<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */

$this->title = 'Order History';
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
                                                                <?php yii\widgets\Pjax::begin(['id' => 'order-manage']); ?>

                                                                <ul class="nav nav-tabs">
                                                                        <li class="<?= $order_status == '' ? 'active' : '' ?>">
                                                                                <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">All Orders</span>', ['view', 'id' => $id,], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $order_status == 1 ? 'active' : '' ?>">
                                                                                <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Pending</span>', ['view', 'id' => $id, 'order_status' => 1], ['class' => '']) ?>
                                                                        </li>
                                                                        <li class="<?= $order_status == 2 ? 'active' : '' ?>">
                                                                                <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Approved</span>', ['view', 'id' => $id, 'order_status' => 2], ['class' => '']) ?>
                                                                        </li>
                                                                </ul>

                                                                <div class="tab-content">
                                                                        <div class="tab-pane active" id="">

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
                                                                                                                    return \yii\helpers\Html::a($data->order_id, ['/orders/order-master/order-details', 'id' => $data->id], ['target' => '_blank']);
                                                                                                            } else {
                                                                                                                    return '';
                                                                                                            }
                                                                                                    },
                                                                                                ],
                                                                                                'net_amount',
                                                                                                'order_date',
                                                                                                    [
                                                                                                    'attribute' => 'admin_status',
                                                                                                    'format' => 'raw',
                                                                                                    'filter' => ['0' => 'Pending', '1' => 'Approved'],
                                                                                                    'value' => function ($data) {
                                                                                                            if ($data->admin_status == 0) {
                                                                                                                    return 'Pending';
                                                                                                            } else if ($data->admin_status == 1) {
                                                                                                                    return 'Approved';
                                                                                                            }
                                                                                                    },
                                                                                                ],
                                                                                                    [
                                                                                                    'class' => 'yii\grid\ActionColumn',
                                                                                                    'header' => 'Actions',
                                                                                                    'template' => '{view}',
                                                                                                    'buttons' => [
                                                                                                        'view' => function ($url, $model) {
                                                                                                                return Html::a('<span><i class="fa fa-eye" aria-hidden="true"></i></span>', $url, [
                                                                                                                            'title' => Yii::t('app', 'view'),
                                                                                                                            'class' => '',
                                                                                                                ]);
                                                                                                        },
                                                                                                        'print' => function ($url, $model) {
                                                                                                                return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
                                                                                                                            'title' => Yii::t('app', 'print'),
                                                                                                                            'class' => '',
                                                                                                                            'target' => '_blank',
                                                                                                                ]);
                                                                                                        },
                                                                                                    ],
                                                                                                    'urlCreator' => function ($action, $model) {
                                                                                                            if ($action === 'view') {
                                                                                                                    $url = Url::to(['order-details', 'id' => $model->id]);
                                                                                                                    return $url;
                                                                                                            }
                                                                                                            if ($action === 'print') {
                                                                                                                    $url = Url::to(['print-all', 'id' => $model->order_id]);
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
                                                                <?php yii\widgets\Pjax::end(); ?>
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
                $(document).on('change', '.admin_status_field', function (e) {
                        var change_id = $(this).attr('id').match(/\d+/);
                        var admin_status = $(this).val();
                        $.ajax({
                                url: homeUrl + 'orders/order-master/change-admin-status',
                                type: "post",
                                data: {status: admin_status, id: change_id},
                                success: function (data) {
                                        alert('Status Changed Sucessfully');
                                        $.pjax.reload({container: '#order-manage'});
                                }, error: function () {
                                }
                        });
                });
//        $('.orders').on('click', function () {
//            $.pjax.reload({container: '#order-manage'});
//        });
        });
</script>
