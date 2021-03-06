<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Products;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Management -  Full Filled by TJAR';
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
    .color{
        color: #373e4a;
    }
</style>
<div class="order-master-index">
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

                        <div class="row">

                            <div class="col-md-12">
                                <?php yii\widgets\Pjax::begin(['id' => 'order-manage']); ?>
                                <ul class="nav nav-tabs">
                                    <li class="<?= $order_status == '' ? 'active' : '' ?>">
                                        <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">All Orders</span>', ['view-more', 'id' => $id], ['class' => '']) ?>
                                    </li>
                                    <li class="<?= $order_status == 1 ? 'active' : '' ?>">
                                        <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Awaiting Action</span>', ['view-more', 'id' => $id, 'order_status' => 1], ['class' => '']) ?>
                                    </li>
                                    <li class="<?= $order_status == 2 ? 'active' : '' ?>">
                                        <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Placed</span>', ['view-more', 'id' => $id, 'order_status' => 2], ['class' => '']) ?>
                                    </li>
                                    <li class="<?= $order_status == 3 ? 'active' : '' ?>">
                                        <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Dispatched</span>', ['view-more', 'id' => $id, 'order_status' => 3], ['class' => '']) ?>
                                    </li>
                                    <li class="<?= $order_status == 4 ? 'active' : '' ?>">
                                        <?= Html::a('<span class="visible-xs"><i class="fa-home"></i></span><i class="fa fa-th-list" aria-hidden="true"></i><span class="hidden-xs">Delivered</span>', ['view-more', 'id' => $id, 'order_status' => 4], ['class' => '']) ?>
                                    </li>
                                </ul>
                                <div class="table-responsive" style="border: none">
                                    <button class="btn btn-white" id="search-option" style="float: right;">
                                        <i class="linecons-search"></i>
                                        <span>Search</span>
                                    </button>
                                    <?=
                                    GridView::widget([
                                        'dataProvider' => $dataProvider,
//                                            'filterModel' => $searchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            'order_id',
                                            [
                                                'attribute' => 'product_id',
                                                'format' => 'raw',
                                                'value' => function($data) {

                                                    $vendor_product = \common\models\ProductVendor::findOne($data->product_id);
                                                    $product_details = Products::findOne($vendor_product->product_id);
                                                    return Html::tag('p', Html::encode(substr($product_details->product_name, 0, 29)), ['title' => $product_details->product_name, 'class' => 'username color']);
//                                                    return $product_details->product_name;
                                                }
                                            ],
                                            'quantity',
                                            'amount',
//                                                'sub_total',
//
                                            [
                                                'attribute' => 'status',
                                                'format' => 'raw',
                                                'filter' => $filter,
                                                'value' => function ($data)use ($order_status) {
                                                    if (($order_status == '1') || ($order_status == '' && $data->status == '0')) {
                                                        $filter = ['0' => 'Pending', '1' => 'Placed', '2' => 'Dispatched', '3' => 'Delivered'];
                                                    } else {
                                                        $filter = ['1' => 'Placed', '2' => 'Dispatched', '3' => 'Delivered'];
                                                    }
                                                    return \yii\helpers\Html::dropDownList('status', null, $filter, ['options' => [$data->status => ['Selected' => 'selected']], 'class' => 'form-control admin_status_field', 'id' => 'order_admin_status-' . $data->id,]);
                                                },
                                            ],
                                            'delivered_date',
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'header' => 'Actions',
                                                'template' => '{print}{comment}{track}',
                                                'buttons' => [
                                                    'print' => function ($url, $model) {
                                                        return Html::a('<span><i class="fa fa-print" aria-hidden="true"></i></span>', $url, [
                                                                    'title' => Yii::t('app', 'print'),
                                                                    'class' => '',
                                                                    'target' => '_blank',
                                                        ]);
                                                    },
                                                    'comment' => function ($url, $model) {
                                                        if ($model->status != '0' && $model->status != '3') {
//                                                            return \yii\bootstrap\Button::widget(["label" => "Create", "options" => ["class" => ""]]);
                                                            return Html::a('<span><i class="fa-file-text-o"></i></span>', 'javascript:void(0)', [
                                                                        'title' => 'Comment',
                                                                        'class' => 'order_comment',
                                                                        'id' => $model->id,
                                                            ]);
//                                                                return '<span title="comment" class="order_comment" id="' . $model->id . '"><i class="fa-file-text-o" aria-hidden="true"></i></span>';
                                                        }
                                                    },
                                                    'track' => function ($url, $model) {

                                                        return Html::button('<i class="fa fa-truck"></i>', ['value' => Url::to(['track', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
                                                    },
                                                ],
                                                'urlCreator' => function ($action, $model) {
                                                    if ($action === 'print') {
                                                        $url = Url::to(['print', 'id' => $model->order_id]);
                                                        return $url;
                                                    } else {
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
<div class="modal fade" id="modal-1">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 25px 30px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <textarea rows="3" cols="70" placeholder="Add Your Comment" class="comment_box"></textarea>
            </div>
            <span class="error"></span>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info comment_submit">Add Comment</button>
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
            var vendor_status = $(this).val();
            $.ajax({
                url: homeUrl + 'orders/order-master/change-vendor-status',
                type: "post",
                data: {status: vendor_status, id: change_id},
                success: function (data) {
                    alert('Status Changed Sucessfully');
                }, error: function () {
                }
            });
        });
        

    });
</script>

